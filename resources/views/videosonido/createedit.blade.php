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
            <li class="breadcrumb-item active" aria-current="page">Mi unidad</li>
            <li class="breadcrumb-item active" aria-current="page">Video sonido</li>
        </ol>
    </nav>
    <!-- Breadcrumb Area End-->
    <div class="row justify-content-center">
        <div class="col-md-10">
            @if ( $videoSonido->vis_id == 0)
                <h3 align="center">Nuevo Video sonido</h3>
            @else
                <h3 align="center">Editar Video sonido</h3>

            @endif
            <br>
            <form class="form-horizontal" id="formulario" autocomplete="off" method="POST" enctype="multipart/form-data" action="{{ url('sisadmin/videosonido/store') }}">
                {{ csrf_field() }}
                <div class="form-group row">
                    {{Form::hidden('vis_id',$videoSonido->vis_id)}}
                    <input type="hidden" value="{{$und_id}}" name="und_id" id="und_id">
                    <label class="col-md-3 col-form-label text-right">Titulo*:</label>
                    <div class="col-md-7">
                        <input type="text" value="{{ old('titulo',$videoSonido->titulo) }}" class="form-control form-control-sm"  name="titulo" id="titulo" required>
                        @error('titulo')
                        <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label text-right" >Descripcion*:</label>
                    <div class="col-md-7">
                        <textarea rows="4" cols="40"  type="text"  class="form-control form-control-sm" name="descripcion" id="descripcion" required >{{ old('descripcion',$videoSonido->descripcion) }}</textarea>
                        @error('descripcion')
                        <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div><br>

                @if ( $videoSonido->vis_id == 0)
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label text-right">Fecha*:</label>
                        <div class="col-md-4">
                        <input type="text"   value="{{date('d/m/Y')}}"  class="form-control form-control-sm"  name="fecha" id="fecha" onkeypress="return false;" required="required">
                        </div>
                    </div>
                @else
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label text-right">Fecha*:</label>
                        <div class="col-md-4">
                        <input type="text"   value="{{ old('fecha',date('d/m/Y',strtotime($videoSonido->fecha))) }}" class="form-control form-control-sm"  name="fecha" id="fecha" onkeypress="return false;" required="required">
                        </div>
                    </div>
                @endif

                <div class="form-group row">
                    <label class="col-md-3 col-form-label text-right">Link descarga*:</label>
                    <div class="col-md-7">
                        <input type="text" value="{{ old('link_descarga',$videoSonido->link_descarga) }}" class="form-control form-control-sm"  name="link_descarga" id="link_descarga" required>
                        @error('link_descarga')
                        <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                        <p style="font-size:12px">Solo Link de Youtube </p>
                    </div>
                </div><br><br>

                <div class="row justify-content-center" style="margin-top: 10px;">
                    <div class="col-md-2">
                        <button id="btn_guardar" class="btn btn-primary btn-sm" type="submit" id="btnGuardar">Guardar</button>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ url('sisadmin/videosonido/'.$und_id) }}" class="btn btn-danger btn-sm">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('footer_scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            asignarDatepicker("#fecha");
            $("#formulario").submit(function (){
                loaderR.showPleaseWait();
            });
        });
    </script>
@endsection
