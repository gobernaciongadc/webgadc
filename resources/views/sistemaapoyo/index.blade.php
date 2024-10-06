@extends('layouts.app')

@section('header_styles')
    <style type="text/css">

    </style>
@endsection
@section('content')
    <!-- Breadcrumb Area Start -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Administracion</li>
            <li class="breadcrumb-item active" aria-current="page">Sistemas de Apoyo</li>
        </ol>
    </nav>
    <!-- Breadcrumb Area End-->
    <div class="row justify-content-center">
        <h3 align="center">Lista de Sistemas de Apoyo</h3>
        <div class="col-md-12">
            <div class="col-md-12">
                    @if (verificarAcceso(111))
                        <a href="{{ url('sisadmin/sistemaapoyo/create/') }}" class="btn btn-primary btn-sm" id="btnNuevo"><i class="fa fa-plus"></i> Agregar</a>
                    @else
                        <a href="#" class="btn btn-primary btn-sm disabled"><i class="fa fa-plus"></i> Agregar</a>
                    @endif                                
                <br>
                <div class="content" id="contenidoLista">
                    <table class="table table-hover table-responsive-xl table-sm" id="tablaContenido">
                        <thead>
                        <tr>
                            <th>N° </th>
                            <th>Nombre</th>
                            <th>Link destino</th>
                            <th width="10%">Imagen</th>
                            <th width="8%">Publicar</th>
                            <th width="15%">Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $indice = 1;
                        @endphp
                        @foreach ($lista as $key => $item)
                            <tr>
                                <td>{{$lista->firstItem() + $key}}</td>
                                <td>
                                    {{$item->nombre}}
                                </td>
                                <td>
                                    {{$item->link_destino}}
                                </td>
                                <td>
                                    {{
                                       Html::image(asset('storage/uploads/'.$item->imagen), 'Sin Imagen', array('id'=>'imagen', 'class' =>'img-thumbnail','width'=>'90'))
                                    }}
                                </td>
                                <td>
                                    @if (verificarAcceso(113))
                                        {{
                                            Form::select('publicar',$publicar,$item->publicar,['class'=>'form-control form-control-sm','id'=>'publicar','onchange'=>"cambiarPublicar('$item->sia_id',this.value);"])
                                        }}
                                     @else
                                          {{$publicar[$item->publicar]}}
                                     @endif
                                </td>
                                <td>
                                    @if (verificarAcceso(112))
                                        <a href="{{ url('sisadmin/sistemaapoyo/edit/'.$item->sia_id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Editar</a>
                                    @else
                                        <a href="#" class="btn btn-primary btn-sm disabled"><i class="fa fa-edit"></i> Editar</a>
                                    @endif
                                    @if (verificarAcceso(114))                                    
                                        <button type="button" class="btn btn-danger btn-sm" onclick="modificarEstado('{{$item->sia_id}}','{{$item->nombre}}');"><i class="fa fa-trash"></i> Eliminar</button>
                                    @else
                                        <button type="button" class="btn btn-danger btn-sm disabled" ><i class="fa fa-trash"></i> Eliminar</button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center">
                        {{ $lista->appends(['searchtype'=>$searchtype,'search'=>$search,'sort'=>$sort])->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer_scripts')
    <script type="text/javascript">
        function modificarEstado(sia_id,nombre)
        {
            var mensajeConsulta = '¿Desea eliminar el sistema de apoyo:<br> '+nombre+'?';
            $.confirm({
                theme: 'modern',
                title: false,
                content: mensajeConsulta,
                buttons: {
                    SI: {
                        text: 'SI',
                        btnClass: 'btn-blue',
                        keys: ['enter'],
                        action: function(){
                            $.ajax({
                                url : '{{url("sisadmin/sistemaapoyo/_modificarEstado")}}',
                                data : {
                                    sia_id:sia_id
                                },
                                type : 'POST',
                                success : function(resp) {
                                    console.log(resp);
                                    if(resp.res == true){
                                        toastr.success('Operación completada','');
                                        location.reload(true);
                                    }else{
                                        toastr.error('Ocurrio un error al eliminar el sistema apoyo ','');
                                    }
                                },
                                error : function(xhr, status) {
                                    toastr.error('Ocurrio un error el sistemaapoyo','');
                                },
                                complete : function(xhr, status) {
                                }
                            });
                        }
                    },
                    NO: {
                        text: 'NO',
                        btnClass: 'btn-red',
                        action: function(){
                            //location.reload(true);
                        }
                    }
                }
            });
        }

        function cambiarPublicar(sia_id,publicar){
            console.log(sia_id+' '+publicar);
            loaderR.showPleaseWait();
            $.ajax({
                url : '{{url("sisadmin/sistemaapoyo/_cambiarPublicar")}}',
                data : {
                    sia_id:sia_id,
                    publicar:publicar
                },
                type : 'POST',
                success : function(resp) {
                    console.log(resp);

                },
                error : function(xhr, status) {
                    toastr.error('Ocurrio un error en la operación','');
                },
                complete : function(xhr, status) {
                    loaderR.hidePleaseWait();
                }
            });
        }


    </script>
@endsection
