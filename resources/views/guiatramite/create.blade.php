@extends('layouts.app')

@section('header_styles')
    <style type="text/css">

    </style>
@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if ($guia->gut_id == 0)
                <h3 align="center">Nueva Guía de Trámite</h3>
            @else
                <h3 align="center">Editar Guía de Trámite</h3>
            @endif
            <br>
            <form class="form-horizontal" id="formulario" autocomplete="off" method="POST" enctype="multipart/form-data" action="{{ url('sisadmin/guiatramite/store') }}">
                {{ csrf_field() }}
                <div class="form-group row">
                    <label class="col-md-1 col-form-label"></label>
                    <label class="col-md-2 col-form-label">Título*:</label>
                    <div class="col-md-8">
                        {{Form::hidden('gut_id',$guia->gut_id)}}
                        {{Form::hidden('und_id',$guia->und_id)}}
                        {{Form::hidden('estado',$guia->estado)}}
                        {{Form::hidden('publicar',$guia->publicar)}}
                        <input type="text" value="{{ old('titulo',$guia->titulo) }}" class="form-control form-control-sm"  name="titulo" id="titulo" required >
                        @error('titulo')
                        <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-1 col-form-label"></label>
                    <label class="col-md-2 col-form-label">Descripción*:</label>
                    <div class="col-md-8">
                        <textarea class="form-control form-control-sm" rows="3" cols="40" name="descripcion" id="descripcion" required>{{ old('descripcion',$guia->descripcion) }}</textarea>
                        @error('descripcion')
                        <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                @if($guia->gut_id == 0)
                    <div class="form-group row">
                        <label class="col-md-1 col-form-label"></label>
                        <label class="col-md-2 col-form-label">Archivo*:</label>
                        <div class="col-md-8">
                            <input type="file" class="form-control-file form-control-sm" id="archivo" name="archivo" accept="application/msword, application/vnd.ms-excel,.xlsx, application/pdf" required >
                            @error('archivo')
                            <p class="form-text text-danger">{{ $message }}</p>
                            @enderror
                            <p style="font-size:12px">  El archivo debe de ser en formato pdf,word o excel y menor de 4MB</p>
                        </div>
                    </div>
                @else
                    <div class="form-group row">
                        <label class="col-md-1 col-form-label"></label>
                        <label class="col-md-2 col-form-label">Archivo Actual:</label>
                        <div class="col-md-8">
                            <a target="_blank" href="{{asset('storage/uploads/'.$guia->archivo)}}"><i class="fa fa-download"></i> Descargar Archivo</a>
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
                            <p style="font-size:12px">  El archivo debe de ser en formato pdf,word o excel y menor de 4MB</p>
                        </div>
                    </div>

                @endif

                <br>

                <div class="row justify-content-center" style="margin-top: 10px;">
                    <div class="col-md-2">
                        <button id="btn_guardar" class="btn btn-primary" type="submit" id="btnGuardar">Guardar</button>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ url('sisadmin/guiatramite/'.$unidad->und_id.'/lista')}}" class="btn btn-danger">Cancelar</a>
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
