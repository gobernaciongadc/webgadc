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
            <li class="breadcrumb-item active" aria-current="page">Mi unidad</li>
            <li class="breadcrumb-item active" aria-current="page">Video sonido</li>
        </ol>
    </nav>
    <!-- Breadcrumb Area End-->
    <div class="row justify-content-center">
        <h3 align="center">Videos Y Audios: {{$unidad->nombre}}</h3>
        <div class="col-md-12">
            <div class="col-md-12">
                    @if (verificarAcceso(14))
                        <a href="{{ url('sisadmin/videosonido/create/'.$und_id) }}" class="btn btn-primary btn-sm" id="btnNuevo"><i class="fa fa-plus"></i> Agregar</a>
                    @else
                        <a href="#" class="btn btn-primary btn-sm disabled" ><i class="fa fa-plus"></i> Agregar</a>
                    @endif
                <br>
                <div class="content" id="contenidoLista">
                    <table class="table table-hover table-responsive-xl table-sm" id="tablaContenido">
                        <thead>
                        <tr>
                            <th>N° </th>
                            <th>Titulo</th>
                            <th>Descripcion</th>
                            <th>Fecha</th>
                            <th>Publicar</th>
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
                                    {{$item->descripcion}}
                                </td>
                                <td>
                                    {{date('d/m/Y',strtotime($item->fecha))}}
                                </td>
                                <td>
                                    @if (verificarAcceso(5))
                                     {{
                                        Form::select('publicar',$publicar,$item->publicar,['class'=>'form-control form-control-sm','id'=>'publicar','onchange'=>"cambiarPublicar('$item->vis_id',this.value);"])
                                     }}
                                     @else
                                          {{$publicar[$item->publicar]}}
                                     @endif
                                </td>
                                <td>
                                    @if (verificarAcceso(15))
                                        <a href="{{ url('sisadmin/videosonido/edit/'.$item->vis_id.'/'.$und_id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Editar</a>
                                    @else
                                        <a href="#" class="btn btn-primary btn-sm disabled"><i class="fa fa-edit"></i> Editar</a>
                                    @endif
                                    @if (verificarAcceso(17))      
                                        <button type="button" class="btn btn-danger btn-sm" onclick="modificarEstado('{{$item->vis_id}}','{{$item->titulo}}');"><i class="fa fa-trash"></i> Eliminar</button>
                                    @else
                                        <button type="button" class="btn btn-danger btn-sm" onclick="modificarEstado('{{$item->vis_id}}','{{$item->titulo}}');"><i class="fa fa-trash"></i> Eliminar</button>
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
        function modificarEstado(vis_id,titulo,texto)
        {
            var mensajeConsulta = '¿Desea eliminar el video sonido: '+titulo+'?';
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
                                url : '{{url("sisadmin/videosonido/_modificarEstado")}}',
                                data : {
                                    vis_id:vis_id,
                                    texto:texto
                                },
                                type : 'POST',
                                success : function(resp) {
                                    console.log(resp);
                                    if(resp.res == true){
                                        toastr.success('Operación completada','');
                                        location.reload(true);
                                    }else{
                                        toastr.error('Ocurrio un error al eliminar el video o sonido : '+nombre+'','');
                                    }
                                },
                                error : function(xhr, status) {
                                    toastr.error('Ocurrio un error el video o sonido : '+nombre+'','');
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

        function cambiarPublicar(vis_id,publicar){
            console.log(vis_id+' '+publicar);
            loaderR.showPleaseWait();
            $.ajax({
                url : '{{url("sisadmin/videosonido/_cambiarPublicar")}}',
                data : {
                    vis_id:vis_id,
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
