@extends('layouts.app')

@section('header_styles')
    <style type="text/css">

    </style>
@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if ($noticia->not_id == 0)
                <h3 align="center">Nueva Noticia</h3>
            @else
                <h3 align="center">Editar Noticia</h3>
            @endif
            <br>
            <form class="form-horizontal" id="formulario" autocomplete="off" method="POST" enctype="multipart/form-data" action="{{ url('sisadmin/noticia/store') }}">
                {{ csrf_field() }}
                <div class="form-group row">
                    <label class="col-md-1 col-form-label"></label>
                    <label class="col-md-2 col-form-label" for="nombre">Antetitulo*:</label>
                    <div class="col-md-8">
                        {{Form::hidden('not_id',$noticia->not_id)}}
                        {{Form::hidden('und_id',$noticia->und_id)}}
                        {{Form::hidden('estado',$noticia->estado)}}
                        {{Form::hidden('publicar',$noticia->publicar)}}
                        <input type="text" value="{{ old('antetitulo',$noticia->antetitulo) }}" class="form-control form-control-sm"  name="antetitulo" id="antetitulo" required >
                        @error('antetitulo')
                        <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-1 col-form-label"></label>
                    <label class="col-md-2 col-form-label">Título*:</label>
                    <div class="col-md-8">
                        <input type="text" value="{{ old('titulo',$noticia->titulo) }}" class="form-control form-control-sm"  name="titulo" id="titulo" required >
                        @error('titulo')
                        <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-1 col-form-label"></label>
                    <label class="col-md-2 col-form-label">Resumen*:</label>
                    <div class="col-md-8">
                        <input type="text" value="{{ old('resumen',$noticia->resumen) }}" class="form-control form-control-sm"  name="resumen" id="resumen" required >
                        @error('resumen')
                        <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-1 col-form-label"></label>
                    <label class="col-md-2 col-form-label">Contenido*:</label>
                    <div class="col-md-8">
                        <textarea class="form-control form-control-sm" rows="5" cols="40" name="contenido" id="contenido">{{ old('contenido',$noticia->contenido) }}</textarea>
                        @error('contenido')
                        <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                @if($noticia->not_id == 0)
                    <div class="form-group row">
                        <label class="col-md-1 col-form-label"></label>
                        <label class="col-md-2 col-form-label">Imagen*:</label>
                        <div class="col-md-8">
                            <input type="file" class="form-control-file form-control-sm" id="imagen" name="imagen" accept="image/jpeg, image/jpg, image/JPEG, image/JPG, image/png" required >
                            @error('imagen')
                            <p class="form-text text-danger">{{ $message }}</p>
                            @enderror
                            <p style="font-size:12px">  La imagen no puede ser mayor a 1240 x 870 pixeles y debe de ser en formato jpg o png y menor de 4MB</p>
                        </div>
                    </div>
                @else
                    <div class="form-group row">
                        <label class="col-md-1 col-form-label"></label>
                        <label class="col-md-2 col-form-label">Imagen Actual:</label>
                        <div class="col-md-8">
                            {{
                                Html::image(asset('storage/uploads/'.$noticia->imagen), 'Sin Imagen', array('id'=>'imagen', 'class' =>'img-thumbnail','width'=>'200'))
                            }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-1 col-form-label"></label>
                        <label class="col-md-2 col-form-label">Nueva Imagen*:</label>
                        <div class="col-md-8">
                            <input type="file" class="form-control-file form-control-sm" id="imagen" name="imagen" accept="image/jpeg, image/jpg, image/JPEG, image/JPG, image/png" >
                            @error('imagen')
                            <p class="form-text text-danger">{{ $message }}</p>
                            @enderror
                            <p style="font-size:12px">  La nueva imagen no puede ser mayor a 1240 x 870 pixeles y debe de ser en formato jpg o png y menor de 4MB</p>
                        </div>
                    </div>

                @endif

                <div class="form-group row">
                    <label class="col-md-1 col-form-label"></label>
                    <label class="col-md-2 col-form-label">Link Video:</label>
                    <div class="col-md-8">
                        <textarea class="form-control form-control-sm" rows="2" cols="20" name="link_video" id="link_video">{{ old('link_video',$noticia->link_video) }}</textarea>
                        @error('link_video')
                        <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <br>
                <div class="form-group row">
                    <label class="col-md-1 col-form-label"></label>
                    <label class="col-md-2 col-form-label">Categorias (Separadas por comas)*:</label>
                    <div class="col-md-8">
                        <input type="text" value="{{ old('categorias',$noticia->categorias) }}"  name="categorias" id="categorias" required >
                        @error('categorias')
                        <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <br>
                <div class="form-group row">
                    <label class="col-md-1 col-form-label"></label>
                    <label class="col-md-2 col-form-label">Palabras Clave (Separadas por comas)*:</label>
                    <div class="col-md-8">
                        <input type="text" value="{{ old('palabras_clave',$noticia->palabras_clave) }}"  name="palabras_clave" id="palabras_clave" required >
                        @error('palabras_clave')
                        <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <br>
                <div class="form-group row">
                    <label class="col-md-1 col-form-label"></label>
                    <label class="col-md-2 col-form-label">Fecha Noticia*:</label>
                    <div class="col-md-8">
                        <input onkeyup="return false;" type="text" value="{{ old('fecha',date('d/m/Y',strtotime($noticia->fecha))) }}" class="form-control form-control-sm"  name="fecha" id="fecha" required >
                        @error('fecha')
                        <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-1 col-form-label"></label>
                    <label class="col-md-2 col-form-label">Fuente*:</label>
                    <div class="col-md-8">
                        <textarea class="form-control form-control-sm" rows="2" cols="20" name="fuente" id="fuente" required>{{ old('fuente',$noticia->fuente) }}</textarea>
                        @error('fuente')
                        <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-1 col-form-label"></label>
                    <label class="col-md-2 col-form-label">Prioridad*:</label>
                    <div class="col-md-8">
                        {{
                            Form::select('prioridad',$prioridades,$noticia->prioridad,['class'=>'form-control form-control-sm','id'=>'prioridad','required'=>'required'])
                        }}
                        @error('prioridad')
                        <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="row justify-content-center" style="margin-top: 10px;">
                    <div class="col-md-2">
                        <button id="btn_guardar" class="btn btn-primary" type="submit" id="btnGuardar">Guardar</button>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ url('sisadmin/noticia/'.$unidad->und_id.'/lista')}}" class="btn btn-danger">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('footer_scripts')
    <script src="{{asset('js/tinymce.min.js')}}"></script>
    <script type="text/javascript">
        var categoriasDatos = {!! json_encode($categoriasDatos->toArray()) !!};
        var palabrasClaves = {!! json_encode($palabrasClavesDatos->toArray()) !!};
        //console.log(categoriasDatos);
        $(document).ready(function(){
            asignarDatepicker($("#fecha"));
            tinymce.init({
                selector: '#contenido',
                language: 'es',
                theme: 'modern',
                width: 565,
                height: 200,
                plugins: [
                    'advlist code lists charmap preview hr searchreplace wordcount visualblocks visualchars fullscreen',
                    'insertdatetime nonbreaking table contextmenu directionality paste link'
                ],
                //toolbar: ['fontselect fontsizeselect formatselect'],
                toolbar: 'fontselect fontsizeselect formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat',
            });
            $('#categorias').selectize({
                delimiter: ',',
                persist: false,
                maxItems:null,
                searchField: ['nombre'],
                valueField:'nombre',
                labelField: 'nombre',
                options:categoriasDatos,
                create: function(input) {
                    return {
                        nombre: input,
                        text: input
                    }
                }
            });
            $('#palabras_clave').selectize({
                delimiter: ',',
                persist: false,
                maxItems:null,
                searchField: ['nombre'],
                valueField:'nombre',
                labelField: 'nombre',
                options:palabrasClaves,
                create: function(input) {
                    return {
                        nombre: input,
                        text: input
                    }
                }
            });
            $("#formulario").submit(function (){
                loaderR.showPleaseWait();
            });
        });
    </script>
@endsection
