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
            <li class="breadcrumb-item active" aria-current="page">Administracion</li>
            <li class="breadcrumb-item active" aria-current="page">Denuncia</li>
        </ol>
    </nav>
    <!-- Breadcrumb Area End-->
    <div class="row justify-content-center">
        <div class="col-md-10">
            
            <h3 align="center">Denuncia</h3><br>
            <form class="form-horizontal" id="formulario" autocomplete="off" method="POST" enctype="multipart/form-data" action="{{ url('sisadmin/biografia/store') }}">
                {{ csrf_field() }}
                <div class="form-group row">
                    <label class="col-md-3 col-form-label text-right">Nombre:</label>
                    <div class="col-md-7">
                        <input type="text" value="{{ old('nombre',$Denuncia->nombre) }}" class="form-control form-control-sm"  name="nombres" id="nombres" >
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label text-right">Correo:</label>
                    <div class="col-md-7">
                        <input type="text" value="{{ old('correo',$Denuncia->correo) }}" class="form-control form-control-sm"  name="correo" id="correo" >
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label text-right" >Ip terminal:</label>
                    <div class="col-md-7">
                        <input type="text" maxlength="300" value="{{ old('ip_terminal',$Denuncia->ip_terminal) }}" class="form-control form-control-sm"  name="ip_terminal" id="ip_terminal" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label text-right" >Denuncia:</label>
                    <div class="col-md-7">
                        <textarea rows="3" cols="30" type="text"  class="form-control form-control-sm" name="denuncia" id="denuncia" required >{{ old('denuncia',$Denuncia->denuncia) }}</textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label text-right" >Fecha y hora:</label>
                    <div class="col-md-7">
                        <input type="text" maxlength="300" value="{{date('d/m/Y h-m-s',strtotime($Denuncia->fecha_hora))}}" class="form-control form-control-sm"  name="fecha_hora" id="fecha_hora" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label text-right" >Celular:</label>
                    <div class="col-md-7">
                        <input type="text" maxlength="300" value="{{ old('celular',$Denuncia->celular) }}" class="form-control form-control-sm"  name="celular" id="celular" required>
                    </div>
                </div><br><br>
                <div class="row justify-content-center" style="margin-top: 10px;">
                        <a href="{{ url('sisadmin/denuncia/') }}" class="btn btn-warning"> Atras</a>
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
