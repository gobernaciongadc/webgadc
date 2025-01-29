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
        <li class="breadcrumb-item active" aria-current="page">Mi Unidad</li>
        <li class="breadcrumb-item active" aria-current="page">Documento legal</li>
    </ol>
</nav>
<!-- Breadcrumb Area End-->
<div class="row justify-content-center">
    <div class="col-md-8">
        @if ( $documentoLegal->dol_id == 0)
        <h3 align="center">Nuevo Documento legal</h3>
        @else
        <h3 align="center">Editar Documento legal</h3>
        @endif
        <br>
        <form class="form-horizontal" id="formulario" autocomplete="off" method="POST" enctype="multipart/form-data" action="{{ url('sisadmin/documentolegal/store') }}">
            {{ csrf_field() }}
            <div class="form-group row">
                {{Form::hidden('dol_id',$documentoLegal->dol_id)}}
                <input type="hidden" value="{{$und_id}}" name="und_id" id="und_id">
                <label class="col-md-3 col-form-label text-right">Titulo*:</label>
                <div class="col-md-8">
                    <textarea rows="3" cols="30" type="text" class="form-control form-control-sm" name="titulo" id="titulo" required>{{ old('titulo',$documentoLegal->titulo) }}</textarea>
                    @error('titulo')
                    <p class="form-text text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 col-form-label text-right">Tipo documento legal*:</label>
                <div class="col-md-8">
                    {{
                             Form::select('tdl_id',$listaTipoDocumentosLegales, $documentoLegal->tdl_id,  ['class' => 'form-control form-control-sm','id' => 'tdl_id','style' => 'width:100%;' ,'name'=>'tdl_id','require'=>'require'])
                        }}
                </div>
                @error('tdl_id')
                <p class="form-text text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group row">
                <label class="col-md-3 col-form-label text-right">Resumen*:</label>
                <div class="col-md-8">
                    <textarea rows="3" cols="30" type="text" class="form-control form-control-sm" name="resumen" id="resumen" required>{{ old('resumen',$documentoLegal->resumen) }}</textarea>
                    @error('resumen')
                    <p class="form-text text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-3 col-form-label text-right">Contenido*:</label>
                <div class="col-md-8">
                    <textarea rows="3" cols="30" type="text" class="form-control form-control-sm" name="contenido" id="contenido" required>{{ old('contenido',$documentoLegal->contenido) }}</textarea>
                    @error('contenido')
                    <p class="form-text text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            @if ( $documentoLegal->dol_id == 0)
            <div class="form-group row">
                <label class="col-md-3 col-form-label text-right">Fecha publicación*:</label>
                <div class="col-md-4">
                    <input type="text" value="{{date('d/m/Y')}}" class="form-control form-control-sm" name="fecha_aprobacion" id="fecha_aprobacion" onkeypress="return false;" required="required">
                </div>
            </div>
            @else
            <div class="form-group row">
                <label class="col-md-3 col-form-label text-right">Fecha publicación*:</label>
                <div class="col-md-4">
                    <input type="text" value="{{ old('fecha_aprobacion',date('d/m/Y',strtotime($documentoLegal->fecha_aprobacion))) }}" class="form-control form-control-sm" name="fecha_aprobacion" id="fecha_aprobacion" onkeypress="return false;" required="required">
                </div>
            </div>
            @endif
            @if ( $documentoLegal->dol_id == 0)
            <div class="form-group row">
                <label class="col-md-3 col-form-label text-right">Fecha promulgacion ó emisión*:</label>
                <div class="col-md-4">
                    <input type="text" value="{{date('d/m/Y')}}" class="form-control form-control-sm" name="fecha_promulgacion" id="fecha_promulgacion" onkeypress="return false;" required="required">
                </div>
            </div>
            @else
            <div class="form-group row">
                <label class="col-md-3 col-form-label text-right">Fecha promulgacion ó emisión*:</label>
                <div class="col-md-4">
                    <input type="text" value="{{ old('fecha_promulgacion',date('d/m/Y',strtotime($documentoLegal->fecha_promulgacion))) }}" class="form-control form-control-sm" name="fecha_promulgacion" id="fecha_promulgacion" onkeypress="return false;" required="required">
                </div>
            </div>
            @endif

            <div class="form-group row">
                <label class="col-md-3 col-form-label text-right">Número Documento*:</label>
                <div class="col-md-4">
                    <input type="text" maxlength="50" value="{{ old('numero_documento',$documentoLegal->numero_documento) }}" class="form-control form-control-sm" name="numero_documento" id="numero_documento" required>
                    @error('numero_documento')
                    <p class="form-text text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            @if ( $documentoLegal->dol_id == 0)
            <div class="form-group row">
                <label class="col-md-1 col-form-label"></label>
                <label class="col-md-2 col-form-label text-right">Archivo*:</label>
                <div class="col-md-8">
                    <input type="file" class="form-control-file form-control-sm" id="archivo" name="archivo" accept="application/msword, application/vnd.ms-excel,.xlsx, application/pdf" required>
                    @error('archivo')
                    <p class="form-text text-danger">{{ $message }}</p>
                    @enderror
                    <p style="font-size:12px"> El archivo debe de ser en formato pdf,word o excel y menor de 40MB</p>
                </div>
            </div>
            @else
            <br>
            <div class="form-group row">
                <label class="col-md-1 col-form-label"></label>
                <label class="col-md-2 col-form-label text-right">Archivo Actual:</label>
                <div class="col-md-8">
                    <a target="_blank" href="{{asset('storage/uploads/'.$documentoLegal->archivo)}}"><i class="fa fa-download"></i> Descargar Archivo</a>
                </div>
            </div>
            <br>
            <div class="form-group row">
                <label class="col-md-1 col-form-label"></label>
                <label class="col-md-2 col-form-label text-right">Nuevo Archivo*:</label>
                <div class="col-md-8">
                    <input type="file" class="form-control-file form-control-sm" id="archivo" name="archivo" accept="application/msword, application/vnd.ms-excel,.xlsx, application/pdf">
                    @error('archivo')
                    <p class="form-text text-danger">{{ $message }}</p>
                    @enderror
                    <p style="font-size:12px"> El archivo debe de ser en formato pdf,word o excel y menor de 40MB</p>
                </div>
            </div>
            @endif

            <!-- ANEXO -->
            @if ( $documentoLegal->dol_id == 0)
            <div class="form-group row">
                <label class="col-md-1 col-form-label"></label>
                <label class="col-md-2 col-form-label text-right">Anexo<span class="text-danger font-10">(Opcional)</span>:</label>
                <div class="col-md-8">
                    <input type="file" class="form-control-file form-control-sm" id="anexo" name="anexo" accept="application/msword, application/vnd.ms-excel,.xlsx, application/pdf" required>
                    @error('archivo')
                    <p class="form-text text-danger">{{ $message }}</p>
                    @enderror
                    <p style="font-size:12px"> El archivo debe de ser en formato pdf,word o excel y menor de 40MB</p>
                </div>
            </div>
            @else
            <br>
            <div class="form-group row">
                <label class="col-md-1 col-form-label"></label>
                <label class="col-md-2 col-form-label text-right">Anexo Actual:</label>
                <div class="col-md-8">
                    @if ($documentoLegal->anexo != null)
                    <a target="_blank" href="{{asset('storage/uploads/'.$documentoLegal->anexo)}}"><i class="fa fa-download"></i> Descargar Archivo</a>
                    @else
                    <p>Sin Anexo</p>
                    @endif
                </div>
            </div>
            <br>
            <div class="form-group row">
                <label class="col-md-1 col-form-label"></label>
                <label class="col-md-2 col-form-label text-right">Nuevo Anexo*<span class="text-danger font-10">(Opcional)</span>:</label>
                <div class="col-md-8">
                    <input type="file" class="form-control-file form-control-sm" id="anexo" name="anexo" accept="application/msword, application/vnd.ms-excel,.xlsx, application/pdf">
                    @error('anexo')
                    <p class="form-text text-danger">{{ $message }}</p>
                    @enderror
                    <p style="font-size:12px"> El archivo debe de ser en formato pdf,word o excel y menor de 40MB</p>
                </div>
            </div>
            @endif


            <div class="row justify-content-center" style="margin-top: 10px;">
                <div class="col-md-2">
                    <button id="btn_guardar" class="btn btn-primary btn-sm" type="submit" id="btnGuardar">Guardar</button>
                </div>
                <div class="col-md-2">
                    <a href="{{ url('sisadmin/documentolegal/'.$und_id.'/lista') }}" class="btn btn-danger btn-sm">Cancelar</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('footer_scripts')
<script type="text/javascript">
    $(document).ready(function() {
        asignarDatepicker("#fecha_aprobacion");
        asignarDatepicker("#fecha_promulgacion");
        $("#formulario").submit(function() {
            loaderR.showPleaseWait();
        });
    });
</script>
@endsection