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
            <li class="breadcrumb-item active" aria-current="page">Publicidad</li>
        </ol>
    </nav>
    <!-- Breadcrumb Area End-->
    <h3 align="center">Lista de Publicidades</h3>
    <div class="col-md-12">
        <div class="col-md-12">
            @if (verificarAcceso(115))
                <a href="{{ url('sisadmin/publicidad/create/') }}" class="btn btn-primary btn-sm" id="btnNuevo"><i class="fa fa-plus"></i> Agregar</a>
            @else
                <a href="#" class="btn btn-primary btn-sm disabled"  ><i class="fa fa-plus"></i> Agregar</a>
            @endif
        <br>
        <div class="content" id="contenidoLista">
            <table class="table table-hover table-responsive-xl table-sm" id="tablaContenido">
                <thead>
                <tr>
                    <th>
                        N°
                    </th>
                    <th>
                        Nombre
                    </th>
                    <th>
                        Fecha desde
                    </th>
                    <th>
                        Fecha Hasta
                    </th>
                    <th>
                        Imagen
                    </th>
                    <th width="7%">
                        Publicar
                    </th>
                     <th width="15%">
                        Acciones
                    </th>
                </tr>
                </thead>
                <tbody>
                @php
                    $indice = 1;
                @endphp
                @foreach ($lista as $item)
                    <tr>
                        <td>
                            {{$indice++}}
                        </td>
                        <td>
                            {{$item->nombre}}
                        </td>
                        <td>
                             {{date('d/m/Y',strtotime($item->fecha_desde))}}
                        </td>
                        <td>
                              {{date('d/m/Y',strtotime($item->fecha_hasta))}}
                        </td>
                        <td>
                             {{
                               Html::image(asset('storage/uploads/'.$item->imagen), 'Sin Imagen', array('id'=>'imagen', 'class' =>'img-thumbnail','width'=>'100'))
                             }}
                        </td>
                        <td>
                            @if (verificarAcceso(118))
                                {{
                                   Form::select('publicar',$publicar,$item->publicar,['class'=>'form-control form-control-sm','id'=>'publicar','onchange'=>"cambiarPublicar('$item->pub_id',this.value);"])
                                }}
                            @else
                                {{$publicar[$item->publicar]}}
                            @endif
                        </td>
                        <td>
                            @if (verificarAcceso(117))
                                @if ($item->estado == 'AC')
                                    <a href="{{ url('sisadmin/publicidad/edit/'.$item->pub_id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Editar</a>
                                @endif
                                @if ($item->estado != 'AC')
                                 @endif
                            @else
                                @if ($item->estado == 'AC')
                                    <a href="#" class="btn btn-primary btn-sm disabled"><i class="fa fa-edit"></i> Editar</a>
                                @endif
                                @if ($item->estado != 'AC')
                                 @endif
                            @endif

                             @if (verificarAcceso(119))
                                @if ($item->estado == 'AC')
                                <button type="button" class="btn btn-danger btn-sm" onclick="modificarEstado('{{$item->pub_id}}','{{$item->nombre}}','inhabilitar');"><i class="fa fa-trash"></i> Inhabilitar</button>
                                @endif
                                @if ($item->estado != 'AC')
                                    <button type="button" class="btn btn-success btn-sm" onclick="modificarEstado('{{$item->pub_id}}','{{$item->nombre}}','habilitar');"><i class="fa fa-trash"></i> Habilitar</button>
                                @endif
                            @else
                                @if ($item->estado == 'AC')
                                    <button type="button" class="btn btn-danger btn-sm disabled" ><i class="fa fa-trash"></i> Inhabilitar</button>
                                @endif
                                @if ($item->estado != 'AC')
                                    <button type="button" class="btn btn-success btn-sm disabled" ><i class="fa fa-trash"></i> Habilitar</button>
                                @endif
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {{ $lista->links() }}
            </div>
        </div>
      </div>
    </div>
@endsection

@section('footer_scripts')
    <script type="text/javascript">
        $(document).ready(function(){
        });

        function modificarEstado(pub_id,solicitante,texto)
        {
            var mensajeConsulta = '¿Desea '+texto+' la publicidad: '+solicitante+'?';
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
                                url : '{{url("sisadmin/publicidad/_modificarEstado")}}',
                                data : {
                                    pub_id:pub_id,
                                    texto:texto
                                },
                                type : 'POST',
                                success : function(resp) {
                                    console.log(resp);
                                    if(resp.res == true){
                                        toastr.success('Operación completada','');
                                        location.reload(true);
                                    }else{
                                        toastr.error('Ocurrio un error al eliminar la publicacion','');
                                    }
                                },
                                error : function(xhr, status) {
                                    toastr.error('Ocurrio un error al eliminar la publicacion','');
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

        function cambiarPublicar(pub_id,publicar){
            console.log(pub_id+' '+publicar);
            loaderR.showPleaseWait();
            $.ajax({
                url : '{{url("sisadmin/publicidad/_cambiarPublicar")}}',
                data : {
                    pub_id:pub_id,
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
