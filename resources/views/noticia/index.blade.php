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
        <li class="breadcrumb-item active" aria-current="page">Mi Unidad / Noticias</li>
    </ol>
</nav>
<!-- Breadcrumb Area End-->
<h3 align="center">Noticias: {{$unidad->nombre}}</h3>
<div class="col-md-12">
    {{--<form class="col-md-12" action="{{url('sisadmin/usuario/usuarios')}}" method="get">
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-1">
            <label for="search">Buscar por:</label>
        </div>
        <div class="col-md-2">
            {{
                        Form::select('searchtype',[1=>'Nombre',2=>'Correo'],$searchtype,  ['class' => 'form-control form-control-sm','id' => 'searchtype'])
                    }}
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control form-control-sm" placeholder="Ingrese su busqueda" id="search" name="search" value="{{$search}}">
        </div>
        <div class="col-md-1">
            <label>Ordenar por:</label>
        </div>
        <div class="col-md-2">
            {{
                        Form::select('sort',[1=>'Nombre'],$sort,  ['class' => 'form-control form-control-sm','id' => 'sort'])
                    }}
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-search"></i> Buscar</button>
        </div>

    </div>
    </form>--}}
    <div class="col-md-12">
        <div class="row">
            @if (verificarAcceso(8))
            <a href="{{ url('sisadmin/noticia/create/'.$unidad->und_id) }}" class="btn btn-primary btn-sm" id="btnNuevo"><i class="fa fa-plus"></i> Agregar</a>
            @else
            <a href="#" class="btn btn-primary btn-sm disabled" id="btnNuevo"><i class="fa fa-plus"></i> Agregar</a>
            @endif
        </div>
        <div class="content" id="contenidoLista">
            <table class="table table-hover table-responsive-xl table-sm" id="tablaContenido">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Creado por</th>
                        <th>Título</th>
                        <th>Resumen</th>
                        <th>Imagen</th>
                        <th>Fecha</th>
                        <th>Prioridad</th>
                        <th>Publicar</th>
                        <th width="20%">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($noticias as $key => $noticia)
                    <!-- Incluir Open Graph tags para cada noticia -->
                    <meta property="og:title" content="{{ $noticia->titulo }}">
                    <meta property="og:description" content="{{ $noticia->resumen }}">
                    <meta property="og:image" content="{{ asset('storage/uploads/'.$noticia->imagen) }}">
                    <meta property="og:url" content="https://gobernaciondecochabamba.bo/web/detalle-noticias/{{ urlencode(Str::slug($noticia->titulo)) }}/individual">
                    <meta property="og:type" content="article">
                    <meta property="og:locale" content="es_ES">
                    <tr>
                        <td>{{$noticias->firstItem() + $key}}</td>
                        <td>{{$noticia->usuario->name}}</td>
                        <td>{{$noticia->titulo}}</td>
                        <td>{{$noticia->resumen}}</td>
                        <td>
                            {{
                                    Html::image(asset('storage/uploads/'.$noticia->imagen), 'Sin Imagen', array('id'=>'imagen', 'class' =>'img-thumbnail','width'=>'90'))
                                }}
                        </td>
                        <td>{{date('d/m/Y',strtotime($noticia->fecha))}}</td>
                        <td>{{$prioridades[$noticia->prioridad]}}</td>
                        <td>
                            @if (verificarAcceso(10))
                            {{
                                        Form::select('publicar',$publicar,$noticia->publicar,['class'=>'form-control form-control-sm','id'=>'publicar','onchange'=>"cambiarPublicar('$noticia->not_id',this.value);"])
                                    }}
                            @else
                            {{$publicar[$noticia->publicar]}}
                            @endif
                        </td>
                        <td>
                            @if (verificarAcceso(9))
                            <a href="{{ url('sisadmin/noticia/edit/'.$noticia->not_id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Editar</a>
                            @else
                            <a href="#" class="btn btn-primary btn-sm disabled"><i class="fa fa-edit"></i> Editar</a>
                            @endif
                            @if (verificarAcceso(12))
                            <a href="{{ url('sisadmin/noticia/imagenes/'.$noticia->not_id) }}" class="btn btn-warning btn-sm"><i class="fa fa-images"></i> Imagenes Noticia</a>
                            @else
                            <a href="#" class="btn btn-warning btn-sm disabled"><i class="fa fa-images"></i> Imagenes Noticia</a>
                            @endif
                            @if (verificarAcceso(11))
                            <button type="button" class="btn btn-danger btn-sm" onclick="cambiarEstado('{{$noticia->not_id}}','EL')"><i class="fa fa-trash"></i> Eliminar</button>
                            @else
                            <button type="button" class="btn btn-danger btn-sm disabled"><i class="fa fa-trash"></i> Eliminar</button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {{ $noticias->appends(['searchtype'=>$searchtype,'search'=>$search,'sort'=>$sort])->links() }}
            </div>
        </div>
    </div>
</div>

@endsection

@section('footer_scripts')
<script type="text/javascript">
    $(document).ready(function() {

    });

    function cambiarEstado(id, estado) {
        $.confirm({
            theme: 'modern',
            title: false,
            content: '¿Desea eliminar esta noticia?',
            buttons: {
                SI: {
                    text: 'SI',
                    btnClass: 'btn-blue',
                    keys: ['enter'],
                    action: function() {
                        loaderR.showPleaseWait();
                        $.ajax({
                            url: '{{url("sisadmin/noticia/_cambiarEstado")}}',
                            data: {
                                id: id,
                                estado: estado
                            },
                            type: 'POST',
                            success: function(resp) {
                                console.log(resp);
                                if (resp.res == true) {
                                    toastr.success(resp.mensaje, '');
                                    location.reload(true);
                                } else {
                                    toastr.error(resp.mensaje, '');
                                }
                            },
                            error: function(xhr, status) {
                                toastr.error('Ocurrio un error al modificar el dato', '');
                            },
                            complete: function(xhr, status) {
                                loaderR.hidePleaseWait();
                            }
                        });
                    }
                },
                NO: {
                    text: 'NO',
                    btnClass: 'btn-red',
                    action: function() {
                        //location.reload(true);
                    }
                }
            }
        });
    }

    function cambiarPublicar(not_id, publicar) {
        console.log(not_id + ' ' + publicar);
        loaderR.showPleaseWait();
        $.ajax({
            url: '{{url("sisadmin/noticia/_cambiarPublicar")}}',
            data: {
                not_id: not_id,
                publicar: publicar
            },
            type: 'POST',
            success: function(resp) {
                console.log(resp);
                if (resp.res == true) {
                    toastr.success(resp.mensaje, '');
                } else {
                    toastr.error(resp.mensaje, '');
                }

            },
            error: function(xhr, status) {
                toastr.error('Ocurrio un error en la operación', '');
            },
            complete: function(xhr, status) {
                loaderR.hidePleaseWait();
            }
        });
    }
</script>
@endsection