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
            <li class="breadcrumb-item active" aria-current="page">Tipologias</li>
            <li class="breadcrumb-item active" aria-current="page">Hoy en la Historia</li>
        </ol>
    </nav>
    <!-- Breadcrumb Area End-->
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if ( $hoyHistoria->hoh_id == 0)
                <h3 align="center">Nuevo Hoy en la historia</h3>
            @else
                <h3 align="center">Editar Hoy en la historia</h3>
            @endif
            <br>
            <form class="form-horizontal" id="formulario" autocomplete="off" method="POST" enctype="multipart/form-data" action="{{ url('sisadmin/hoyhistoria/store') }}">
                {{ csrf_field() }}
                <div class="col-md-12 row">
                    <div class="col-md-7">
                        <div class="form-group row">
                            {{Form::hidden('hoh_id',$hoyHistoria->hoh_id)}}
                            <label class="col-md-3 col-form-label text-right" >Titulo*:</label>
                            <div class="col-md-7">
                                <textarea rows="3" cols="30" name="titulo" id="titulo" required class="form-control form-control-sm">{{ old('titulo',$hoyHistoria->titulo) }}</textarea>
                                @error('titulo')
                                <p class="form-text text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right" >Acontecimiento*:</label>
                            <div class="col-md-7">
                                <textarea rows="4" cols="40" name="acontecimiento" id="acontecimiento" required class="form-control form-control-sm">{{ old('acontecimiento',$hoyHistoria->acontecimiento) }}</textarea>
                                @error('acontecimiento')
                                <p class="form-text text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        @if ( $hoyHistoria->hoh_id == 0)
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label text-right">Fecha*:</label>
                                <div class="col-md-4">
                                    <input type="text" value="{{date('d/m/Y')}}"  class="form-control form-control-sm"  name="fecha" id="fecha" onkeypress="return false;" required="required">
                                </div>
                            </div>
                        @else
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label text-right">Fecha*:</label>
                                <div class="col-md-4">
                                    <input type="text" value="{{ old('fecha',date('d/m/Y',strtotime($hoyHistoria->fecha))) }}" class="form-control form-control-sm"  name="fecha" id="fecha" onkeypress="return false;" required="required">
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-5">
                        @if ( $hoyHistoria->hoh_id == 0)
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label text-right">Nueva Imagen:</label>
                                <div class="col-md-7">
                                    <input type="file" class="form-control-file form-control-sm" id="imagen" name="imagen" accept="image/jpeg,image/jpg,image/JPEG,image/JPG" required >
                                    @error('imagen')
                                    <p class="form-text text-danger">{{ $message }}</p>
                                    @enderror
                                    <p style="font-size:12px">  La imagen no puede ser mayor a 600 x 600 pixeles y debe de ser en formato jpeg o png y menor de 4Mb</p>
                                </div>
                            </div>
                        @else
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label text-right">Imagen actual:</label>
                                <div class="col-md-7">
                                    {{
                                        Html::image(asset('storage/uploads/'.$hoyHistoria->imagen), 'Sin Fotografia', array('id'=>'imagen', 'class' =>'img-thumbnail','width'=>'200'))
                                    }}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label text-right">Nueva Imagen :</label>
                                <div class="col-md-7">
                                    <input type="file" class="form-control-file form-control-sm" id="imagen" name="imagen" accept="image/jpeg, image/jpg, image/JPEG, image/JPG" >
                                    <p style="font-size:12px">  La nueva imagen no puede ser mayor a 600 x 600 pixeles y debe de ser en formato jpeg o png y menor de 4Mb </p>
                                    @error('imagen')
                                    <p class="form-text text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="row justify-content-center" style="margin-top: 10px;">
                    <div class="col-md-2">
                        <button id="btn_guardar" class="btn btn-primary btn-sm" type="submit" id="btnGuardar">Guardar</button>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ url('sisadmin/hoyhistoria/') }}" class="btn btn-danger btn-sm">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('footer_scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            asignarDatepicker("#fecha");
            $("#formulario").submit(function (){
                loaderR.showPleaseWait();
            });
        });
    </script>
@endsection
