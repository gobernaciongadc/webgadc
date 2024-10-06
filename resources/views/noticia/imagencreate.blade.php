@extends('layouts.app')
@section('header_styles')
    <style type="text/css">

    </style>
@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if ( $imagen->imn_id == 0)
                <h3 align="center">Nueva Imagen Para la Noticia: {{$noticia->titulo}}</h3>
            @else
                <h3 align="center">Editar Imagen Para la Noticia: {{$noticia->titulo}}</h3>
            @endif
            <br>
            <form class="form-horizontal" id="formulario" autocomplete="off" method="POST" enctype="multipart/form-data" action="{{ url('sisadmin/noticia/imagenes/store') }}">

                {{ csrf_field() }}
                <div class="form-group row">
                    {{Form::hidden('imn_id',$imagen->imn_id)}}
                    {{Form::hidden('not_id',$imagen->not_id)}}
                    {{Form::hidden('estado',$imagen->estado)}}
                    {{Form::hidden('publicar',$imagen->publicar)}}
                    <label class="col-md-3 col-form-label text-right" >Titulo*:</label>
                    <div class="col-md-7">
                        <input type="text" value="{{ old('titulo',$imagen->titulo) }}" class="form-control form-control-sm"  name="titulo" id="titulo" required>
                        @error('titulo')
                        <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label text-right" >Descripcion*:</label>
                    <div class="col-md-7">
                        <textarea rows="4" cols="40"  type="text"  class="form-control form-control-sm" name="descripcion" id="descripcion" required >{{ old('descripcion',$imagen->descripcion) }}</textarea>
                        @error('descripcion')
                        <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label text-right" >Fecha*:</label>
                    <div class="col-md-7">
                        <input type="text" onkeypress="return false;" value="{{ old('fecha',date('d/m/Y',strtotime($imagen->fecha))) }}" class="form-control form-control-sm"  name="fecha" id="fecha" required>
                        @error('fecha')
                        <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <br>
                @if ( $imagen->imn_id == 0)
                    <div class="form-group row">
                        <div class="col-md-3"></div>
                        <div class="col-md-7">
                            <p style="font-size:12px"><b>Si sube mas de una imagen, las demas imagenes tendran el mismo título y descripción actual.</b></p>
                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-md-3 col-form-label text-right">Imagenes*:</label>
                        <div class="col-md-7">

                            <input type="file" class="form-control-file form-control-sm" id="imagen" name="imagen[]" multiple accept="image/jpeg, image/jpg, image/JPEG, image/JPG, image/png" required >
                            @error('imagen')
                            <p class="form-text text-danger">{{ $message }}</p>
                            @enderror
                            <p style="font-size:12px">  Las imagenes no puede ser mayor a 1240 x 870 pixeles y debe de ser en formato jpg o png y menor de 4MB</p>
                        </div>
                    </div>
                @else
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label text-right">Imagen actual:</label>
                        <div class="col-md-7">
                            {{
                                Html::image(asset('storage/uploads/'.$imagen->imagen), 'Sin Imagen', array('id'=>'imagen', 'class' =>'img-thumbnail','width'=>'200'))
                            }}
                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-md-3 col-form-label text-right">Nueva Imagen :</label>
                        <div class="col-md-7">
                            <input type="file" class="form-control-file form-control-sm" id="imagen" name="imagen" accept="image/jpeg, image/jpg, image/JPEG, image/JPG, image/png">
                            @error('imagen')
                            <p class="form-text text-danger">{{ $message }}</p>
                            @enderror
                            <p style="font-size:12px">  La nueva imagen no puede ser mayor a 1240 x 870 pixeles y debe de ser en formato jpg o png y menor de 4MB </p>
                        </div>
                    </div>
                @endif

                <div class="row justify-content-center" style="margin-top: 10px;">
                    <div class="col-md-2">
                        <button id="btn_guardar" class="btn btn-primary btn-sm" type="submit" id="btnGuardar">Guardar</button>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ url('sisadmin/noticia/imagenes/'.$noticia->not_id) }}" class="btn btn-danger btn-sm">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('footer_scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            asignarDatepicker($("#fecha"));
            $("#formulario").submit(function (){
                loaderR.showPleaseWait();
            });
        });
    </script>
@endsection
