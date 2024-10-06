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
            <li class="breadcrumb-item active" aria-current="page">Programas</li>
        </ol>
    </nav>
    <!-- Breadcrumb Area End-->
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if ( $programa->prg_id == 0)
                <h3 align="center">Nuevo Programa</h3>
            @else
                <h3 align="center">Editar Programa</h3>
            @endif
            <br>
            <form class="form-horizontal" id="formulario" autocomplete="off" method="POST" enctype="multipart/form-data" action="{{ url('sisadmin/programa/store') }}">
                {{ csrf_field() }}
                <div class="form-group row">
                    {{Form::hidden('prg_id',$programa->prg_id)}}
                    <input type="hidden" value="{{$und_id}}" name="und_id" id="und_id" >
                    <label class="col-md-3 col-form-label text-right" >Nombre*:</label>
                    <div class="col-md-7">
                        <textarea rows="3" cols="30" type="text"  class="form-control form-control-sm" name="nombre" id="nombre" required >{{ old('nombre',$programa->nombre) }}</textarea>

                        @error('nombre')
                        <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label text-right" >Sector*:</label>
                    <div class="col-md-7">
                        <input type="text" maxlength="100" value="{{ old('sector',$programa->sector) }}" class="form-control form-control-sm"  name="sector" id="sector" required>
                        @error('sector')
                        <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label text-right" >Objetivo*:</label>
                    <div class="col-md-7">
                        <textarea rows="3" cols="30" type="text"  class="form-control form-control-sm" name="objetivo" id="objetivo" required >{{ old('objetivo',$programa->objetivo) }}</textarea>
                        @error('objetivo')
                        <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label text-right" >Responsable*:</label>
                    <div class="col-md-7">
                        <input type="text" maxlength="200" value="{{ old('responsable',$programa->responsable) }}" class="form-control form-control-sm"  name="responsable" id="responsable" required>
                        @error('responsable')
                        <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>


                <div class="form-group row">
                    <label class="col-md-3 col-form-label text-right" >Presupuesto:</label>
                    <div class="col-md-4">
                        <input type="text" value="{{ old('presupuesto',$programa->presupuesto) }}" class="form-control form-control-sm"  name="presupuesto" id="presupuesto">
                        @error('presupuesto')
                        <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label text-right" >Beneficiario*:</label>
                    <div class="col-md-7">
                        <input type="text" maxlength="200" value="{{ old('benificiarios',$programa->benificiarios) }}" class="form-control form-control-sm"  name="benificiarios" id="benificiarios" required>
                        @error('benificiarios')
                        <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label text-right">Metas:</label>
                    <div class="col-md-7">
                        <textarea rows="3" cols="30" type="text" class="form-control form-control-sm" name="metas" id="metas">{{ old('metas',$programa->metas) }}</textarea>
                        @error('metas')
                            <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label text-right">Metas Alcanzadas:</label>
                    <div class="col-md-7">
                        <textarea rows="3" cols="30" type="text" class="form-control form-control-sm" name="metas_alcanzadas" id="metas_alcanzadas">{{ old('metas_alcanzadas',$programa->metas_alcanzadas) }}</textarea>
                        @error('metas_alcanzadas')
                        <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="row justify-content-center" style="margin-top: 10px;">
                    <div class="col-md-2">
                        <button id="btn_guardar" class="btn btn-primary btn-sm" type="submit" id="btnGuardar">Guardar</button>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ url('sisadmin/programa/'.$und_id.'/lista') }}" class="btn btn-danger btn-sm">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('footer_scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            validarInputDecimal("#presupuesto",2);
            $("#formulario").submit(function (){
                loaderR.showPleaseWait();
            });
        });

    </script>
@endsection
