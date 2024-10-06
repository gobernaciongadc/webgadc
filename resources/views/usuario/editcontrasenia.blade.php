@extends('layouts.app')

@section('header_styles')
    <style type="text/css">

    </style>
@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h3 align="center">Editar Contraseña del Usuario: {{$usuario->name}}</h3>
            <br>
            <form class="form-horizontal" id="formulario" autocomplete="off" method="POST" action="{{ url('sisadmin/usuario/storeContrasenia') }}">
                {{ csrf_field() }}
                {{Form::hidden('id',$usuario->id)}}
                <div class="form-group row">
                    <label class="col-md-1 col-form-label"></label>
                    <label class="col-md-3 col-form-label">Contraseña*:</label>
                    <div class="col-md-8">
                        <input type="password" value="" class="form-control form-control-sm"  name="password" id="password" required >
                        @error('password')
                        <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-1 col-form-label"></label>
                    <label class="col-md-3 col-form-label">Confirmar Contraseña*:</label>
                    <div class="col-md-8">
                        <input type="password" value="" class="form-control form-control-sm"  name="password_confirmation" id="password_confirmation" required >
                    </div>
                </div>

                <div class="row justify-content-center" style="margin-top: 10px;">
                    <div class="col-md-2">
                        <button id="btn_guardar" class="btn btn-primary" type="submit" id="btnGuardar">Guardar</button>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ url('sisadmin/usuario/usuarios')}}" class="btn btn-danger">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('footer_scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            /*$("#formulario").submit(function (){
                loaderR.showPleaseWait();
            });*/
        });
    </script>
@endsection
