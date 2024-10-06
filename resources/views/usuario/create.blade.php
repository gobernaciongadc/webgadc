@extends('layouts.app')

@section('header_styles')
    <style type="text/css">

    </style>
@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if ($usuario->id == 0)
                <h3 align="center">Nuevo Usuario</h3>
            @else
                <h3 align="center">Editar Usuario</h3>
            @endif
            <br>
            <form class="form-horizontal" id="formulario" autocomplete="off" method="POST" action="{{ url('sisadmin/usuario/store') }}">
                {{ csrf_field() }}
                <div class="form-group row">
                    <label class="col-md-1 col-form-label"></label>
                    <label class="col-md-3 col-form-label" for="nombre">Nombre Completo*:</label>
                    <div class="col-md-8">
                        {{Form::hidden('id',$usuario->id)}}
                        {{Form::hidden('estado',$usuario->estado)}}
                        <input type="text" value="{{ old('name',$usuario->name) }}" class="form-control form-control-sm"  name="name" id="name" required >
                        @error('name')
                        <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-1 col-form-label"></label>
                    <label class="col-md-3 col-form-label">Correo Electrónico*:</label>
                    <div class="col-md-8">
                        <input type="email" value="{{ old('email',$usuario->email) }}" class="form-control form-control-sm"  name="email" id="email" required >
                        @error('email')
                        <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-1 col-form-label"></label>
                    <label class="col-md-3 col-form-label">Unidad*:</label>
                    <div class="col-md-8">
                        {{
                            Form::select('und_id',$unidades,$usuario->und_id,  ['class' => 'form-control form-control-sm','id' => 'und_id','required'=>'required'])
                        }}
                        @error('und_id')
                        <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                @if($usuario->id == 0)
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
                @endif
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
