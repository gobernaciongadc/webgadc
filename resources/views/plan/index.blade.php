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
            <li class="breadcrumb-item active" aria-current="page">Planes</li>
        </ol>
    </nav>
    <!-- Breadcrumb Area End-->
    <div class="row justify-content-center">
        <h3 align="center">Lista de Planes</h3>
        <div class="col-md-12">
            <div class="col-md-12">
                    @if (verificarAcceso(106))
                        <a href="{{ url('sisadmin/plan/create/') }}" class="btn btn-primary btn-sm" id="btnNuevo"><i class="fa fa-plus"></i> Agregar</a>
                    @else
                        <a href="#" class="btn btn-primary btn-sm disabled" id="btnNuevo"><i class="fa fa-plus"></i> Agregar</a>
                    @endif
                <br>
                <div class="content" id="contenidoLista">
                     <table class="table table-hover table-responsive-xl table-sm" id="tablaContenido">
                        <thead>
                        <tr>
                            <th>N° </th>
                            <th>Titulo</th>
                            <th>Periodo</th>
                            <th>Archivo</th>
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
                                    {{$item->titulo}}
                                </td>
                                <td>
                                    {{$item->periodo}}
                                </td>
                                <td>
                                    <a target="_blank" href="{{asset('storage/uploads/'.$item->link_descarga)}}"><i class="fa fa-download"></i> Descargar Archivo</a>
                                </td>
                                <td>
                                    {{
                                       Html::image(asset('storage/uploads/'.$item->imagen), 'Sin Imagen', array('id'=>'imagen', 'class' =>'img-thumbnail','width'=>'90'))
                                    }}
                                </td>
                                <td>
                                    @if (verificarAcceso(108))
                                        {{
                                            Form::select('publicar',$publicar,$item->publicar,['class'=>'form-control form-control-sm','id'=>'publicar','onchange'=>"cambiarPublicar('$item->pla_id',this.value);"])
                                        }}
                                     @else
                                          {{$publicar[$item->publicar]}}
                                     @endif
                                </td>
                                <td>
                                    @if (verificarAcceso(107))
                                        <a href="{{ url('sisadmin/plan/edit/'.$item->pla_id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Editar</a>
                                    @else
                                        <a href="#" class="btn btn-primary btn-sm disabled"><i class="fa fa-edit"></i> Editar</a>
                                    @endif

                                    @if (verificarAcceso(109))
                                        <button type="button" class="btn btn-danger btn-sm" onclick="modificarEstado('{{$item->pla_id}}','{{$item->titulo}}');"><i class="fa fa-trash"></i> Eliminar</button>
                                    @else
                                        <button type="button" class="btn btn-danger btn-sm disabled"><i class="fa fa-trash"></i> Eliminar</button>
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
        function modificarEstado(pla_id,nombre)
        {
            var mensajeConsulta = '¿Desea eliminar el plan: <br>'+nombre+'?';
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
                                url : '{{url("sisadmin/plan/_modificarEstado")}}',
                                data : {
                                    pla_id:pla_id
                                },
                                type : 'POST',
                                success : function(resp) {
                                    console.log(resp);
                                    if(resp.res == true){
                                        toastr.success('Operación completada','');
                                        location.reload(true);
                                    }else{
                                        toastr.error('Ocurrio un error al eliminar el plan ','');
                                    }
                                },
                                error : function(xhr, status) {
                                    toastr.error('Ocurrio un error el plan','');
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
        function cambiarPublicar(pla_id,publicar){
            console.log(pla_id+' '+publicar);
            loaderR.showPleaseWait();
            $.ajax({
                url : '{{url("sisadmin/plan/_cambiarPublicar")}}',
                data : {
                    pla_id:pla_id,
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
