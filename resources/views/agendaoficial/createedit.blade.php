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
            <li class="breadcrumb-item active" aria-current="page">Agenda Oficial</li>
        </ol>
    </nav>
    <!-- Breadcrumb Area End-->
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if ( $agendaOficial->ago_id == 0)
                <h3 align="center">Nueva Agenda Oficial</h3>
            @else
                <h3 align="center">Editar Agenda Oficial</h3>
            @endif
            <br>
            <form class="form-horizontal" id="formulario" autocomplete="off" method="POST" enctype="multipart/form-data" action="{{ url('sisadmin/agendaoficial/store') }}">
                {{ csrf_field() }}
                {{Form::hidden('ago_id',$agendaOficial->ago_id)}}
                @if ( $agendaOficial->ago_id == 0)
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label text-right">Fecha*:</label>
                        <div class="col-md-4">
                            <input type="text" value="{{date('d/m/Y')}}"  class="form-control form-control-sm"  name="fecha" id="fecha" onkeypress="return false;" required="required">
                        </div>
                    </div>
                @else
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label text-right">Fecha*:</label>
                        <div class="col-md-4">
                            <input type="text" value="{{ old('fecha',date('d/m/Y',strtotime($agendaOficial->fecha))) }}" class="form-control form-control-sm"  name="fecha" id="fecha" onkeypress="return false;" required="required">
                        </div>
                    </div>
                @endif

                @if ( $agendaOficial->ago_id == 0)
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label text-right">Archivo*:</label>
                        <div class="col-md-9">
                            <input type="file" class="form-control-file form-control-sm" id="archivo" name="archivo" accept="application/msword, application/vnd.ms-excel,.xlsx, application/pdf" required >
                            @error('archivo')
                            <p class="form-text text-danger">{{ $message }}</p>
                            @enderror
                            <p style="font-size:12px">  El archivo debe de ser en formato pdf,word o excel y menor de 4MB</p>
                        </div>
                    </div>
                @else
                    <br>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label text-right">Archivo Actual:</label>
                        <div class="col-md-9">
                            <a target="_blank" href="{{asset('storage/uploads/'.$agendaOficial->archivo)}}"><i class="fa fa-download"></i> Descargar Archivo</a>
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
                            <p style="font-size:12px">  El archivo debe de ser en formato pdf,word o excel y menor de 4MB</p>
                        </div>
                    </div>
                @endif

                <div class="row justify-content-center" style="margin-top: 10px;">
                    <div class="col-md-2">
                        <button id="btn_guardar" class="btn btn-primary btn-sm" type="submit" id="btnGuardar">Guardar</button>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ url('sisadmin/agendaoficial/') }}" class="btn btn-danger btn-sm">Cancelar</a>
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
