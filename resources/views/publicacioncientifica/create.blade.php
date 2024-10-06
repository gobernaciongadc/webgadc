@extends('layouts.app')

@section('header_styles')
    <style type="text/css">

    </style>
@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if ($publicacion->puc_id == 0)
                <h3 align="center">Nueva Publicación Científica</h3>
            @else
                <h3 align="center">Editar Publicación Científica</h3>
            @endif
            <br>
            <form class="form-horizontal" id="formulario" autocomplete="off" method="POST" enctype="multipart/form-data" action="{{ url('sisadmin/publicacioncientifica/store') }}">
                {{ csrf_field() }}
                <div class="form-group row">
                    <label class="col-md-1 col-form-label"></label>
                    <label class="col-md-2 col-form-label">Título*:</label>
                    <div class="col-md-8">
                        {{Form::hidden('puc_id',$publicacion->puc_id)}}
                        {{Form::hidden('und_id',$publicacion->und_id)}}
                        {{Form::hidden('estado',$publicacion->estado)}}
                        {{Form::hidden('publicar',$publicacion->publicar)}}
                        <input type="text" value="{{ old('titulo',$publicacion->titulo) }}" class="form-control form-control-sm"  name="titulo" id="titulo" required >
                        @error('titulo')
                        <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-1 col-form-label"></label>
                    <label class="col-md-2 col-form-label">Autor*:</label>
                    <div class="col-md-8">
                        <input type="text" value="{{ old('autor',$publicacion->autor) }}" class="form-control form-control-sm"  name="autor" id="autor" required >
                        @error('autor')
                        <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-1 col-form-label"></label>
                    <label class="col-md-2 col-form-label">Resumen*:</label>
                    <div class="col-md-8">
                        <textarea class="form-control form-control-sm" rows="3" cols="40" name="resumen" id="resumen">{{ old('resumen',$publicacion->resumen) }}</textarea>
                        @error('resumen')
                        <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-1 col-form-label"></label>
                    <label class="col-md-2 col-form-label">Fuente*:</label>
                    <div class="col-md-8">
                        <textarea class="form-control form-control-sm" rows="3" cols="40" name="fuente" id="fuente" required>{{ old('fuente',$publicacion->fuente) }}</textarea>
                        @error('fuente')
                        <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                @if($publicacion->puc_id == 0)
                    <div class="form-group row">
                        <label class="col-md-1 col-form-label"></label>
                        <label class="col-md-2 col-form-label">Imagen*:</label>
                        <div class="col-md-8">
                            <input type="file" class="form-control-file form-control-sm" id="imagen" name="imagen" accept="image/jpeg, image/jpg, image/JPEG, image/JPG, image/png" required >
                            @error('imagen')
                            <p class="form-text text-danger">{{ $message }}</p>
                            @enderror
                            <p style="font-size:12px">  La imagen no puede ser mayor a 1100 x 1700 pixeles y debe de ser en formato jpg o png y menor de 4MB</p>
                        </div>
                    </div>
                @else
                    <div class="form-group row">
                        <label class="col-md-1 col-form-label"></label>
                        <label class="col-md-2 col-form-label">Imagen Actual:</label>
                        <div class="col-md-8">
                            {{
                                Html::image(asset('storage/uploads/'.$publicacion->imagen), 'Sin Imagen', array('id'=>'imagen', 'class' =>'img-thumbnail','width'=>'200'))
                            }}
                        </div>
                    </div>
                    <br>
                    <div class="form-group row">
                        <label class="col-md-1 col-form-label"></label>
                        <label class="col-md-2 col-form-label">Nueva Imagen*:</label>
                        <div class="col-md-8">
                            <input type="file" class="form-control-file form-control-sm" id="imagen" name="imagen" accept="image/jpeg, image/jpg, image/JPEG, image/JPG, image/png" >
                            @error('imagen')
                            <p class="form-text text-danger">{{ $message }}</p>
                            @enderror
                            <p style="font-size:12px">  La imagen no puede ser mayor a 1100 x 1700 pixeles y debe de ser en formato jpg o png y menor de 4MB</p>
                        </div>
                    </div>

                @endif

                @if ( $publicacion->puc_id == 0)
                    <div class="form-group row">
                        <label class="col-md-1 col-form-label"></label>
                        <label class="col-md-2 col-form-label" >Archivo*:</label>
                        <div class="col-md-8">
                            <input type="file" class="form-control-file form-control-sm" id="archivo" name="archivo" accept="application/msword, application/vnd.ms-excel,.xlsx, application/pdf" required >
                            @error('archivo')
                            <p class="form-text text-danger">{{ $message }}</p>
                            @enderror
                            <p style="font-size:12px">  El archivo debe de ser en formato pdf,word o excel y menor de 10MB</p>
                        </div>
                    </div>
                @else
                    <br>
                    <div class="form-group row">
                        <label class="col-md-1 col-form-label"></label>
                        <label class="col-md-2 col-form-label">Archivo Actual:</label>
                        <div class="col-md-8">
                            <a target="_blank" href="{{asset('storage/uploads/'.$publicacion->archivo)}}"><i class="fa fa-download"></i> Descargar Archivo</a>
                        </div>
                    </div>
                    <br>
                    <div class="form-group row">
                        <label class="col-md-1 col-form-label"></label>
                        <label class="col-md-2 col-form-label">Nuevo Archivo*:</label>
                        <div class="col-md-8">
                            <input type="file" class="form-control-file form-control-sm" id="archivo" name="archivo" accept="application/msword, application/vnd.ms-excel,.xlsx, application/pdf" >
                            @error('archivo')
                            <p class="form-text text-danger">{{ $message }}</p>
                            @enderror
                            <p style="font-size:12px">  El archivo debe de ser en formato pdf,word o excel y menor de 10MB</p>
                        </div>
                    </div>
                @endif

                <br>
                <div class="form-group row">
                    <label class="col-md-1 col-form-label"></label>
                    <label class="col-md-2 col-form-label">Fecha*:</label>
                    <div class="col-md-8">
                        <input onkeypress="return false;" type="text" value="{{ old('fecha',date('d/m/Y',strtotime($publicacion->fecha))) }}" class="form-control form-control-sm"  name="fecha" id="fecha" required >
                        @error('fecha')
                        <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="row justify-content-center" style="margin-top: 10px;">
                    <div class="col-md-2">
                        <button id="btn_guardar" class="btn btn-primary" type="submit" id="btnGuardar">Guardar</button>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ url('sisadmin/publicacioncientifica/'.$unidad->und_id.'/lista')}}" class="btn btn-danger">Cancelar</a>
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
            asignarDatepicker($("#fecha"));
            $("#formulario").submit(function (){
                loaderR.showPleaseWait();
            });
            tinymce.init({
                selector: '#resumen',
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
