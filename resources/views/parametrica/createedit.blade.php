@extends('layouts.app')
@section('header_styles')
    <style type="text/css">

    </style>
@endsection
@section('content')

    <div class="row justify-content-center">
        <div class="col-md-8">
                <h3 align="center">Editar Parametrica</h3>
            <br>
            <form class="form-horizontal" id="formulario" autocomplete="off" method="POST" enctype="multipart/form-data" action="{{ url('sisadmin/parametrica/store') }}">
                {{ csrf_field() }}
                <div class="form-group row">
                    {{Form::hidden('par_id',$parametrica->par_id)}}
                    <label class="col-md-3 col-form-label text-right" >Codigo*:</label>
                    <div class="col-md-7">
                        <input type="text" value="{{ old('codigo',$parametrica->codigo) }}" class="form-control form-control-sm"  name="codigo" id="codigo" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label text-right" >Valor 1:</label>
                    <div class="col-md-7">
                        <input type="text" value="{{ old('valor1',$parametrica->valor1) }}" class="form-control form-control-sm"  name="valor1" id="valor1">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label text-right" >Valor 2:</label>
                    <div class="col-md-7">
                        <input type="text" value="{{ old('valor2',$parametrica->valor2) }}" class="form-control form-control-sm"  name="valor2" id="valor2">
                    </div>
                </div>
                                <div class="form-group row">
                    <label class="col-md-3 col-form-label text-right" >Valor 3:</label>
                    <div class="col-md-7">
                        <input type="text" value="{{ old('valor3',$parametrica->valor3) }}" class="form-control form-control-sm"  name="valor3" id="valor3">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label text-right" >Valor 4:</label>
                    <div class="col-md-7">
                        <input type="text" value="{{ old('valor4',$parametrica->valor4) }}" class="form-control form-control-sm"  name="valor4" id="valor4">
                    </div>
                </div>
                                <div class="form-group row">
                    <label class="col-md-3 col-form-label text-right" >Valor 5:</label>
                    <div class="col-md-7">
                        <input type="text" value="{{ old('valor5',$parametrica->valor5) }}" class="form-control form-control-sm"  name="valor5" id="valor5">
                    </div>
                </div>


                <div class="row justify-content-center" style="margin-top: 10px;">
                    <div class="col-md-2">
                        <button id="btn_guardar" class="btn btn-primary btn-sm" type="submit" id="btnGuardar">Guardar</button>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ url('sisadmin/parametrica/') }}" class="btn btn-danger btn-sm">Cancelar</a>
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
