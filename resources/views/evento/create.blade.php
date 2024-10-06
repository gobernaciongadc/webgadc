@extends('layouts.app')

@section('header_styles')
    <link rel="stylesheet" href="{{asset('css/ol.css')}}" type="text/css">
    <style type="text/css">
        .map {
            height: 400px;
            width: 100%;
        }
    </style>
@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if ($evento->eve_id == 0)
                <h3 align="center">Nuevo Evento</h3>
            @else
                <h3 align="center">Editar Evento</h3>
            @endif
            <br>
            <form class="form-horizontal" id="formulario" autocomplete="off" method="POST" enctype="multipart/form-data" action="{{ url('sisadmin/evento/store') }}">
                {{ csrf_field() }}
                <div class="form-group row">
                    <label class="col-md-1 col-form-label"></label>
                    <label class="col-md-2 col-form-label">Nombre*:</label>
                    <div class="col-md-8">
                        {{Form::hidden('eve_id',$evento->eve_id)}}
                        {{Form::hidden('und_id',$evento->und_id)}}
                        {{Form::hidden('estado',$evento->estado)}}
                        {{Form::hidden('publicar',$evento->publicar)}}
                        <input type="text" value="{{ old('nombre',$evento->nombre) }}" class="form-control form-control-sm"  name="nombre" id="nombre" required >
                        @error('nombre')
                        <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-1 col-form-label"></label>
                    <label class="col-md-2 col-form-label">Descripción*:</label>
                    <div class="col-md-8">
                        <textarea class="form-control form-control-sm" rows="3" cols="40" name="descripcion" id="descripcion" required>{{ old('descripcion',$evento->descripcion) }}</textarea>
                        @error('descripcion')
                        <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-1 col-form-label"></label>
                    <label class="col-md-2 col-form-label">Fecha Hora Inicio*:</label>
                    <div class="col-md-3">
                        <input onkeyup="return false;" type="text" value="{{ old('fecha_inicio',date('d/m/Y',strtotime($evento->fecha_hora_inicio))) }}" class="form-control form-control-sm"  name="fecha_inicio" id="fecha_inicio" required >
                        @error('fecha_inicio')
                        <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <label class="col-md-1 col-form-label">Hora:</label>
                    <div class="col-md-2">
                        {{Form::select('hora_inicio',$horas,date('H',strtotime($evento->fecha_hora_inicio)),['class'=>'form-control form-control-sm','required'=>'required'])}}
                    </div>
                    <label class="col-md-1 col-form-label">Minuto:</label>
                    <div class="col-md-2">
                        {{Form::select('minuto_inicio',$minutos,date('i',strtotime($evento->fecha_hora_inicio)),['class'=>'form-control form-control-sm','required'=>'required'])}}
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-1 col-form-label"></label>
                    <label class="col-md-2 col-form-label">Fecha Hora Fin*:</label>
                    <div class="col-md-3">
                        <input onkeyup="return false;" type="text" value="{{ old('fecha_fin',date('d/m/Y',strtotime($evento->fecha_hora_fin))) }}" class="form-control form-control-sm"  name="fecha_fin" id="fecha_fin" required >
                        @error('fecha_fin')
                        <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <label class="col-md-1 col-form-label">Hora:</label>
                    <div class="col-md-2">
                        {{Form::select('hora_fin',$horas,date('H',strtotime($evento->fecha_hora_fin)),['class'=>'form-control form-control-sm','required'=>'required'])}}
                    </div>
                    <label class="col-md-1 col-form-label">Minuto:</label>
                    <div class="col-md-2">
                        {{Form::select('minuto_fin',$minutos,date('i',strtotime($evento->fecha_hora_fin)),['class'=>'form-control form-control-sm','required'=>'required'])}}
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-1 col-form-label"></label>
                    <label class="col-md-2 col-form-label">Público*:</label>
                    <div class="col-md-8">
                        <input type="text" value="{{ old('publico',$evento->publico) }}" class="form-control form-control-sm"  name="publico" id="publico" required >
                        @error('publico')
                        <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                @if($evento->eve_id == 0)
                    <div class="form-group row">
                        <label class="col-md-1 col-form-label"></label>
                        <label class="col-md-2 col-form-label">Imagen*:</label>
                        <div class="col-md-8">
                            <input type="file" class="form-control-file form-control-sm" id="imagen" name="imagen" accept="image/jpeg, image/jpg, image/JPEG, image/JPG, image/png" required >
                            @error('imagen')
                            <p class="form-text text-danger">{{ $message }}</p>
                            @enderror
                            <p style="font-size:12px">  La imagen no puede ser mayor a 1100 x 1700 pixeles y debe de ser en formato jpg o png y menor de 4MB</p>
                        </div>
                    </div>
                @else
                    <div class="form-group row">
                        <label class="col-md-1 col-form-label"></label>
                        <label class="col-md-2 col-form-label">Imagen Actual:</label>
                        <div class="col-md-8">
                            {{
                                Html::image(asset('storage/uploads/'.$evento->imagen), 'Sin Imagen', array('id'=>'imagen', 'class' =>'img-thumbnail','width'=>'200'))
                            }}
                        </div>
                    </div>
                    <br>
                    <div class="form-group row">
                        <label class="col-md-1 col-form-label"></label>
                        <label class="col-md-2 col-form-label">Nueva Imagen*:</label>
                        <div class="col-md-8">
                            <input type="file" class="form-control-file form-control-sm" id="imagen" name="imagen" accept="image/jpeg, image/jpg, image/JPEG, image/JPG, image/png" >
                            @error('imagen')
                            <p class="form-text text-danger">{{ $message }}</p>
                            @enderror
                            <p style="font-size:12px">  La imagen no puede ser mayor a 1100 x 1700 pixeles y debe de ser en formato jpg o png y menor de 4MB</p>
                        </div>
                    </div>

                @endif
                <br>

                <div class="form-group row">
                    <label class="col-md-1 col-form-label"></label>
                    <label class="col-md-2 col-form-label">Lugar*:</label>
                    <div class="col-md-8">
                        <input type="text" value="{{ old('lugar',$evento->lugar) }}" class="form-control form-control-sm"  name="lugar" id="lugar" required >
                        @error('lugar')
                        <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-1 col-form-label"></label>
                    <label class="col-md-2 col-form-label">Dirección*:</label>
                    <div class="col-md-8">
                        <input type="text" value="{{ old('direccion',$evento->direccion) }}" class="form-control form-control-sm"  name="direccion" id="direccion" required >
                        @error('direccion')
                        <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <br>
                @if($evento->eve_id == 0)
                    <div class="form-group row">
                        <label class="col-md-1 col-form-label"></label>
                        <label class="col-md-2 col-form-label">Imagen Dirección*:</label>
                        <div class="col-md-8">
                            <input type="file" class="form-control-file form-control-sm" id="imagen_direccion" name="imagen_direccion" accept="image/jpeg, image/jpg, image/JPEG, image/JPG, image/png" required >
                            @error('imagen_direccion')
                            <p class="form-text text-danger">{{ $message }}</p>
                            @enderror
                            <p style="font-size:12px">  La imagen no puede ser mayor a 600 x 600 pixeles y debe de ser en formato jpg o png y menor de 4MB</p>
                        </div>
                    </div>
                @else
                    <div class="form-group row">
                        <label class="col-md-1 col-form-label"></label>
                        <label class="col-md-2 col-form-label">Imagen Dirección Actual:</label>
                        <div class="col-md-8">
                            {{
                                Html::image(asset('storage/uploads/'.$evento->imagen_direccion), 'Sin Imagen', array('id'=>'imagen', 'class' =>'img-thumbnail','width'=>'200'))
                            }}
                        </div>
                    </div>
                    <br>
                    <div class="form-group row">
                        <label class="col-md-1 col-form-label"></label>
                        <label class="col-md-2 col-form-label">Nueva Imagen Dirección*:</label>
                        <div class="col-md-8">
                            <input type="file" class="form-control-file form-control-sm" id="imagen_direccion" name="imagen_direccion" accept="image/jpeg, image/jpg, image/JPEG, image/JPG, image/png" >
                            @error('imagen_direccion')
                            <p class="form-text text-danger">{{ $message }}</p>
                            @enderror
                            <p style="font-size:12px">  La imagen no puede ser mayor a 600 x 600 pixeles y debe de ser en formato jpg o png y menor de 4MB</p>
                        </div>
                    </div>

                @endif
                <br>
                <div class="form-group row">
                    <label class="col-md-1 col-form-label"></label>
                    <label class="col-md-2 col-form-label">Mapa*:</label>
                    <input type="hidden" name="latitud" id="latitud" value="{{$evento->latitud}}">
                    <input type="hidden" name="longitud" id="longitud" value="{{$evento->longitud}}">
                    <div class="col-md-8">
                        <div id="map">

                        </div>
                    </div>
                </div>


                <div class="row justify-content-center" style="margin-top: 10px;">
                    <div class="col-md-2">
                        <button id="btn_guardar" class="btn btn-primary" type="submit" id="btnGuardar">Guardar</button>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ url('sisadmin/evento/'.$unidad->und_id.'/lista')}}" class="btn btn-danger">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('footer_scripts')
    <script type="text/javascript" src="{{asset('js/ol.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/proj4.js')}}"></script>
    <script type="text/javascript">
        var latitud = {{$evento->latitud}};
        var longitud = {{$evento->longitud}};
        var zoom = {{$zoom ?? 18}};
        $(document).ready(function(){
            asignarDatepicker($("#fecha_inicio"));
            asignarDatepicker($("#fecha_fin"));
            $("#formulario").submit(function (){
                loaderR.showPleaseWait();
            });

            //mapa
            //capa de open street map
            raster = new ol.layer.Tile({
                source: new ol.source.OSM()
            });
            //capa de vector para trazar sobre ella
            source = new ol.source.Vector({wrapX: false});
            //styles para punto y linea
            stylePoint = new ol.style.Style({
                image: new ol.style.Circle({
                    radius: 12,
                    stroke: new ol.style.Stroke({
                        color: 'white',
                        width: 3
                    }),
                    fill: new ol.style.Fill({
                        color: '#266cfb'
                    })
                })
            });
            vector = new ol.layer.Vector({
                source: source,
                style: [stylePoint]
            });

            var puntoInicial = new ol.Feature({
                geometry: new ol.geom.Point(ol.proj.fromLonLat([longitud, latitud])),
                labelPoint: new ol.geom.Point(ol.proj.fromLonLat([longitud, latitud])),
                name: 'My Polygon'
            });
            //colocamos el punto inicial
            vector.getSource().addFeature(puntoInicial);
            //event cuando se termina de dibujar
            vector.getSource().on('addfeature', function(event) {
                console.log(event);
                var features = vector.getSource().getFeatures();
                var cantidad = features.length;
                var indice = 0;
                var feactureRemover = null;
                //controlamos que sea solo un punto
                features.forEach(function(feature) {
                    if (cantidad == 2){
                        if (indice == 0){
                            feactureRemover = feature;
                        }
                    }
                    indice++;
                });
                if (feactureRemover != null){
                    vector.getSource().removeFeature(feactureRemover);
                }
                //escogemos el punto a mostrar
                var featuresDos = vector.getSource().getFeatures();
                featuresDos.forEach(function (feature){
                    var puntoCoordenada = feature.getGeometry().getCoordinates();
                    var conversion = ol.proj.transform(puntoCoordenada, 'EPSG:3857','EPSG:4326');
                    console.log(puntoCoordenada);
                    console.log(conversion);
                    $("#latitud").val(conversion[1]);
                    $("#longitud").val(conversion[0]);
                });
            });

            //creacion del mapa
            map = new ol.Map({
                layers: [raster, vector],
                target: 'map',
                view: new ol.View({
                    center: ol.proj.fromLonLat([longitud, latitud]),
                    zoom: zoom,
                    projection: 'EPSG:3857'//utm
                })
            });
            //creacion full screen
            fullscreen = new ol.control.FullScreen();
            map.addControl(fullscreen);

            draw = new ol.interaction.Draw({
                source: source,
                type: 'Point'
            });

            map.addInteraction(draw);

        });
    </script>
@endsection
