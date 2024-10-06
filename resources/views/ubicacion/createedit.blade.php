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
    <!-- Breadcrumb Area Start -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tipologias</li>
            <li class="breadcrumb-item active" aria-current="page">Ubicacion</li>
        </ol>
    </nav>
    <!-- Breadcrumb Area End-->
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if ( $ubicacion->ubi_id == 0)
                <h3 align="center">Nueva Ubicacion</h3>
            @else
                <h3 align="center">Editar Ubicacion</h3>
            @endif
            <br>
            <form class="form-horizontal" id="formulario" autocomplete="off" method="POST" enctype="multipart/form-data" action="{{ url('sisadmin/ubicacion/store') }}">
                {{ csrf_field() }}
                <div class="col-md-12 row">
                    <div class="col-md-6">
                <div class="form-group row">
                    {{Form::hidden('ubi_id',$ubicacion->ubi_id)}}

                    <label class="col-md-3 col-form-label text-right" >Unidad*:</label>
                    <div class="col-md-9">
                        <input type="text" maxlength="200" value="{{ old('unidad',$ubicacion->unidad) }}" class="form-control form-control-sm"  name="unidad" id="unidad" required>
                        @error('unidad')
                        <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label text-right" >Lugar*:</label>
                    <div class="col-md-9">
                        <textarea rows="4" cols="40" name="lugar" id="lugar" required class="form-control form-control-sm">{{ old('lugar',$ubicacion->lugar) }}</textarea>
                        @error('lugar')
                        <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label text-right" >Direccion*:</label>
                    <div class="col-md-9">
                        <textarea rows="4" cols="40" name="direccion" id="direccion" required class="form-control form-control-sm">{{ old('direccion',$ubicacion->direccion) }}</textarea>
                        @error('direccion')
                        <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                @if ( $ubicacion->ubi_id == 0)
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label text-right">Nueva Imagen:</label>
                        <div class="col-md-9">
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
                        <div class="col-md-9">
                            {{
                                Html::image(asset('storage/uploads/'.$ubicacion->imagen), 'Sin imagen', array('id'=>'imagen', 'class' =>'img-thumbnail','width'=>'200'))
                            }}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label text-right">Nueva Imagen :</label>
                        <div class="col-md-9">
                            <input type="file" class="form-control-file form-control-sm" id="imagen" name="imagen" accept="image/jpeg, image/jpg, image/JPEG, image/JPG" >
                            <p style="font-size:12px">  La nueva imagen no puede ser mayor a 600 x 600 pixeles y debe de ser en formato jpeg o png y menor de 4Mb </p>
                            @error('imagen')
                            <p class="form-text text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                @endif

                <br>
            </div>
            <div class="col-md-6">
                <div class="form-group row">
                    <div id="map" class="map" style="margin-left:30px;" ><div id="popup"></div></div>
                    <!--MAPA end-->

                    <br>
                    <div class="col-md-12">
                        <div class="row" align="center">
                            <div class="col-md-6">
                                <label id="latitudVista" class="col-form-label text-right">Latitud: {{$ubicacion->latitud}}</label>
                            </div>
                            <div class="col-md-6">
                                <label id="longitudVista" class="col-form-label text-right">Longitud: {{$ubicacion->longitud}}</label>
                            </div>
                                <input type="hidden"  value="{{$ubicacion->latitud}}" name="latitud" id="latitud">
                                <input type="hidden"  value="{{$ubicacion->longitud}}"  name="longitud" id="longitud">
                        </div>
                    </div>
                </div><br>
              </div>
          </div>
          <div class="row justify-content-center" style="margin-top: 10px;">
                    <div class="col-md-2">
                        <button id="btn_guardar" class="btn btn-primary btn-sm" type="submit" id="btnGuardar">Guardar</button>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ url('sisadmin/ubicacion/') }}" class="btn btn-danger btn-sm">Cancelar</a>
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
        validarInputEntero("#telefono_1");
        var latitud = {{$ubicacion->latitud}};
        var longitud = {{$ubicacion->longitud}};
        var zoom = {{$zoom ?? 15}};

        $(document).ready(function(){
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
                    $("#latitudVista").text('Latitud: '+conversion[1]);
                    $("#longitudVista").text('Longitud: '+conversion[0]);
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
