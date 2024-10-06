

@extends('layouts.app')

@section('header_styles')
    <style type="text/css">


    </style>

@endsection


@section('content')

    <div class="row justify-content-center">
        <div class="col-md-7">
            <h3 align="center">Mi Perfil</h3>
            <form class="form-horizontal" autocomplete="off" method="POST" enctype="multipart/form-data" action="{{ url('sisadmin/usuario/updatemiperfil') }}">
                {{ csrf_field() }}

                <div class="form-group row">
                    <label class="col-md-4 col-form-label">Unidad*:</label>
                    <div class="col-md-8">
                        {{
                            Form::select('und_id',$unidades,$user->und_id,  ['class' => 'form-control form-control-sm','disabled' => 'disabled'])
                        }}
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-4 col-form-label">Nombre Completo*:</label>
                    <div class="col-md-8">
                        <input type="text" value="{{ old('name',$user->name)}}" class="form-control" name="name" id="name" required>
                        {{Form::hidden('estado',$user->estado)}}
                        {{Form::hidden('id',$user->id)}}
                        {{Form::hidden('und_id',$user->und_id)}}
                        @error('name')
                            <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-4 col-form-label">Correo Electronico*:</label>
                    <div class="col-md-8">
                        <input readonly="readonly" type="email" value="{{ old('email',$user->email) }}" class="form-control" name="email" id="email">
                    </div>
                </div>

                <hr>
                <p><b>Si desea cambiar su contraseña ingrese su nueva contraseña y repita, si no quiere cambiar su contraseña deje estos campos vacios.</b></p>
                <div class="form-group row">
                    <label class="col-md-4 col-form-label">Nueva contraseña*:</label>
                    <div class="col-md-8">
                        <input id="password" value="" type="password" class="form-control" name="password">
                        @error('password')
                            <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-4 col-form-label">Confirmar nueva contraseña*:</label>
                    <div class="col-md-8">
                        <input value="" id="password_confirmation" type="password" class="form-control" name="password_confirmation">
                    </div>
                </div>
                <hr>

                <div class="row justify-content-center">
                    <div class="col-md-2">
                        <button class="btn btn-primary" type="submit" id="btnGuardar">Guardar</button>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('home') }}" class="btn btn-danger">Cancelar</a>
                    </div>
                </div>

            </form>
        </div>
    </div>



@endsection

@section('footer_scripts')

    <script>
        $(document).ready(function(){





        });



    </script>
@stop

