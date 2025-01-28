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
        <li class="breadcrumb-item active" aria-current="page">Gestión</li>
        <li class="breadcrumb-item active" aria-current="page">Campañas</li>
    </ol>
</nav>

@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

@if (session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif

<!-- Breadcrumb Area End-->
<h3>Gestión Campaña: {{$titulo}}</h3>
<div class="row justify-content-center mt-4">

    <div class="col-md-10">
        <div class="row">
            <!-- Video -->
            <div class="col-12 col-md-6">
                <form action="{{ route('storecampaniasbanner') }}" method="post" enctype="multipart/form-data" onsubmit="return handleSubmit(this, event)">
                    @csrf

                    <h4 for="video">Video Banner</h4>
                    <input type="file" class="form-control-file" id="video" name="video" accept="video/mp4">
                    <input type="hidden" name="id_video_banner" value="{{$id}}">
                    <span>El video debe ser en formato MP4, con una resolución máxima de 1900 x 650 píxeles y un tamaño menor a 100MB.</span>
                    <div class="float-right">
                        <button type="submit" id="submit-button" class="btn btn-primary d-block">
                            <i class="fa fa-save"></i> Guardar
                        </button>
                    </div>
                </form>
            </div>
            <script>
                function handleSubmit(form, event) {
                    // Prevenir el doble envío
                    const button = form.querySelector('#submit-button');
                    if (button.disabled) {
                        return false;
                    }

                    // Cambiar estado del botón
                    button.disabled = true;
                    button.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Guardando...';

                    // Permitir el envío del formulario
                    return true;
                }
            </script>
            <div class="col-12 col-md-6">
                <table class="table mt-3">
                    <thead>
                        <tr>
                            <th>Video</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($imagenBaners as $video)
                        <tr>
                            <td>
                                <video width="320" height="240" controls>
                                    <source src="{{ asset('storage/uploads/' . $video->imagen_banner) }}" type="video/mp4">
                                    Tu navegador no soporta la reproducción de este video.
                                </video>
                            </td>
                            <td>
                                <form action="{{ route('deletecampaniasbanner', $video->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fa fa-trash"></i> Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>

        <div class="col-12">
            <hr>
        </div>

        <!-- Portada PDF Video Banner -->
        <h4>Portada Video Banner y subida de archivos mp4</h4>
        <div class="row">
            <div class="col-md-6">
                <form id="form_video" action="{{url('sisadmin/videosonido/storecampaniasvideo')}}" method="post" enctype="multipart/form-data" onsubmit="return handleSubmitVideo(this, event)">
                    @csrf
                    <div class="form-control">
                        <label for="pdf">Portada Video Banner</label>
                        <input
                            type="file"
                            class="form-control-file"
                            id="portada_video"
                            name="portada_video"
                            accept="image/jpeg"
                            onchange="previewImageVideoPortada(event)">
                        <input type="hidden" name="id_video_banner" value="{{$id}}">
                        <input type="hidden" name="tipo_documento" value="video">
                        <span>La imagen debe ser en formato jpg, con una resolución máxima de 300 x 150 píxeles y un tamaño menor a 4MB.</span>

                        <div class="mt-3">
                            <img id="imagePreviewVideoPortada" src="#" alt="Vista previa" style="width: 200px; display: none; border: 1px solid #ddd; padding: 5px; border-radius: 5px;">
                        </div>

                        @if($portadaVideo->count() > 0)
                        <div class="mt-3">
                            <img id="mostrar-portada" src="{{ asset('storage/uploads/' . $portadaVideo->first()->url_imagen) }}" alt="Vista previa" style="width: 200px;border: 1px solid #ddd; padding: 5px; border-radius: 5px;">
                        </div>
                        <span>Portada Actual</span>
                        @endif


                        <div class="float-right mt-2">
                            <button type="submit" id="submit_portada_video" class="btn btn-primary d-block">
                                <i class="fa fa-save"></i> Guardar
                            </button>
                        </div>
                    </div>
                    <script>
                        function handleSubmitVideo(form, event) {
                            // Prevenir el doble envío
                            const button = form.querySelector('#submit_portada_video');
                            if (button.disabled) {
                                return false;
                            }

                            // Cambiar estado del botón
                            button.disabled = true;
                            button.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Guardando...';

                            // Permitir el envío del formulario
                            return true;
                        }
                    </script>
                </form>
            </div>

            <!-- archivos mp4 para subir -->
            <div class="col-md-6">
                <form id="form_video_subir" action="{{url('sisadmin/videosonido/downloadcampaniasvideo')}}" method="post" enctype="multipart/form-data" onsubmit="return handleSubmitVideoSubir(this, event)">
                    @csrf
                    <div class="form-control">
                        <label for="video">Elegir archivo mp4</label>
                        <input type="file" class="form-control-file" id="video_mp4" name="video_mp4" accept="video/mp4">
                        <input type="hidden" id="tipo_documento_video" name="tipo_documento_video" value="video">
                        <input type="hidden" name="id_for_video" value="{{$id}}">

                        <div class="float-right">
                            <button id="submit-video-up" type="submit" class="btn btn-primary d-block">
                                <i class="fa fa-save"></i> Guardar
                            </button>
                        </div>
                    </div>
                    <script>
                        function handleSubmitVideoSubir(form, event) {
                            // Prevenir el doble envío                            
                            const button = form.querySelector('#submit-video-up');
                            if (button.disabled) {
                                return false;
                            }

                            // Cambiar estado del botón
                            button.disabled = true;
                            button.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Guardando...';

                            // Permitir el envío del formulario
                            return true;
                        }
                    </script>
                </form>
                <table class="table mt-3">
                    <thead>
                        <tr>
                            <th>Videos</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($archivoVideos as $video)
                        <tr>
                            <td>
                                <video width="320" height="240" controls>
                                    <source src="{{ asset('storage/uploads/' . $video->archivo) }}" type="video/mp4">
                                    Tu navegador no soporta la reproducción de este video.
                                </video>
                                <div>{{$video->archivo}}</div>
                            </td>
                            <td>
                                <form id="delete-form-{{$video->id}}" action="{{ route('deletedownloadcampaniasvideo', $video->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fa fa-trash"></i> Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>

        <script>
            function previewImageVideoPortada(event) {
                const input = event.target;
                const preview = document.getElementById('imagePreviewVideoPortada');

                if (input.files && input.files[0]) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                    };

                    reader.readAsDataURL(input.files[0]);
                }
            }
        </script>

        <div class="col-12">
            <hr>
        </div>

        <!-- Afiche y pdf -->
        <h4>Portada afiche y subida de archivos pdf</h4>
        <div class="row">
            <div class="col-md-6">
                <form id="form_video" action="{{url('sisadmin/videosonido/storecampaniasafiche')}}" method="post" enctype="multipart/form-data" onsubmit="return handleSubmitAfiche(this, event)">
                    @csrf
                    <div class="form-control">
                        <label for="pdf">Portada Afiche</label>
                        <input
                            type="file"
                            class="form-control-file"
                            id="portada_afiche"
                            name="portada_afiche"
                            accept="image/jpeg, image/png, image/jpg, image/gif"
                            onchange="previewImageAfiche(event)">
                        <input type="hidden" name="id_afiche" value="{{$id}}">
                        <input type="hidden" name="tipo_documento_afiche" value="afiche">
                        <span>La imagen debe ser en formato jpg, con una resolución máxima de 300 x 150 píxeles y un tamaño menor a 4MB.</span>

                        <div class="mt-3">
                            <img id="imagePreviewAfiche" src="#" alt="Vista previa" style="width: 200px; display: none; border: 1px solid #ddd; padding: 5px; border-radius: 5px;">
                        </div>

                        @if($portadaAfiches->count() > 0)
                        <div class="mt-3">
                            <img id="mostrar-portada-afiches" src="{{ asset('storage/uploads/' . $portadaAfiches->first()->url_imagen) }}" alt="Vista previa" style="width: 200px;border: 1px solid #ddd; padding: 5px; border-radius: 5px;">
                        </div>
                        <span>Portada Actual</span>
                        @endif


                        <div class="float-right mt-2">
                            <button type="submit" id="submit_portada_afiche" class="btn btn-primary d-block">
                                <i class="fa fa-save"></i> Guardar
                            </button>
                        </div>
                    </div>
                    <script>
                        function handleSubmitAfiche(form, event) {
                            // Prevenir el doble envío
                            const button = form.querySelector('#submit_portada_afiche');
                            if (button.disabled) {
                                return false;
                            }

                            // Cambiar estado del botón
                            button.disabled = true;
                            button.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Guardando...';

                            // Permitir el envío del formulario
                            return true;
                        }
                    </script>
                </form>
            </div>

            <!-- archivos mp4 para subir -->
            <div class="col-md-6">
                <form id="form_afiche_subir" action="{{url('sisadmin/videosonido/downloadcampaniasafiche')}}" method="post" enctype="multipart/form-data" onsubmit="return handleSubmitPdfAfiche(this, event)">
                    @csrf
                    <div class="form-control">
                        <label for="afiche">Elegir archivo PDF</label>
                        <input type="file" class="form-control-file" id="afiche" name="afiche" accept="application/pdf">
                        <input type="hidden" id="tipo_documento_afiche" name="tipo_documento_afiche" value="afiche">
                        <input type="hidden" name="id_for_afiche" value="{{$id}}">

                        <div class="float-right">
                            <button id="submit-video-up" type="submit" class="btn btn-primary d-block">
                                <i class="fa fa-save"></i> Guardar
                            </button>
                        </div>
                    </div>
                    <script>
                        function handleSubmitPdfAfiche(form, event) {
                            // Prevenir el doble envío                            
                            const button = form.querySelector('#submit-video-up');
                            if (button.disabled) {
                                return false;
                            }

                            // Cambiar estado del botón
                            button.disabled = true;
                            button.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Guardando...';

                            // Permitir el envío del formulario
                            return true;
                        }
                    </script>
                </form>
                <table class="table mt-3">
                    <thead>
                        <tr>
                            <th>Archivo PDF</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($archivoAfiches as $video)
                        <tr>
                            <td>
                                <div>
                                    <a href="{{ asset('storage/uploads/' . $video->archivo) }}" download="archivo.pdf">{{ $video->archivo }}</a>
                                </div>

                            </td>
                            <td>
                                <form id="delete-afiche-{{$video->id}}" action="{{ route('deletedownloadcampaniasafiche', $video->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fa fa-trash"></i> Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>

        <script>
            function previewImageAfiche(event) {
                const input = event.target;
                const preview = document.getElementById('imagePreviewAfiche');

                if (input.files && input.files[0]) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                    };

                    reader.readAsDataURL(input.files[0]);
                }
            }
        </script>

        <div class="col-12">
            <hr>
        </div>

        <!-- Volantes y archivos jpg  -->
        <h4>Portada volante y subida de archivos jpg</h4>
        <div class="row">
            <div class="col-md-6">
                <form id="form_volante" action="{{url('sisadmin/videosonido/storecampaniasvolante')}}" method="post" enctype="multipart/form-data" onsubmit="return handleSubmitVolante(this, event)">
                    @csrf
                    <div class="form-control">
                        <label for="pdf">Portada Volante</label>
                        <input
                            type="file"
                            class="form-control-file"
                            id="portada_volante"
                            name="portada_volante"
                            accept="image/jpeg, image/png, image/jpg, image/gif"
                            onchange="previewImageVolante(event)">
                        <input type="hidden" name="id_volante" value="{{$id}}">
                        <input type="hidden" name="tipo_documento_volante" value="volante">
                        <span>La imagen debe ser en formato jpg, con una resolución máxima de 300 x 150 píxeles y un tamaño menor a 4MB.</span>

                        <div class="mt-3">
                            <img id="imagePreviewVolante" src="#" alt="Vista previa" style="width: 200px; display: none; border: 1px solid #ddd; padding: 5px; border-radius: 5px;">
                        </div>

                        @if($portadaVolantes->count() > 0)
                        <div class="mt-3">
                            <img id="mostrar-portada-volantes" src="{{ asset('storage/uploads/' . $portadaVolantes->first()->url_imagen) }}" alt="Vista previa" style="width: 200px;border: 1px solid #ddd; padding: 5px; border-radius: 5px;">
                        </div>
                        <span>Portada Actual</span>
                        @endif


                        <div class="float-right mt-2">
                            <button type="submit" id="submit_portada_volante" class="btn btn-primary d-block">
                                <i class="fa fa-save"></i> Guardar
                            </button>
                        </div>
                    </div>
                    <script>
                        function handleSubmitVolante(form, event) {
                            // Prevenir el doble envío
                            const button = form.querySelector('#submit_portada_volante');
                            if (button.disabled) {
                                return false;
                            }

                            // Cambiar estado del botón
                            button.disabled = true;
                            button.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Guardando...';

                            // Permitir el envío del formulario
                            return true;
                        }
                    </script>
                </form>
            </div>

            <!-- archivos mp4 para subir -->
            <div class="col-md-6">
                <form id="form_volante_subir" action="{{url('sisadmin/videosonido/downloadcampaniasvolante')}}" method="post" enctype="multipart/form-data" onsubmit="return handleSubmitPdfVolante(this, event)">
                    @csrf
                    <div class="form-control">
                        <label for="volante">Elegir archivo Imagen</label>
                        <input type="file" class="form-control-file" id="volante" name="volante" accept="image/jpeg, image/png, image/jpg, image/gif">
                        <input type="hidden" id="tipo_documento_volante" name="tipo_documento_volante" value="volante">
                        <input type="hidden" name="id_for_volante" value="{{$id}}">

                        <div class="float-right">
                            <button id="submit-video-up-volante" type="submit" class="btn btn-primary d-block">
                                <i class="fa fa-save"></i> Guardar
                            </button>
                        </div>
                    </div>
                    <script>
                        function handleSubmitPdfVolante(form, event) {
                            // Prevenir el doble envío                            
                            const button = form.querySelector('#submit-video-up-volante');
                            if (button.disabled) {
                                return false;
                            }

                            // Cambiar estado del botón
                            button.disabled = true;
                            button.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Guardando...';

                            // Permitir el envío del formulario
                            return true;
                        }
                    </script>
                </form>
                <table class="table mt-3">
                    <thead>
                        <tr>
                            <th>Archivo Imagen</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($archivoVolantes as $video)
                        <tr>
                            <td>
                                <div>
                                    <a href="{{ asset('storage/uploads/' . $video->archivo) }}" download>{{ $video->archivo }}</a>
                                </div>

                            </td>
                            <td>
                                <form id="delete-volante-{{$video->id}}" action="{{ route('deletedownloadcampaniasvolante', $video->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fa fa-trash"></i> Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>

        <script>
            function previewImageVolante(event) {
                const input = event.target;
                const preview = document.getElementById('imagePreviewVolante');

                if (input.files && input.files[0]) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                    };

                    reader.readAsDataURL(input.files[0]);
                }
            }
        </script>

        <div class="col-12">
            <hr>
        </div>

        <!-- Carrusel Redes -->
        <h4>Carrusel de redes y subida de archivos jpg</h4>
        <div class="row">
            <div class="col-md-6">
                <form id="form_volante" action="{{url('sisadmin/videosonido/storecampaniasredes')}}" method="post" enctype="multipart/form-data" onsubmit="return handleSubmitRedes(this, event)">
                    @csrf
                    <div class="form-control">
                        <label for="pdf">Portada de carrucel de redes </label>
                        <input
                            type="file"
                            class="form-control-file"
                            id="portada_redes"
                            name="portada_redes"
                            accept="image/jpeg, image/png, image/jpg, image/gif"
                            onchange="previewImageRedes(event)">
                        <input type="hidden" name="id_redes" value="{{$id}}">
                        <input type="hidden" name="tipo_documento_redes" value="redes">
                        <span>La imagen debe ser en formato jpg, con una resolución máxima de 300 x 150 píxeles y un tamaño menor a 4MB.</span>

                        <div class="mt-3">
                            <img id="imagePreviewRedes" src="#" alt="Vista previa" style="width: 200px; display: none; border: 1px solid #ddd; padding: 5px; border-radius: 5px;">
                        </div>

                        @if($portadaRedes->count() > 0)
                        <div class="mt-3">
                            <img id="mostrar-portada-redes" src="{{ asset('storage/uploads/' . $portadaRedes->first()->url_imagen) }}" alt="Vista previa" style="width: 200px;border: 1px solid #ddd; padding: 5px; border-radius: 5px;">
                        </div>
                        <span>Portada Actual</span>
                        @endif


                        <div class="float-right mt-2">
                            <button type="submit" id="submit_portada_redes" class="btn btn-primary d-block">
                                <i class="fa fa-save"></i> Guardar
                            </button>
                        </div>
                    </div>
                    <script>
                        function handleSubmitRedes(form, event) {
                            // Prevenir el doble envío
                            const button = form.querySelector('#submit_portada_redes');
                            if (button.disabled) {
                                return false;
                            }

                            // Cambiar estado del botón
                            button.disabled = true;
                            button.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Guardando...';

                            // Permitir el envío del formulario
                            return true;
                        }
                    </script>
                </form>
            </div>

            <!-- archivos mp4 para subir -->
            <div class="col-md-6">
                <form id="form_redes_subir" action="{{url('sisadmin/videosonido/downloadcampaniasredes')}}" method="post" enctype="multipart/form-data" onsubmit="return handleSubmitPdfRedes(this, event)">
                    @csrf
                    <div class="form-control">
                        <label for="redes">Elegir archivo Imagen</label>
                        <input type="file" class="form-control-file" id="redes" name="redes" accept="image/jpeg, image/png, image/jpg, image/gif">
                        <input type="hidden" id="tipo_documento_redes" name="tipo_documento_redes" value="redes">
                        <input type="hidden" name="id_for_redes" value="{{$id}}">

                        <div class="float-right">
                            <button id="submit-video-up-redes" type="submit" class="btn btn-primary d-block">
                                <i class="fa fa-save"></i> Guardar
                            </button>
                        </div>
                    </div>
                    <script>
                        function handleSubmitPdfRedes(form, event) {
                            // Prevenir el doble envío                            
                            const button = form.querySelector('#submit-video-up-redes');
                            if (button.disabled) {
                                return false;
                            }

                            // Cambiar estado del botón
                            button.disabled = true;
                            button.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Guardando...';

                            // Permitir el envío del formulario
                            return true;
                        }
                    </script>
                </form>
                <table class="table mt-3">
                    <thead>
                        <tr>
                            <th>Archivo Imagen</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($archivoRedes as $video)
                        <tr>
                            <td>
                                <div>
                                    <a href="{{ asset('storage/uploads/' . $video->archivo) }}" download>{{ $video->archivo }}</a>
                                </div>

                            </td>
                            <td>
                                <form id="delete-redes-{{$video->id}}" action="{{ route('deletedownloadcampaniasredes', $video->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fa fa-trash"></i> Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>

        <script>
            function previewImageRedes(event) {
                const input = event.target;
                const preview = document.getElementById('imagePreviewRedes');

                if (input.files && input.files[0]) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                    };

                    reader.readAsDataURL(input.files[0]);
                }
            }
        </script>

        <div class="col-12">
            <hr>
        </div>

        <!-- Historia Redes -->
        <h4>Portada historia Redes y subida de archivos jpg</h4>
        <div class="row">
            <div class="col-md-6">
                <form id="form_historia" action="{{url('sisadmin/videosonido/storecampaniashistoria')}}" method="post" enctype="multipart/form-data" onsubmit="return handleSubmitHistoria(this, event)">
                    @csrf
                    <div class="form-control">
                        <label for="pdf">Portada Historia de Redes</label>
                        <input
                            type="file"
                            class="form-control-file"
                            id="portada_historia"
                            name="portada_historia"
                            accept="image/jpeg, image/png, image/jpg, image/gif"
                            onchange="previewImageHistoria(event)">
                        <input type="hidden" name="id_historia" value="{{$id}}">
                        <input type="hidden" name="tipo_documento_historia" value="historia">
                        <span>La imagen debe ser en formato jpg, con una resolución máxima de 300 x 150 píxeles y un tamaño menor a 4MB.</span>

                        <div class="mt-3">
                            <img id="imagePreviewHistoria" src="javascript:void(0);" alt="Vista previa" style="width: 200px; display: none; border: 1px solid #ddd; padding: 5px; border-radius: 5px;">
                        </div>

                        @if($portadaHistorias->count() > 0)
                        <div class="mt-3">
                            <img id="mostrar-portada-historia" src="{{ asset('storage/uploads/' . $portadaHistorias->first()->url_imagen) }}" alt="Vista previa" style="width: 200px;border: 1px solid #ddd; padding: 5px; border-radius: 5px;">
                        </div>
                        <span>Portada Actual</span>
                        @endif


                        <div class="float-right mt-2">
                            <button type="submit" id="submit_portada_historia" class="btn btn-primary d-block">
                                <i class="fa fa-save"></i> Guardar
                            </button>
                        </div>
                    </div>
                    <script>
                        function handleSubmitHistoria(form, event) {
                            // Prevenir el doble envío
                            const button = form.querySelector('#submit_portada_historia');
                            if (button.disabled) {
                                return false;
                            }

                            // Cambiar estado del botón
                            button.disabled = true;
                            button.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Guardando...';

                            // Permitir el envío del formulario
                            return true;
                        }
                    </script>
                </form>
            </div>

            <!-- archivos mp4 para subir -->
            <div class="col-md-6">
                <form id="form_historia_subir" action="{{url('sisadmin/videosonido/downloadcampaniashistoria')}}" method="post" enctype="multipart/form-data" onsubmit="return handleSubmitPdfHistoria(this, event)">
                    @csrf
                    <div class="form-control">
                        <label for="historia">Elegir archivo Imagen</label>
                        <input type="file" class="form-control-file" id="historia" name="historia" accept="image/jpeg, image/png, image/jpg, image/gif">
                        <input type="hidden" id="tipo_documento_historia" name="tipo_documento_historia" value="historia">
                        <input type="hidden" name="id_for_historia" value="{{$id}}">

                        <div class="float-right">
                            <button id="submit-video-up-historia" type="submit" class="btn btn-primary d-block">
                                <i class="fa fa-save"></i> Guardar
                            </button>
                        </div>
                    </div>
                    <script>
                        function handleSubmitPdfHistoria(form, event) {
                            // Prevenir el doble envío                            
                            const button = form.querySelector('#submit-video-up-historia');
                            if (button.disabled) {
                                return false;
                            }

                            // Cambiar estado del botón
                            button.disabled = true;
                            button.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Guardando...';

                            // Permitir el envío del formulario
                            return true;
                        }
                    </script>
                </form>
                <table class="table mt-3">
                    <thead>
                        <tr>
                            <th>Archivo Imagen</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($archivoHistorias as $video)
                        <tr>
                            <td>
                                <div>
                                    <a href="{{ asset('storage/uploads/' . $video->archivo) }}" download>{{ $video->archivo }}</a>
                                </div>

                            </td>
                            <td>
                                <form id="delete-historia-{{$video->id}}" action="{{ route('deletedownloadcampaniashistoria', $video->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fa fa-trash"></i> Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>

        <script>
            function previewImageHistoria(event) {
                const input = event.target;
                const preview = document.getElementById('imagePreviewHistoria');

                if (input.files && input.files[0]) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                    };

                    reader.readAsDataURL(input.files[0]);
                }
            }
        </script>

        <div class="col-12">
            <hr>
        </div>

    </div>

</div>



@endsection