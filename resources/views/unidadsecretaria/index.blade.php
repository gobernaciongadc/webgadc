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
            <li class="breadcrumb-item active" aria-current="page">Organización / Secretaría</li>
        </ol>
    </nav>
    <!-- Breadcrumb Area End-->
    <div class="row justify-content-center">
        <h3 align="center">Lista de Secretarías</h3>
                <div class="col-md-12">
                    <div class="col-md-12">
                @if (verificarAcceso(76))
                    <a href="{{ url('sisadmin/unidadsecretaria/create') }}" class="btn btn-primary btn-sm" id="btnNuevo"><i class="fa fa-plus"></i> Agregar</a>
                @else
                    <a href="#" class="btn btn-primary btn-sm disabled" id="btnNuevo"><i class="fa fa-plus"></i> Agregar</a>
                @endif

                        <br>
                        <div class="content" id="contenidoLista">
                            <table class="table table-hover table-responsive-xl table-sm" id="tablaContenido">
                                <thead>
                                <tr>
                                    <th>N° </th>
                                    <th>Nombre</th>
                                    <th>Mision</th>
                                    <th>Objetivo</th>
                                    <th>Lugar</th>
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
                                            {{$item->mision}}
                                        </td>
                                        <td>
                                            {{$item->objetivo}}
                                        </td>
                                        <td>
                                            {{$item->lugar}}
                                        </td>
                                        <td>
                                            @if (verificarAcceso(76))
                                                @if ($item->estado == 'AC')
                                                    <a href="{{ url('sisadmin/unidadsecretaria/edit/'.$item->und_id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Editar</a>
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
                                            @if (verificarAcceso(78))
                                                @if ($item->estado == 'AC')
                                                    <button type="button" class="btn btn-danger btn-sm" onclick="modificarEstado('{{$item->und_id}}','{{$item->nombre}}','inhabilitar');"><i class="fa fa-trash"></i> Inhabilitar</button>
                                                @endif
                                                @if ($item->estado != 'AC')
                                                    <button type="button" class="btn btn-success btn-sm" onclick="modificarEstado('{{$item->und_id}}','{{$item->nombre}}','habilitar');"><i class="fa fa-trash"></i> Habilitar</button>
                                                @endif
                                            @else
                                                @if ($item->estado == 'AC')
                                                    <button type="button" class="btn btn-danger btn-sm disabled" ></i> Inhabilitar</button>
                                                @endif
                                                @if ($item->estado != 'AC')
                                                    <button type="button" class="btn btn-success btn-sm disabled"><i class="fa fa-trash"></i> Habilitar</button>
                                                @endif
                                            @endif

                                            @if (verificarAcceso(79))
                                                <a href="{{ url('sisadmin/mapaorganigrama/create/'.$item->und_id) }}" class="btn btn-info btn-sm"><i class="fa fa-stamp"></i> Mapa Organigrama</a>
                                            @else
                                                <a href="#" class="btn btn-info btn-sm disabled"><i class="fa fa-stamp"></i> Mapa Organigrama</a>
                                            @endif
                                            <a href="{{ url('sisadmin/imagenunidadgaleria/'.$item->und_id.'/'.$ruta) }}" class="btn btn-warning btn-sm"><i class="fa fa-images"></i> Galeria de fotos</a>
                                            <a href="{{url('sisadmin/noticia/'.$item->und_id.'/lista')}}" class="btn btn-sm btn-primary" title="Noticias de la Unidad"><i class="fa fa-newspaper"></i></a>
                                            <a href="{{url('sisadmin/videosonido/'.$item->und_id)}}" class="btn btn-sm btn-secondary" title="Videos y Audios de la Unidad"><i class="fa fa-video"></i></a>
                                            <a href="{{url('sisadmin/convocatoria/'.$item->und_id.'/lista')}}" class="btn btn-sm btn-success" title="Convocatorias de la Unidad"><i class="fa fa-file-archive"></i></a>
                                            <a href="{{url('sisadmin/estadistica/'.$item->und_id.'/lista')}}" class="btn btn-sm btn-warning" title="Estadisticas de la Unidad"><i class="fa fa-chart-bar"></i></a>
                                            <a href="{{url('sisadmin/evento/'.$item->und_id.'/lista')}}" class="btn btn-sm btn-info" title="Eventos de la Unidad"><i class="fa fa-map-marked"></i></a>
                                            <a href="{{url('sisadmin/documentolegal/'.$item->und_id.'/lista')}}" class="btn btn-sm btn-primary" title="Documentos Legales de la Unidad"><i class="fa fa-balance-scale"></i></a>
                                            <a href="{{url('sisadmin/documento/'.$item->und_id.'/lista')}}" class="btn btn-sm btn-info" title="Documentos de la Unidad"><i class="fa fa-file-pdf"></i></a>
                                            <a href="{{url('sisadmin/publicacioncientifica/'.$item->und_id.'/lista')}}" class="btn btn-sm btn-warning" title="Publicaciones Científicas de la Unidad"><i class="fa fa-calculator"></i></a>
                                            <a href="{{url('sisadmin/guiatramite/'.$item->und_id.'/lista')}}" class="btn btn-sm btn-success" title="Guia de Tramites de la Unidad"><i class="fa fa-file-signature"></i></a>
                                            <a href="{{url('sisadmin/serviciopublico/'.$item->und_id.'/lista')}}" class="btn btn-sm btn-info" title="Servicios Públicos de la Unidad"><i class="fa fa-city"></i></a>
                                            <a href="{{url('sisadmin/programa/'.$item->und_id.'/lista')}}" class="btn btn-sm btn-warning" title="Programas de la Unidad"><i class="fa fa-book-reader"></i></a>
                                            <a href="{{url('sisadmin/producto/'.$item->und_id.'/lista')}}" class="btn btn-sm btn-primary" title="Productos de la Unidad"><i class="fa fa-cart-plus"></i></a>
                                            <a href="{{url('sisadmin/rendicioncuenta/'.$item->und_id.'/lista')}}" class="btn btn-sm btn-secondary" title="Rendición de Cuentas de la Unidad"><i class="fa fa-chalkboard-teacher"></i></a>
                                            <a href="{{url('sisadmin/proyecto/'.$item->und_id.'/lista')}}" class="btn btn-sm btn-success" title="Proyectos"><i class="fa fa-project-diagram"></i></a>
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

        function modificarEstado(und_id,nombre,texto)
        {
            var mensajeConsulta = '¿Desea '+texto+' la unidad:<br> '+nombre+'?';
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
                                url : '{{url("sisadmin/unidaddireccion/_modificarEstado")}}',
                                data : {
                                    und_id:und_id,
                                    texto:texto
                                },
                                type : 'POST',
                                success : function(resp) {
                                    console.log(resp);
                                    if(resp.res == true){
                                        toastr.success('Operación completada','');
                                        location.reload(true);
                                    }else{
                                        toastr.error('Ocurrio un error al '+texto+' el unidad: '+nombre+'','');
                                    }
                                },
                                error : function(xhr, status) {
                                    toastr.error('Ocurrio un error al '+texto+' el unidad: '+nombre+'','');
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

    </script>
@endsection
