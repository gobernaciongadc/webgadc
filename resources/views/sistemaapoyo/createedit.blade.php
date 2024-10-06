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
            <li class="breadcrumb-item active" aria-current="page">Sistemas de Apoyo</li>

        </ol>
    </nav>
    <!-- Breadcrumb Area End-->
    <div class="row justify-content-center">
        <div class="col-md-9">
            @if ( $sistemaApoyo->sia_id == 0)
                <h3 align="center">Nuevo Sistemas de Apoyo</h3>
            @else
                <h3 align="center">Editar Sistemas de Apoyo</h3>
            @endif
            <br>
            <form class="form-horizontal" id="formulario" autocomplete="off" method="POST" enctype="multipart/form-data" action="{{ url('sisadmin/sistemaapoyo/store') }}">
                {{ csrf_field() }}
                <div class="form-group row">
                    {{Form::hidden('sia_id',$sistemaApoyo->sia_id)}}
                    <label class="col-md-3 col-form-label text-right">Nombre*:</label>
                    <div class="col-md-8">
                        <textarea rows="3" cols="30" type="text"  class="form-control form-control-sm" name="nombre" id="nombre" required >{{ old('nombre',$sistemaApoyo->nombre) }}</textarea>
                        @error('nombre')
                        <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label text-right" >Link destino*:</label>
                    <div class="col-md-8">
                        <textarea rows="3" cols="30" type="text"  class="form-control form-control-sm" name="link_destino" id="link_destino" required >{{ old('link_destino',$sistemaApoyo->link_destino) }}</textarea>
                        @error('link_destino')
                        <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>


                @if ( $sistemaApoyo->sia_id == 0)
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label text-right">Nueva Imagen:</label>
                        <div class="col-md-8">
                            <input type="file" class="form-control-file form-control-sm" id="imagen" name="imagen" accept="image/jpeg,image/jpg,image/JPEG,image/JPG" required >
                            @error('imagen')
                            <p class="form-text text-danger">{{ $message }}</p>
                            @enderror
                            <p style="font-size:12px">  La imagen no puede ser mayor a 600 x 600 pixeles y debe de ser en formato jpeg o png y menor de 4Mb</p>
                        </div>
                    </div>
                @else
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label text-right">Imagen:</label>
                        <div class="col-md-8">
                            {{
                                Html::image(asset('storage/uploads/'.$sistemaApoyo->imagen), 'Sin imagen', array('id'=>'imagen', 'class' =>'img-thumbnail','width'=>'200'))
                            }}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label text-right">Nueva Imagen:</label>
                        <div class="col-md-8">
                            <input type="file" class="form-control-file form-control-sm" id="imagen" name="imagen" accept="image/jpeg, image/jpg, image/JPEG, image/JPG" >
                            <p style="font-size:12px">  La nueva imagen no puede ser mayor a 600 x 600 pixeles y debe de ser en formato jpeg o png y menor de 4Mb </p>
                            @error('imagen')
                            <p class="form-text text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                @endif
                <br><br>

                <div class="row justify-content-center" style="margin-top: 10px;">
                    <div class="col-md-2">
                        <button id="btn_guardar" class="btn btn-primary btn-sm" type="submit" id="btnGuardar">Guardar</button>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ url('sisadmin/sistemaapoyo/') }}" class="btn btn-danger btn-sm">Cancelar</a>
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
