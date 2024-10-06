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
            <li class="breadcrumb-item active" aria-current="page">Tipologias</li>
            <li class="breadcrumb-item active" aria-current="page">Biografia</li>
        </ol>
    </nav>
    <!-- Breadcrumb Area End-->
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if ( $biografia->bio_id == 0)
                <h3 align="center">Nuevo Biografia</h3>
            @else
                <h3 align="center">Editar Biografia</h3>
            @endif
            <br>
            <form class="form-horizontal" id="formulario" autocomplete="off" method="POST" enctype="multipart/form-data" action="{{ url('sisadmin/biografia/store') }}">
                {{ csrf_field() }}
            <div class="col-md-12 row">
                <div class="col-md-7">
                    <div class="form-group row">
                        {{Form::hidden('bio_id',$biografia->bio_id)}}
                        <label class="col-md-2 col-form-label text-right" >Nombres*:</label>
                        <div class="col-md-10">
                            <input type="text" value="{{ old('nombres',$biografia->nombres) }}" class="form-control form-control-sm"  name="nombres" id="nombres" required>
                            @error('nombres')
                            <p class="form-text text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label text-right" >Apellido*:</label>
                        <div class="col-md-10">
                            <input type="text" value="{{ old('apellidos',$biografia->apellidos) }}" class="form-control form-control-sm"  name="apellidos" id="apellidos" required>
                            @error('apellidos')
                            <p class="form-text text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label text-right" >Profesion*:</label>
                        <div class="col-md-10">
                            <input type="text" maxlength="300" value="{{ old('profesion',$biografia->profesion) }}" class="form-control form-control-sm"  name="profesion" id="profesion" required>
                            @error('profesion')
                            <p class="form-text text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label text-right" >Reseña*:</label>
                        <div class="col-md-10">
                            <textarea rows="8" cols="80" class="form-control form-control-sm" name="resenia" id="resenia" >{{ old('resenia',$biografia->resenia)}}</textarea>
                            @error('resenia')
                            <p class="form-text text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                @if ( $biografia->bio_id  == 0)
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label text-right">Nueva Fotografia:</label>
                        <div class="col-md-7">
                            <input type="file" class="form-control-file form-control-sm" id="imagen_foto" name="imagen_foto" accept="image/jpeg,image/jpg,image/JPEG,image/JPG">
                            @error('imagen_foto')
                            <p class="form-text text-danger">{{ $message }}</p>
                            @enderror
                            <p style="font-size:12px">  La imagen no puede ser mayor a 600 x 600 pixeles y debe de ser en formato jpeg o png y menor de 4Mb</p>
                        </div>
                    </div>
                @else
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-right">Fotografia actual:</label>
                        <div class="col-md-6">
                            {{
                                Html::image(asset('storage/uploads/'.$biografia->imagen_foto), 'Sin Fotografia', array('id'=>'imagen_foto', 'class' =>'img-thumbnail','width'=>'260'))
                            }}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-right">Nueva Fotografia :</label>
                        <div class="col-md-6">
                            <input type="file" class="form-control-file form-control-sm" id="imagen_foto" name="imagen_foto" accept="image/jpeg, image/jpg, image/JPEG, image/JPG" >
                            <p style="font-size:12px">  La nueva imagen no puede ser mayor a 600 x 600 pixeles y debe de ser en formato jpeg o png y menor de 4Mb </p>
                            @error('imagen_foto')
                            <p class="form-text text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                @endif
            </div><br><br>
            </div><br>
                <div class="row justify-content-center" style="margin-top: 10px;">
                    <div class="col-md-2">
                        <button id="btn_guardar" class="btn btn-primary btn-sm" type="submit" id="btnGuardar">Guardar</button>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ url('sisadmin/biografia/') }}" class="btn btn-danger btn-sm">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('footer_scripts')
    <script src="{{asset('js/tinymce.min.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#formulario").submit(function (){
                loaderR.showPleaseWait();
            });
            tinymce.init({
                selector: '#resenia',
                language: 'es',
                theme: 'modern',
                width: 550,
                height: 200,
                plugins: [
                    'advlist code lists charmap preview hr searchreplace wordcount visualblocks visualchars fullscreen',
                    'insertdatetime nonbreaking table contextmenu directionality paste link'
                ],
                //toolbar: ['fontselect fontsizeselect formatselect'],
                toolbar: 'fontselect fontsizeselect formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat',
            });
        });
    </script>
@endsection
