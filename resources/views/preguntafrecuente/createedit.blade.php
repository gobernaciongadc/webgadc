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
            <li class="breadcrumb-item active" aria-current="page">Tipologías</li>
            <li class="breadcrumb-item active" aria-current="page">Preguntas frecuentes</li>
        </ol>
    </nav>
    <!-- Breadcrumb Area End-->
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if ( $preguntafrecuente->prf_id == 0)
                <h3 align="center">Nueva Pregunta frecuente</h3>
            @else
                <h3 align="center">Editar Pregunta frecuente</h3>
            @endif
            <br>
            <form class="form-horizontal" id="formulario" autocomplete="off" method="POST" enctype="multipart/form-data" action="{{ url('sisadmin/preguntafrecuente/store') }}">
                {{ csrf_field() }}
                <div class="form-group row">
                    {{Form::hidden('prf_id',$preguntafrecuente->prf_id)}}
                    <label class="col-md-3 col-form-label text-right" >Pregunta*:</label>
                    <div class="col-md-7">
                        <textarea rows="4" cols="40" name="pregunta" id="pregunta" required class="form-control form-control-sm">{{ old('pregunta',$preguntafrecuente->pregunta) }}</textarea>
                        @error('pregunta')
                        <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label text-right" >Respuesta*:</label>
                    <div class="col-md-7">
                        <textarea rows="4" cols="40" name="respuesta" id="respuesta" required class="form-control form-control-sm">{{ old('respuesta',$preguntafrecuente->respuesta) }}</textarea>
                        @error('respuesta')
                        <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="row justify-content-center" style="margin-top: 10px;">
                    <div class="col-md-2">
                        <button id="btn_guardar" class="btn btn-primary btn-sm" type="submit" id="btnGuardar">Guardar</button>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ url('sisadmin/preguntafrecuente/') }}" class="btn btn-danger btn-sm">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('footer_scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            $("#formulario").submit(function (){
                loaderR.showPleaseWait();
            });
        });
    </script>
@endsection
