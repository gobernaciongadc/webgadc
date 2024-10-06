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
            <li class="breadcrumb-item active" aria-current="page">Planes</li>

        </ol>
    </nav>
    <!-- Breadcrumb Area End-->
    <div class="row justify-content-center">
        <div class="col-md-9">
            @if ( $plan->pla_id == 0)
                <h3 align="center">Nuevo Plan</h3>
            @else
                <h3 align="center">Editar Plan</h3>
            @endif
            <br>
            <form class="form-horizontal" id="formulario" autocomplete="off" method="POST" enctype="multipart/form-data" action="{{ url('sisadmin/plan/store') }}">
                {{ csrf_field() }}
                <div class="form-group row">
                    {{Form::hidden('pla_id',$plan->pla_id)}}
                    <label class="col-md-3 col-form-label text-right">Titulo*:</label>
                    <div class="col-md-8">
                        <textarea rows="3" cols="30" type="text"  class="form-control form-control-sm" name="titulo" id="titulo" required >{{ old('titulo',$plan->titulo) }}</textarea>
                        @error('titulo')
                        <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label text-right" >Periodo*:</label>
                    <div class="col-md-8">
                        <textarea rows="3" cols="30" type="text"  class="form-control form-control-sm" name="periodo" id="periodo" required >{{ old('periodo',$plan->periodo) }}</textarea>
                        @error('periodo')
                        <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>


                @if ( $plan->pla_id == 0)
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
                                Html::image(asset('storage/uploads/'.$plan->imagen), 'Sin imagen', array('id'=>'imagen', 'class' =>'img-thumbnail','width'=>'200'))
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
                @if ( $plan->pla_id == 0)
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label text-right">Archivo*:</label>
                        <div class="col-md-8">
                            <input type="file" class="form-control-file form-control-sm" id="link_descarga" name="link_descarga" accept="application/msword, application/vnd.ms-excel,.xlsx, application/pdf" required >
                            @error('link_descarga')
                            <p class="form-text text-danger">{{ $message }}</p>
                            @enderror
                            <p style="font-size:12px">  El archivo debe de ser en formato pdf,word o excel y menor de 4MB</p>
                        </div>
                    </div>
                @else
                    <br>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label text-right">Archivo Actual:</label>
                        <div class="col-md-8">
                            <a target="_blank" href="{{asset('storage/uploads/'.$plan->link_descarga)}}"><i class="fa fa-download"></i> Descargar Archivo</a>
                        </div>
                    </div>
                    <br>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label text-right">Nuevo Archivo:</label>
                        <div class="col-md-9">
                            <input type="file" class="form-control-file form-control-sm" id="link_descarga" name="link_descarga" accept="application/msword, application/vnd.ms-excel,.xlsx, application/pdf" >
                            @error('link_descarga')
                            <p class="form-text text-danger">{{ $message }}</p>
                            @enderror
                            <p style="font-size:12px">  El archivo debe de ser en formato pdf,word o excel y menor de 4MB</p>
                        </div>
                    </div>
                @endif

                <br><br>

                <div class="row justify-content-center" style="margin-top: 10px;">
                    <div class="col-md-2">
                        <button id="btn_guardar" class="btn btn-primary btn-sm" type="submit" id="btnGuardar">Guardar</button>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ url('sisadmin/plan/') }}" class="btn btn-danger btn-sm">Cancelar</a>
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
