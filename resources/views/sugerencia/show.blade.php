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
            <li class="breadcrumb-item active" aria-current="page">Sugerencia</li>
        </ol>
    </nav>
    <!-- Breadcrumb Area End-->
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h3 align="center">Sugerencia</h3><br>
            <form class="form-horizontal" id="formulario" autocomplete="off" method="POST" enctype="multipart/form-data" action="{{ url('sisadmin/biografia/store') }}">
                {{ csrf_field() }}
                <div class="form-group row">
                    <label class="col-md-3 col-form-label text-right">Sugerencia:</label>
                    <div class="col-md-7">
                        <textarea rows="3" cols="30" type="text"  class="form-control form-control-sm" name="sugerencia" id="sugerencia" required >{{ old('sugerencia',$Sugerencia->sugerencia) }}</textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label text-right">Fecha:</label>
                    <div class="col-md-7">
                        <input type="text" value="{{ old('fecha',$Sugerencia->fecha) }}" class="form-control form-control-sm"  name="fecha" id="fecha" >
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label text-right" >Ip terminal:</label>
                    <div class="col-md-7">
                        <input type="text" maxlength="300" value="{{ old('ip_terminal',$Sugerencia->ip_terminal) }}" class="form-control form-control-sm"  name="ip_terminal" id="ip_terminal" required>
                    </div>
                </div>

                <br><br>
                <div class="row justify-content-center" style="margin-top: 10px;">
                     <a href="{{ url('sisadmin/sugerencia/') }}" class="btn btn-warning"> Atras</a>
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
