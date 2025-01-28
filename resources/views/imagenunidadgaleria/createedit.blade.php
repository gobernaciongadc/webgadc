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
        <li class="breadcrumb-item active" aria-current="page">Despacho</li>
        <li class="breadcrumb-item active" aria-current="page">Imagen Galeria</li>
    </ol>
</nav>
<!-- Breadcrumb Area End-->
<div class="row justify-content-center">
    <div class="col-md-8">
        @if ( $imagenUnidadGaleria->iug_id == 0)
        <h3 align="center"></h3>
        @else
        <h3 align="center">Editar Imagen Campaña</h3>
        @endif
        <br>
        <form class="form-horizontal" id="formulario" autocomplete="off" method="POST" enctype="multipart/form-data" action="{{ url('sisadmin/imagenunidadgaleria/store') }}">

            {{ csrf_field() }}
            <div class="form-group row">
                {{Form::hidden('iug_id',$imagenUnidadGaleria->iug_id)}}
                <input type="hidden" value="{{$und_id}}" name="und_id" id="und_id">
                <input type="hidden" value="{{$ruta}}" name="ruta" id="ruta">
                <label class="col-md-3 col-form-label text-right">Titulo*:</label>
                <div class="col-md-7">
                    <input type="text" value="{{ old('titulo',$imagenUnidadGaleria->titulo) }}" class="form-control form-control-sm" name="titulo" id="titulo" required>
                    @error('titulo')
                    <p class="form-text text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>


            <textarea hidden rows="4" cols="40" type="text" class="form-control form-control-sm" name="descripcion" id="descripcion" required>{{ old('descripcion',$imagenUnidadGaleria->descripcion) }}Hola Mundo</textarea>



            @if ( $imagenUnidadGaleria->iug_id == 0)
            <div class="form-group row">
                <label class="col-md-3 col-form-label text-right">Imagen Portada WEB:</label>
                <div class="col-md-7">
                    <input type="file" class="form-control-file form-control-sm" id="imagen" name="imagen" accept="image/jpeg,image/jpg,image/JPEG,image/JPG" required>
                    @error('imagen')
                    <p class="form-text text-danger">{{ $message }}</p>
                    @enderror
                    <p style="font-size:12px"> La imagen debe ser de 1110 x 570 pixeles y debe de ser en formato jpeg o png y menor de 4Mb</p>
                </div>
            </div>
            @else
            <div class="form-group row">
                <label class="col-md-3 col-form-label text-right">Imagen actual:</label>
                <div class="col-md-7">
                    {{
                                Html::image(asset('storage/uploads/'.$imagenUnidadGaleria->imagen), 'Sin Imagen', array('id'=>'imagen', 'class' =>'img-thumbnail','width'=>'200'))
                            }}
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 col-form-label text-right">Nueva Imagen :</label>
                <div class="col-md-7">
                    <input type="file" class="form-control-file form-control-sm" id="imagen" name="imagen" accept="image/jpeg" accept="image/jpg" accept="image/JPEG" accept="image/JPG">
                    <p style="font-size:12px"> La imagen debe ser de 1920 x 1040 pixeles y debe de ser en formato jpeg o png y menor de 4Mb</p>
                    @error('imagen')
                    <p class="form-text text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            @endif

            <div class="row justify-content-center" style="margin-top: 10px;">
                <div class="col-md-2">
                    <button id="btn_guardar" class="btn btn-primary btn-sm" type="submit" id="btnGuardar">Guardar</button>
                </div>
                <div class="col-md-2">
                    <a href="{{ url('sisadmin/imagenunidadgaleria/'.$und_id.'/'.$ruta) }}" class="btn btn-danger btn-sm">Cancelar</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('footer_scripts')
<script type="text/javascript">
    $(document).ready(function() {
        $("#formulario").submit(function() {
            loaderR.showPleaseWait();
        });
    });
</script>
@endsection