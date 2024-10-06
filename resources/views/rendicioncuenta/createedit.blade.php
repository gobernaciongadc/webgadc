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
            <li class="breadcrumb-item active" aria-current="page">Rendicion de cuentas</li>
        </ol>
    </nav>
    <!-- Breadcrumb Area End-->
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if ( $rendicionCuenta->rec_id == 0)
                <h3 align="center">Nueva Rendicion de cuentas</h3>
            @else
                <h3 align="center">Editar Rendicion de cuentas</h3>
            @endif
            <br>
            <form class="form-horizontal" id="formulario" autocomplete="off" method="POST" enctype="multipart/form-data" action="{{ url('sisadmin/rendicioncuenta/store') }}">
                {{ csrf_field() }}
                <div class="form-group row">
                    {{Form::hidden('rec_id',$rendicionCuenta->rec_id)}}
                    <input type="hidden" value="{{$und_id}}" name="und_id" id="und_id" >
                    <label class="col-md-3 col-form-label text-right" >Titulo*:</label>
                    <div class="col-md-7">
                        <textarea rows="3" cols="30" name="titulo" id="titulo" required class="form-control form-control-sm">{{ old('titulo',$rendicionCuenta->titulo) }}</textarea>
                        @error('titulo')
                        <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label text-right" >resumen*:</label>
                    <div class="col-md-7">
                        <textarea rows="4" cols="40" name="descripcion" id="descripcion" required class="form-control form-control-sm">{{ old('descripcion',$rendicionCuenta->descripcion) }}</textarea>
                        @error('descripcion')
                        <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                @if ($rendicionCuenta->rec_id == 0)
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label text-right">Archivo*:</label>
                        <div class="col-md-9">
                            <input type="file" class="form-control-file form-control-sm" id="archivo" name="archivo" accept="application/msword, application/vnd.ms-excel,.xlsx, application/pdf" required >
                            @error('archivo')
                            <p class="form-text text-danger">{{ $message }}</p>
                            @enderror
                            <p style="font-size:12px">  El archivo debe de ser en formato pdf,word o excel y menor de 20MB</p>
                        </div>
                    </div>
                @else
                    <br>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label text-right">Archivo Actual:</label>
                        <div class="col-md-9">
                            <a target="_blank" href="{{asset('storage/uploads/'.$rendicionCuenta->archivo)}}"><i class="fa fa-download"></i> Descargar Archivo</a>
                        </div>
                    </div>
                    <br>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label text-right">Nuevo Archivos*:</label>
                        <div class="col-md-9">
                            <input type="file" class="form-control-file form-control-sm" id="archivo" name="archivo" accept="application/msword, application/vnd.ms-excel,.xlsx, application/pdf" >
                            @error('archivo')
                            <p class="form-text text-danger">{{ $message }}</p>
                            @enderror
                            <p style="font-size:12px">  El archivo debe de ser en formato pdf,word o excel y menor de 20MB</p>
                        </div>
                    </div>
                @endif

                <div class="row justify-content-center" style="margin-top: 10px;">
                    <div class="col-md-2">
                        <button id="btn_guardar" class="btn btn-primary btn-sm" type="submit" id="btnGuardar">Guardar</button>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ url('sisadmin/rendicioncuenta/'.$und_id.'/lista') }}" class="btn btn-danger btn-sm">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('footer_scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            asignarDatepicker("#fecha_publicacion");
            $("#formulario").submit(function (){
                loaderR.showPleaseWait();
            });
        });
    </script>
@endsection
