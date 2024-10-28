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
        <li class="breadcrumb-item active" aria-current="page">{{$tituloUnidad}}</li>
        <li class="breadcrumb-item active" aria-current="page">Imagen Galeria</li>
    </ol>
</nav>
<!-- Breadcrumb Area End-->
<div class="row justify-content-center">
    <div class="col-md-12">
        <h3 align="center">Lista de galeria de fotos de campañas</h3>
        <div class="col-md-12">
            <div class="col-md-12">
                @if (verificarAcceso(3))
                <a href="{{ url('sisadmin/imagenunidadgaleria/create/'.$und_id.'/'.$ruta) }}" class="btn btn-primary btn-sm" id="btnNuevo"><i class="fa fa-plus"></i> Agregar</a>
                @else
                <a href="#" class="btn btn-primary btn-sm disabled"><i class="fa fa-plus"></i> Agregar</a>
                @endif
                <br>

                <div class="content" id="contenidoLista">
                    <table class="table table-hover table-responsive-xl table-sm" id="tablaContenido">
                        <thead>
                            <tr>
                                <th>N°</th>
                                <th>Titulo</th>
                                <th>Descripcion</th>
                                <th>Imagen</th>
                                <th width="10%">Publicar</th>
                                <th width="17%">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
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
                                    {{
                                                Html::image(asset('storage/uploads/'.$item->imagen), 'Sin Imagen', array('id'=>'imagen', 'class' =>'img-thumbnail','width'=>'90'))
                                            }}
                                </td>
                                <td>
                                    @if (verificarAcceso(5))
                                    {{
                                                    Form::select('publicar',$publicar,$item->publicar,['class'=>'form-control form-control-sm','id'=>'publicar','onchange'=>"cambiarPublicar('$item->iug_id',this.value);"])
                                                }}
                                    @else
                                    {{$publicar[$item->publicar]}}
                                    @endif
                                </td>
                                <td>
                                    @if (verificarAcceso(4))
                                    <a href="{{ url('sisadmin/imagenunidadgaleria/edit/'.$item->iug_id.'/'.$item->und_id.'/'.$ruta) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Editar</a>
                                    @else
                                    <a href="#" class="btn btn-primary btn-sm disabled"><i class="fa fa-edit"></i> Editar</a>
                                    @endif

                                    @if (verificarAcceso(6))
                                    <button type="button" class="btn btn-danger btn-sm" onclick="modificarEstado('{{$item->iug_id}}','{{$item->titulo}}');"><i class="fa fa-trash"></i> Eliminar</button>
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
</div>
@endsection

@section('footer_scripts')
<script type="text/javascript">
    function modificarEstado(iug_id, nombre) {
        var mensajeConsulta = '¿Desea Eliminar la imagen galeria: <br>' + nombre + '?';
        $.confirm({
            theme: 'modern',
            title: false,
            content: mensajeConsulta,
            buttons: {
                SI: {
                    text: 'SI',
                    btnClass: 'btn-blue',
                    keys: ['enter'],
                    action: function() {
                        $.ajax({
                            url: '{{url("sisadmin/imagenunidadgaleria/_modificarEstado")}}',
                            data: {
                                iug_id: iug_id
                            },
                            type: 'POST',
                            success: function(resp) {
                                console.log(resp);
                                if (resp.res == true) {
                                    toastr.success('Operación completada', '');
                                    location.reload(true);
                                } else {
                                    toastr.error('Ocurrio un error al eliminar la imagen galeria', '');
                                }
                            },
                            error: function(xhr, status) {
                                toastr.error('Ocurrio un error al eliminar la imagen galeria', '');
                            },
                            complete: function(xhr, status) {}
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

    function cambiarPublicar(iug_id, publicar) {
        console.log(iug_id + ' ' + publicar);
        loaderR.showPleaseWait();
        $.ajax({
            url: '{{url("sisadmin/imagenunidadgaleria/_cambiarPublicar")}}',
            data: {
                iug_id: iug_id,
                publicar: publicar
            },
            type: 'POST',
            success: function(resp) {
                console.log(resp);

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