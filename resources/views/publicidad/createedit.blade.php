@extends('layouts.app')

@section('header_styles')
    <style type="text/css">

    </style>
@endsection
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Administracion</li>
            <li class="breadcrumb-item active" aria-current="page">Publicidad</li>        </ol>
    </nav>
    <div class="row justify-content-center">
        <div class="col-md-1"></div>
        <div class="col-md-8">
            @if ($publicidad->pub_id == 0)
                <h3 align="center">Nueva Publicidad</h3>
            @else
                <h3 align="center">Editar Publicidad</h3>
            @endif
            <br><br>
            <form class="form-horizontal" id="formulario" autocomplete="off" method="POST" enctype="multipart/form-data" action="{{ url('sisadmin/publicidad/store') }}">
                {{ csrf_field() }}
                                {{Form::hidden('pub_id',$publicidad->pub_id)}}
                                {{Form::hidden('estado',$publicidad->estado)}}
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right" >Nombre:</label>
                            <div class="col-md-8">
                                <input type="text"  value="{{ old('nombre',$publicidad->nombre) }}" class="form-control form-control-sm"  name="nombre" id="nombre"  required="required">

                            </div>
                        </div>

                        @if ($publicidad->pub_id != 0)
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label text-right" >Fecha desde:</label>
                                <div class="col-md-3">
                                    <input type="text"   value="{{ old('fecha_desde',date('d/m/Y',strtotime($publicidad->fecha_desde))) }}" class="form-control form-control-sm"  name="fecha_desde" id="fecha_desde" onkeypress="return false;" required="required">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label text-right" >Hasta:</label>
                                <div class="col-md-3">
                                    <input type="text"   value="{{ old('fecha_hasta',date('d/m/Y',strtotime($publicidad->fecha_hasta))) }}" class="form-control form-control-sm"  name="fecha_hasta" id="fecha_hasta" onkeypress="return false;" required="required">
                                </div>
                            </div>
                        @else
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label text-right" >Fecha desde:</label>
                                <div class="col-md-3">
                                    <input type="text" value="{{date('d/m/Y')}}" class="form-control form-control-sm"  name="fecha_desde" id="fecha_desde" onkeypress="return false;" required="required">
                                </div>
                            </div>
                             <div class="form-group row">
                                <label class="col-md-3 col-form-label text-right" >Hasta:</label>
                                <div class="col-md-3">
                                    <input type="text" value="{{date('d/m/Y')}}" class="form-control form-control-sm"  name="fecha_hasta" id="fecha_hasta" onkeypress="return false;" required="required">
                                </div>
                            </div>
                        @endif
                        <input type="hidden" value="{{ old('solicitante',$publicidad->solicitante) }}" class="form-control form-control-sm"  name="solicitante" id="solicitante" >
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right" >Link destino:</label>
                            <div class="col-md-8">
                                <input type="text"  value="{{ old('link_destino',$publicidad->link_destino) }}" class="form-control form-control-sm"  name="link_destino" id="link_destino"  required="required">
                            </div>
                        </div>

                        @if ($publicidad->pub_id == 0)
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label text-right">Imagen publicidad:</label>
                                <div class="col-md-8">
                                    <input type="file" class="form-control-file form-control-sm" id="imagen" name="imagen"
                                    accept="image/PNG, image/JPG, image/JPEG , image/GIF, image/png image/jpg, image/jpeg, image/gif" required  >
                                    <p style="font-size:12px">  La imagen no puede ser mayor a 350 x 170 pixeles y debe de ser en formato jpeg,png o gif y menor de 4Mb </p>
                                    @error('imagen')
                                    <p class="form-text text-danger">{{ $message }}</p>
                                    @enderror
                                    <div id= "contenidottext"></div>
                                </div>
                            </div><br>
                        @else
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label text-right">Imagen  actual:</label>
                                <div class="col-md-8">
                                    {{
                                        Html::image(asset('storage/uploads/'.$publicidad->imagen), 'Sin Imagen', array('id'=>'imagen', 'class' =>'img-thumbnail'))
                                    }}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label text-right">Nueva Imagen icono:</label>
                                <div class="col-md-8">
                                    <input type="file" class="form-control-file form-control-sm" id="imagen" name="imagen" accept="image/PNG, image/JPG, image/JPEG , image/GIF, image/png image/jpg, image/jpeg, image/gif" >
                                    <p style="font-size:12px">  La nueva imagen no puede ser mayor a 350 x 170 pixeles y debe de ser en formato jpeg,png o gif y menor de 4Mb </p>
                                </div>
                            </div>
                        @endif
                        <br><br><br>
                        <div class="row justify-content-center" style="margin-top: 10px;">
                            <div class="col-md-2">
                                <button id="btn_guardar" class="btn btn-primary btn-sm" type="submit" id="btnGuardar">Guardar</button>
                            </div>
                            <div class="col-md-2">

                                <a href="{{ url('sisadmin/publicidad/') }}" class="btn btn-danger btn-sm">Cancelar</a>
                            </div>
                        </div>


            </form>

        </div>
    </div>
@endsection

@section('footer_scripts')
    <script type="text/javascript">
        validarInputDecimal("#monto",2);
        validarInputDecimal("#costo_maximo",2);

        $(document).ready(function(){
            asignarDatepicker("#fecha_desde");
            asignarDatepicker("#fecha_hasta");
            asignarDatepicker("#fecha_pago");

            $("#formulario").submit(function (){
                loaderR.showPleaseWait();
            });
        });



    </script>
@endsection
