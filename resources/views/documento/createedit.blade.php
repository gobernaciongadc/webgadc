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
            <li class="breadcrumb-item active" aria-current="page">Documento</li>

        </ol>
    </nav>
    <!-- Breadcrumb Area End-->
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if ( $documento->doc_id == 0)
                <h3 align="center">Nuevo Documento</h3>
            @else
                <h3 align="center">Editar Documento</h3>
            @endif
            <br>
            <form class="form-horizontal" id="formulario" autocomplete="off" method="POST" enctype="multipart/form-data" action="{{ url('sisadmin/documento/store') }}">
                {{ csrf_field() }}
                <div class="form-group row">
                    {{Form::hidden('doc_id',$documento->doc_id)}}
                    <input type="hidden" value="{{$und_id}}" name="und_id" id="und_id" >
                    <label class="col-md-3 col-form-label text-right" >Titulo*:</label>
                    <div class="col-md-7">
                        <textarea rows="3" cols="30" type="text"  class="form-control form-control-sm" name="titulo" id="titulo" required >{{ old('titulo',$documento->titulo) }}</textarea>
                        @error('titulo')
                        <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label text-right">Tipo documento legal*:</label>
                    <div class="col-md-7">
                        {{
                             Form::select('tid_id',$listaTipoDocumentos, $documento->tid_id,  ['class' => 'form-control form-control-sm','id' => 'tid_id','style' => 'width:100%;' ,'name'=>'tid_id','require'=>'require'])
                        }}
                    </div>
                    @error('tid_id')
                    <p class="form-text text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label text-right" >Resumen*:</label>
                    <div class="col-md-7">
                        <textarea rows="3" cols="30" type="text"  class="form-control form-control-sm" name="resumen" id="resumen" required >{{ old('resumen',$documento->resumen) }}</textarea>
                        @error('resumen')
                        <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>


                @if ( $documento->doc_id == 0)
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label text-right">fecha_publicacion*:</label>
                        <div class="col-md-4">
                            <input type="text"   value="{{date('d/m/Y')}}"  class="form-control form-control-sm"  name="fecha_publicacion" id="fecha_publicacion" onkeypress="return false;" required="required">
                        </div>
                    </div>
                @else
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label text-right">Fecha*:</label>
                        <div class="col-md-4">
                            <input type="text"   value="{{ old('fecha_publicacion',date('d/m/Y',strtotime($documento->fecha_publicacion))) }}" class="form-control form-control-sm"  name="fecha_publicacion" id="fecha_publicacion" onkeypress="return false;" required="required">
                        </div>
                    </div>
                @endif
                @if ( $documento->doc_id == 0)
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label text-right" >Archivo*:</label>
                        <div class="col-md-8">
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
                        <label class="col-md-1 col-form-label"></label>
                        <label class="col-md-2 col-form-label">Archivo Actual:</label>
                        <div class="col-md-8">
                            <a target="_blank" href="{{asset('storage/uploads/'.$documento->archivo)}}"><i class="fa fa-download"></i> Descargar Archivo</a>
                        </div>
                    </div>
                    <br>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Nuevo Archivo*:</label>
                        <div class="col-md-8">
                            <input type="file" class="form-control-file form-control-sm" id="archivo" name="archivo" accept="application/msword, application/vnd.ms-excel,.xlsx, application/pdf" >
                            @error('archivo')
                            <p class="form-text text-danger">{{ $message }}</p>
                            @enderror
                            <p style="font-size:12px">  El archivo debe de ser en formato pdf,word o excel y menor de 20MB</p>
                        </div>
                    </div>
                @endif

                <br><br>
                <div class="row justify-content-center" style="margin-top: 10px;">
                    <div class="col-md-2">
                        <button id="btn_guardar" class="btn btn-primary btn-sm" type="submit" id="btnGuardar">Guardar</button>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ url('sisadmin/documento/'.$und_id.'/lista') }}" class="btn btn-danger btn-sm">Cancelar</a>
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
