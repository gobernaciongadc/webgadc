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
            <li class="breadcrumb-item active" aria-current="page">Organización / Despacho</li>
        </ol>
    </nav>
    <!-- Breadcrumb Area End-->
    <div class="row justify-content-center">
        <h3 align="center">Unidad Despacho</h3>
                <div class="col-md-12">
                    <div class="col-md-12">
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
                                        Mision
                                    </th>
                                    <th>
                                        Objetivo
                                    </th>
                                    <th>
                                        Lugar
                                    </th>
                                    <th width="22%">
                                        Acciones
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $indice = 1;
                                @endphp
                                    <tr>
                                        <td>{{$indice++}}</td>
                                        <td>{{$lista->nombre}}</td>
                                        <td>{{$lista->mision}}</td>
                                        <td>{{$lista->objetivo}}</td>
                                        <td>{{$lista->direccion}}</td>
                                        <td>
                                            @if (verificarAcceso(74))
                                                <a href="{{ url('sisadmin/unidaddespacho/edit/'.$lista->und_id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Editar</a>
                                            @else
                                                <a href="#" class="btn btn-primary btn-sm disabled"><i class="fa fa-edit"></i> Editar</a>                                            
                                            @endif
                                            <a href="{{ url('sisadmin/imagenunidadgaleria/'.$lista->und_id.'/'.$ruta) }}" class="btn btn-warning btn-sm"><i class="fa fa-images"></i> Galeria de fotos</a>
                                            <br>
                                            <a href="{{url('sisadmin/noticia/'.$lista->und_id.'/lista')}}" class="btn btn-sm btn-primary" title="Noticias de la Unidad"><i class="fa fa-newspaper"></i></a>
                                            <a href="{{url('sisadmin/videosonido/'.$lista->und_id)}}" class="btn btn-sm btn-secondary" title="Videos y Audios de la Unidad"><i class="fa fa-video"></i></a>
                                            <a href="{{url('sisadmin/convocatoria/'.$lista->und_id.'/lista')}}" class="btn btn-sm btn-success" title="Convocatorias de la Unidad"><i class="fa fa-file-archive"></i></a>
                                            <a href="{{url('sisadmin/estadistica/'.$lista->und_id.'/lista')}}" class="btn btn-sm btn-warning" title="Estadisticas de la Unidad"><i class="fa fa-chart-bar"></i></a>
                                            <a href="{{url('sisadmin/evento/'.$lista->und_id.'/lista')}}" class="btn btn-sm btn-info" title="Eventos de la Unidad"><i class="fa fa-map-marked"></i></a>
                                            <a href="{{url('sisadmin/documentolegal/'.$lista->und_id.'/lista')}}" class="btn btn-sm btn-primary" title="Documentos Legales de la Unidad"><i class="fa fa-balance-scale"></i></a>
                                            <a href="{{url('sisadmin/documento/'.$lista->und_id.'/lista')}}" class="btn btn-sm btn-info" title="Documentos de la Unidad"><i class="fa fa-file-pdf"></i></a>
                                            <a href="{{url('sisadmin/publicacioncientifica/'.$lista->und_id.'/lista')}}" class="btn btn-sm btn-warning" title="Publicaciones Científicas de la Unidad"><i class="fa fa-calculator"></i></a>
                                            <a href="{{url('sisadmin/guiatramite/'.$lista->und_id.'/lista')}}" class="btn btn-sm btn-success" title="Guia de Tramites de la Unidad"><i class="fa fa-file-signature"></i></a>
                                            <a href="{{url('sisadmin/serviciopublico/'.$lista->und_id.'/lista')}}" class="btn btn-sm btn-info" title="Servicios Públicos de la Unidad"><i class="fa fa-city"></i></a>
                                            <a href="{{url('sisadmin/programa/'.$lista->und_id.'/lista')}}" class="btn btn-sm btn-warning" title="Programas de la Unidad"><i class="fa fa-book-reader"></i></a>
                                            <a href="{{url('sisadmin/producto/'.$lista->und_id.'/lista')}}" class="btn btn-sm btn-primary" title="Productos de la Unidad"><i class="fa fa-cart-plus"></i></a>
                                            <a href="{{url('sisadmin/rendicioncuenta/'.$lista->und_id.'/lista')}}" class="btn btn-sm btn-secondary" title="Rendición de Cuentas de la Unidad"><i class="fa fa-chalkboard-teacher"></i></a>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                            <div class="d-flex justify-content-center">

                            </div>
                        </div>
                    </div>
        </div>
    </div>
@endsection

@section('footer_scripts')
    <script type="text/javascript">

        function eliminarImagenBanner(imu_id,und_id){

            var cantIma =  $("#cantidadimageneshay").val();
            if(cantIma>=2) {
                loaderR.showPleaseWait();
                $.ajax({
                    url: '{{url("sisadmin/unidaddespacho/_eliminarimagen_despacho")}}',
                    data: {
                        imu_id: imu_id,
                        und_id: und_id
                    },
                    type: 'POST',
                    success: function (resp) {
                        loaderR.hidePleaseWait();
                        console.log(resp);
                        $("#contenidoLista").html(resp);
                           toastr.success('Operación completada','');
                    },
                    error: function (xhr, status) {
                        loaderR.hidePleaseWait();
                            toastr.warning('No se pudo eliminar la imagen producto','');
                    },
                    complete: function (xhr, status) {

                    }
                });
            }else{
                toastr.warning('Como minimo debe de tener 2 imagenes para borrar 1 de las imagenes','');
            }

        }

    </script>
@endsection
