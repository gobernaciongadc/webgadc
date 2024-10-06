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
            <li class="breadcrumb-item"><a href="{{url(('sisadmin/noticia/'.$unidad->und_id)).'/lista'}}">Noticias: {{$unidad->nombre}}</a></li>
            <li class="breadcrumb-item active" aria-current="page">Imagenes Noticia</li>
        </ol>
    </nav>
    <!-- Breadcrumb Area End-->
    <div class="row justify-content-center">
        <div class="col-md-11">
            <h3 align="center">Lista de Imagenes de la Noticia: {{$noticia->titulo}}</h3>
            <div class="col-md-12">
                <div class="col-md-12">
                    <a href="{{ url('sisadmin/noticia/imagenes/create/'.$noticia->not_id) }}" class="btn btn-primary btn-sm" id="btnNuevo"><i class="fa fa-plus"></i> Agregar</a>
                    <br>
                    <div class="content" id="contenidoLista">
                        <table class="table table-hover table-responsive-xl table-sm" id="tablaContenido">
                            <thead>
                            <tr>
                                <th>N°</th>
                                <th>Titulo</th>
                                <th>Descripcion</th>
                                <th>Imagen</th>
                                <th>Publicar</th>
                                <th width="20%">Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($imagenes as $key=> $item)
                                <tr>
                                    <td>{{$imagenes->firstItem() + $key}}</td>
                                    <td>{{$item->titulo}}</td>
                                    <td>{{$item->descripcion}}</td>
                                    <td>
                                        {{
                                            Html::image(asset('storage/uploads/'.$item->imagen), 'Sin Imagen', array('id'=>'imagen', 'class' =>'img-thumbnail','width'=>'90'))
                                        }}
                                    </td>
                                    <td>
                                        {{
                                            Form::select('publicar',$publicar,$item->publicar,['class'=>'form-control form-control-sm','id'=>'publicar','onchange'=>"cambiarPublicar('$item->imn_id',this.value);"])
                                        }}
                                    </td>
                                    <td>
                                        <a href="{{ url('sisadmin/noticia/imagenes/edit/'.$item->imn_id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Editar</a>
                                        <button type="button" class="btn btn-danger btn-sm" onclick="modificarEstado('{{$item->imn_id}}');"><i class="fa fa-trash"></i> Eliminar</button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center">
                            {{ $imagenes->links() }}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('footer_scripts')
    <script type="text/javascript">

        function modificarEstado(imn_id){
            $.confirm({
                theme: 'modern',
                title: false,
                content: '¿Desea eliminar esta imagen?',
                buttons: {
                    SI: {
                        text: 'SI',
                        btnClass: 'btn-blue',
                        keys: ['enter'],
                        action: function(){
                            loaderR.showPleaseWait();
                            $.ajax({
                                url: '{{url("sisadmin/noticia/imagenes/_cambiarEstado")}}',
                                data: {
                                    imn_id: imn_id
                                },
                                type: 'POST',
                                success: function (resp) {
                                    console.log(resp);
                                    if (resp.res == true){
                                        toastr.success(resp.mensaje,'');
                                        location.reload(true);
                                    }else{
                                        toastr.error(resp.mensaje,'');
                                    }
                                },
                                error: function (xhr, status) {
                                    toastr.warning('No se pudo eliminar la imagen galeria','');
                                },
                                complete: function (xhr, status) {
                                    loaderR.hidePleaseWait();
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

        function cambiarPublicar(imn_id,publicar){
            console.log(imn_id+' '+publicar);
            loaderR.showPleaseWait();
            $.ajax({
                url : '{{url("sisadmin/noticia/imagenes/_cambiarPublicar")}}',
                data : {
                    imn_id:imn_id,
                    publicar:publicar
                },
                type : 'POST',
                success : function(resp) {
                    console.log(resp);
                    if (resp.res == true){
                        toastr.success(resp.mensaje,'');
                    }else{
                        toastr.error(resp.mensaje,'');
                    }
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
