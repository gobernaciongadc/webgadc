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
            <li class="breadcrumb-item active" aria-current="page">Organización / Unidad</li>
        </ol>
    </nav>
    <!-- Breadcrumb Area End-->
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if ($unidadUnidad->und_id == 0)
                <h3 align="center">Nuevo Unidad</h3>
            @else
                <h3 align="center">Editar Unidad</h3>
            @endif
            @if ($unidadUnidad->und_id == 0)
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link" id="uno-tab" data-toggle="tab" href="#panel-uno" role="tab" aria-controls="panel-uno" aria-selected="false">Paso 1 (Datos generales)</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="dos-tab" data-toggle="tab" href="#panel-dos" role="tab" aria-controls="pandel-dos" aria-selected="false">Paso 2 (Imagenes)</a>
                    </li>

                </ul>
            @else
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link" id="uno-tab" data-toggle="tab" href="#panel-uno" role="tab" aria-controls="panel-uno" aria-selected="false">Datos generales</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="dos-tab" data-toggle="tab" href="#panel-dos" role="tab" aria-controls="panel-dos" aria-selected="false">Imagenes</a>
                    </li>
                </ul>
            @endif
            <br>
            <form id="formulario" autocomplete="off" method="POST" enctype="multipart/form-data" action="{{ url('sisadmin/unidadunidad/store') }}">
                <div class="tab-content" id="myTabContent">
                    {{ csrf_field() }}
                    <div class="tab-pane fade" id="panel-uno" role="tabpanel" aria-labelledby="uno-tab">
                        <div class="col-md-12 row"><br><br>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label text-right">Biografía:</label>
                                    <div class="col-md-9">
                                        {{
                                             Form::select('bio_id',$listaBiografias, $unidadUnidad->bio_id,  ['class' => 'form-control form-control-sm','id' => 'bio_id','style' => 'width:100%;' ,'name'=>'bio_id'])
                                        }}
                                    </div>
                                    @error('bio_id')
                                    <p class="form-text text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label text-right">Unidad padre*:</label>
                                    <div class="col-md-9">
                                        {{
                                             Form::select('und_padre_id',$listaComboUnidades, $unidadUnidad->und_padre_id,  ['class' => 'form-control form-control-sm','id' => 'und_padre_id','style' => 'width:100%;' ,'name'=>'und_padre_id','require'=>'require'])
                                        }}
                                    </div>
                                    @error('und_id')
                                    <p class="form-text text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label text-right" for="nombre_producto">Nombre*:</label>
                                    <div class="col-md-9">
                                        {{Form::hidden('und_id',$unidadUnidad->und_id)}}
                                        {{Form::hidden('estado',$unidadUnidad->estado)}}


                                        <input type="text" value="{{ old('nombre',$unidadUnidad->nombre) }}" class="form-control form-control-sm"  name="nombre" id="nombre" required >
                                        @error('nombre')
                                        <p class="form-text text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label text-right">Mision:</label>
                                    <div class="col-md-9">
                                        <textarea rows="2" cols="40" type="text"  class="form-control form-control-sm" name="mision" id="mision">{{ old('mision',$unidadUnidad->mision) }}</textarea>
                                        @error('mision')
                                        <p class="form-text text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label text-right">Vision:</label>
                                    <div class="col-md-9">
                                        <textarea rows="2" cols="40" type="text"  class="form-control form-control-sm" name="vision" id="vision">{{ old('vision',$unidadUnidad->vision) }}</textarea>
                                        @error('vision')
                                        <p class="form-text text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label text-right">Objetivo*:</label>
                                    <div class="col-md-9">
                                        <textarea rows="2" cols="40" type="text"  class="form-control form-control-sm" name="objetivo" id="objetivo" required >{{ old('objetivo',$unidadUnidad->objetivo) }}</textarea>
                                        @error('objetivo')
                                        <p class="form-text text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label text-right">Historia/Descripcion*:</label>
                                    <div class="col-md-9">
                                        <textarea rows="2" cols="40" type="text"  class="form-control form-control-sm" name="historia" id="historia" required >{{ old('historia',$unidadUnidad->historia) }}</textarea>
                                        @error('historia')
                                        <p class="form-text text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-md-1 col-form-label"></label>
                                    <label class="col-md-3 col-form-label text-right">Telefono:</label>
                                    <div class="col-md-8">
                                        <input type="text"   value="{{ old('telefonos',$unidadUnidad->telefonos) }}" class="form-control form-control-sm"  name="telefonos" id="telefonos">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label text-right">Celular(Whats App):</label>
                                    <div class="col-md-8">
                                        <input type="text" maxlength="10" value="{{ old('celular_wp',$unidadUnidad->celular_wp) }}" class="form-control form-control-sm"  name="celular_wp" id="celular_wp"  >
                                        @error('celular_wp')
                                        <p class="form-text text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label text-right">Correo:</label>
                                    <div class="col-md-8">
                                        <input type="email" value="{{ old('email',$unidadUnidad->email) }}" class="form-control form-control-sm"  name="email" id="email" >
                                        @error('email')
                                        <p class="form-text text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label text-right">Link facebook:</label>
                                    <div class="col-md-8">
                                        <input type="text"  value="{{ old('link_facebook',$unidadUnidad->link_facebook)}}" class="form-control form-control-sm"  name="link_facebook" id="link_facebook" >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label text-right">Link twiter:</label>
                                    <div class="col-md-8">
                                        <input type="text"  value="{{ old('link_twiter',$unidadUnidad->link_twiter)}}" class="form-control form-control-sm"  name="link_twiter" id="link_twiter" >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label text-right">Link instagram:</label>
                                    <div class="col-md-8">
                                        <input type="text"  value="{{ old('link_instagram',$unidadUnidad->link_instagram)}}" class="form-control form-control-sm"  name="link_instagram" id="link_instagram" >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label text-right">Link youtube:</label>
                                    <div class="col-md-8">
                                        <input type="text"  value="{{ old('link_youtube',$unidadUnidad->link_youtube)}}" class="form-control form-control-sm"  name="link_youtube" id="link_youtube" >
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label text-right">Lugar:</label>
                                    <div class="col-md-8">
                                        <input type="text" value="{{ old('lugar',$unidadUnidad->lugar)}}" class="form-control form-control-sm"  name="lugar" id="lugar" >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label text-right">Direccion:</label>
                                    <div class="col-md-8">
                                        <input type="text" value="{{ old('direccion',$unidadUnidad->direccion)}}" class="form-control form-control-sm"  name="direccion" id="direccion" >
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="row justify-content-center" style="margin-top: 30px;">
                                <h5>Marque en el mapa la Ubicacion de la Unidad</h5>
                            </div><br>
                            <div id="map" class="map"><div id="popup"></div></div>
                            <br>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-3"></div>
                                    <div class="col-md-3">
                                        <label id="latitudVista" class="col-form-label text-right">Latitud: {{$unidadUnidad->latitud}}</label>
                                    </div>
                                    <div class="col-md-3">
                                        <label id="longitudVista" class="col-form-label text-right">Longitud: {{$unidadUnidad->longitud}}</label>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="hidden"  value="{{$unidadUnidad->latitud}}" name="latitud" id="latitud">
                                        <input type="hidden"  value="{{$unidadUnidad->longitud}}"  name="longitud" id="longitud">
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if ($unidadUnidad->und_id == 0)
                            <input type="hidden" value="{{$tipoUnidad->tiu_id}}" name="tiu_id" id="tiu_id">
                        @else
                            <div class="row justify-content-center" style="margin-top: 30px;">
                                <button class="btn btn-primary" type="submit"  >Guardar</button>
                                <a class="btn btn-danger" href="{{ url('sisadmin/unidadunidad/')}}">Cancelar</a>
                                <input type="hidden" value="{{ old('tiu_id',$unidadUnidad->tipoUnidad->tiu_id) }}" name="tiu_id" id="tiu_id">
                            </div>
                        @endif
                    </div>
                    <div class="tab-pane fade" id="panel-dos" role="tabpanel" aria-labelledby="dos-tab">
                        <div class="col-md-12 row">
                            <div class="col-md-4">
                                @if ($unidadUnidad->und_id == 0)
                                    <label class="col-md-12 col-form-label">Nuevo Icono*:</label>
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <input type="file" required class="form-control-file form-control-sm" id="imagen_icono" name="imagen_icono" accept="image/JPG, image/jpg, image/jpeg, image/JPEG, image/png, image/PNG" >
                                            <p style="font-size:12px">  La imagen no puede ser mayor a 350 x 350 pixeles y debe de ser en formato jpg o jpeg menor a 4Mb </p>
                                        </div>
                                    </div><br>
                                @else
                                    {{
                                          Html::image(asset('storage/uploads/'.$unidadUnidad->imagen_icono), 'Sin Imagen', array('id'=>'imagen_icono', 'class' =>'img-thumbnail','width'=>'200'))
                                    }}
                                    <label class="col-md-12 col-form-label">Nueva Imagen icono:</label>
                                    <div class="form-group row">

                                        <div class="col-md-12">
                                            <input type="file" class="form-control-file form-control-sm" id="imagen_icono" name="imagen_icono" accept="image/JPG, image/jpg, image/jpeg, image/JPEG, image/png, image/PNG" >
                                            @error('imagen_icono')
                                            <p class="form-text text-danger">{{ $message }}</p>
                                            @enderror
                                            <p style="font-size:12px">  La imagen no puede ser mayor a 350 x 350 pixeles y debe de ser en formato jpg o jpeg menor a 4Mb </p>
                                        </div>
                                    </div><br>
                                @endif
                            </div>
                            <div class="col-md-4">
                                @if ($unidadUnidad->und_id == 0)
                                    <label class="col-md-12 col-form-label">Nueva direccion:</label>
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <input type="file" class="form-control-file form-control-sm" id="imagen_direccion" name="imagen_direccion" accept="image/JPG, image/jpg, image/jpeg, image/JPEG, image/png, image/PNG" >
                                            @error('imagen_direccion')
                                            <p class="form-text text-danger">{{ $message }}</p>
                                            @enderror
                                            <p style="font-size:12px">  La imagen no puede ser mayor a 600 x 600 pixeles y debe de ser en formato jpg o jpeg menor a 4Mb </p>
                                        </div>
                                    </div><br>
                                @else
                                    {{
                                          Html::image(asset('storage/uploads/'.$unidadUnidad->imagen_direccion), 'Sin Imagen', array('id'=>'imagen_icono', 'class' =>'img-thumbnail','width'=>'260'))
                                    }}
                                    <label class="col-md-12 col-form-label">Nueva Imagen Direccion:</label>
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <input type="file" class="form-control-file form-control-sm" id="imagen_direccion" name="imagen_direccion" accept="image/JPG, image/jpg, image/jpeg, image/JPEG, image/png, image/PNG" >
                                            @error('imagen_direccion')
                                            <p class="form-text text-danger">{{ $message }}</p>
                                            @enderror
                                            <p style="font-size:12px">La imagen no puede ser mayor a 600 x 600 pixeles y debe de ser en formato jpg o jpeg menor a 4Mb </p>
                                        </div>
                                    </div><br>
                                @endif
                            </div>
                            <div class="col-md-4">
                                @if ($unidadUnidad->und_id == 0)
                                    <label class="col-md-12 col-form-label">Nuevo Organigrama*:</label>
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <input type="file" required class="form-control-file form-control-sm" id="organigrama" name="organigrama" accept="image/JPG, image/jpg, image/jpeg, image/JPEG" >
                                            @error('organigrama')
                                            <p class="form-text text-danger">{{ $message }}</p>
                                            @enderror
                                            <p style="font-size:12px">  La imagen debe de ser (800px ancho y mínimo 1200px hasta un máximo de 2000px alto) en formato jpg o jpeg menor a 4Mb </p>
                                        </div>
                                    </div><br>
                                @else
                                    {{
                                          Html::image(asset('storage/uploads/'.$unidadUnidad->organigrama), 'Sin Imagen', array('id'=>'organigrama', 'class' =>'img-thumbnail','width'=>'600'))
                                    }}
                                    <label class="col-md-12 col-form-label">Nueva Imagen Organigrama:</label>
                                    <div class="form-group row">

                                        <div class="col-md-12">
                                            <input type="file" class="form-control-file form-control-sm" id="organigrama" name="organigrama" accept="image/JPG, image/jpg, image/jpeg, image/JPEG" >
                                            @error('organigrama')
                                            <p class="form-text text-danger">{{ $message }}</p>
                                            @enderror
                                            <p style="font-size:12px">  La imagen debe de ser (800px ancho y mínimo 1200px hasta un máximo de 2000px alto) en formato jpg o jpeg menor a 4Mb </p>
                                        </div>
                                    </div><br>
                                @endif
                            </div>
                        </div><br><br>

                        <div class="col-md-12 row">
                            <div class="col-md-6">
                                @if ($unidadUnidad->und_id == 0)
                                @else
                                    <div class="content" id="contenidoLista">
                                        <input type="hidden" value="{{$cantidadimageneshay}}" id="cantidadimageneshay" name="cantidadimageneshay">
                                        <table class="table table-hover table-responsive-xl table-sm" id="tablaContenido">
                                            <thead>
                                            <tr>
                                                <th></th>
                                                <th><center>Imagenes banner de 1740 x 900 px</center></th>
                                                <th width="8%"></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @php
                                                $indice = 1;
                                            @endphp
                                            @foreach ($imagenesBanners as $item)
                                                <tr>
                                                    <td> {{$indice++}}</td>
                                                    <td align="center">
                                                        {{
                                                            Html::image(asset('storage/uploads/'.$item->imagen), 'Sin Imagen', array('id'=>'imagen_icono', 'class' =>'img-thumbnail','width'=>'500'))
                                                        }}
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-danger btn-sm" onclick="eliminarImagenBanner('{{$item->imu_id}}','{{$item->unidad->und_id}}');"><i class="fa fa-trash"></i> </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table><br>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <label class="col-md-12 col-form-label">Imagenes Banner:</label>
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <input type="file" class="form-control-file form-control-sm" id="imagen_banner" name="imagen_banner[]" accept="image/JPG, image/jpg, image/jpeg, image/JPEG, image/png, image/PNG" multiple="multiple"  >
                                        @error('imagen_banner')
                                        <p class="form-text text-danger">{{ $message }}</p>
                                        @enderror
                                        @error('imagen_banner.max')
                                        <p class="form-text text-danger">{{ $message }}</p>
                                        @enderror
                                        <p style="font-size:12px">La imagen no puede ser mayor a 1740 x 900 pixeles y debe de ser en formato jpg o jpeg menor a 4Mb </p>
                                    </div>
                                </div>
                                @if ($unidadUnidad->und_id == 0)
                                    <div class="row justify-content-center" style="margin-top: 50px;">
                                        <button   class="btn btn-primary" type="submit">Guardar</button>
                                        <a class="btn btn-danger" href="{{ url('sisadmin/unidadunidad/')}}">Cancelar</a>
                                    </div>
                                @else
                                    <div class="row justify-content-center" style="margin-top: 50px;">
                                        <button   class="btn btn-primary" type="submit">Guardar</button>
                                        <a class="btn btn-danger" href="{{ url('sisadmin/unidadunidad/')}}">Cancelar</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
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

        var latitud = {{$unidadUnidad->latitud}};
        var longitud = {{$unidadUnidad->longitud}};
        var zoom = {{$zoom ?? 18}};

        $(document).ready(function(){
            validarInputEntero("#celular_wp");
            $('#myTab a[href="#panel-uno"]').tab('show');
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

        function eliminarImagenBanner(imu_id,und_id){

            var cantIma =  $("#cantidadimageneshay").val();
            if(cantIma>=2) {
                loaderR.showPleaseWait();
                $.ajax({
                    url: '{{url("sisadmin/unidadunidad/_eliminarimagen_unidad")}}',
                    data: {
                        imu_id: imu_id,
                        und_id: und_id
                    },
                    type: 'POST',
                    success: function (resp) {
                        loaderR.hidePleaseWait();
                        console.log(resp);
                        $("#contenidoLista").html(resp);
                        toastr.success('Operación completada','');
                    },
                    error: function (xhr, status) {
                        loaderR.hidePleaseWait();
                        toastr.warning('No se pudo eliminar la imagen producto','');
                    },
                    complete: function (xhr, status) {

                    }
                });
            }else{
                toastr.warning('Como minimo debe de tener 2 imagenes para borrar 1 de las imagenes','');
            }
        }

    </script>
@endsection
