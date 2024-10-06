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
            <li class="breadcrumb-item active" aria-current="page">Mi Unidad</li>
            <li class="breadcrumb-item active" aria-current="page">Proyecto</li>
        </ol>
    </nav>
    <!-- Breadcrumb Area End-->
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if ( $proyecto->pro_id == 0)
                <h3 align="center">Nuevo Proyecto</h3>
            @else
                <h3 align="center">Editar Proyecto</h3>
            @endif
            <br>
            <form class="form-horizontal" id="formulario" autocomplete="off" method="POST" enctype="multipart/form-data" action="{{ url('sisadmin/proyecto/store') }}">
                {{ csrf_field() }}
            <div class="col-md-12 row">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label text-right" >Nombre*:</label>
                        <div class="col-md-9">
                             {{Form::hidden('pro_id',$proyecto->pro_id)}}
                            <input type="hidden" value="{{$und_id}}" name="und_id" id="und_id" >
                            <textarea rows="4" cols="40" class="form-control form-control-sm" name="nombre" id="nombre"  required>{{ old('nombre',$proyecto->nombre)}}</textarea>
                            @error('nombre')
                            <p class="form-text text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label text-right" >Descripcion*:</label>
                        <div class="col-md-9">
                            <textarea rows="4" cols="40" class="form-control form-control-sm" name="descripcion" id="descripcion"  required>{{ old('descripcion',$proyecto->descripcion)}}</textarea>
                            @error('descripcion')
                            <p class="form-text text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label text-right" >Inversion*:</label>
                        <div class="col-md-5">
                            <input type="text" value="{{ old('inversion',$proyecto->inversion) }}" class="form-control form-control-sm"  name="inversion" id="inversion" required>
                            @error('inversion')
                            <p class="form-text text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-md-3 col-form-label text-right" >Financiamiento*:</label>
                        <div class="col-md-9">
                            <input type="text" value="{{ old('fuente_financiamiento',$proyecto->fuente_financiamiento) }}" class="form-control form-control-sm"  name="fuente_financiamiento" id="fuente_financiamiento" required>
                            @error('fuente_financiamiento')
                            <p class="form-text text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label text-right" >Estado Proyecto*:</label>
                        <div class="col-md-9">
                            <input type="text" value="{{ old('estado_proyecto',$proyecto->estado_proyecto) }}" class="form-control form-control-sm"  name="estado_proyecto" id="estado_proyecto" required>
                            @error('estado_proyecto')
                            <p class="form-text text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label text-right" >Ejecucion Fisica*:</label>
                        <div class="col-md-5">
                            <input type="text" value="{{ old('ejecucion_fisica',$proyecto->ejecucion_fisica) }}" class="form-control form-control-sm"  name="ejecucion_fisica" id="ejecucion_fisica" required>
                            @error('ejecucion_fisica')
                            <p class="form-text text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label text-right">Imagenes @if($proyecto->pro_id == 0) * @endif :</label>
                        <div class="col-md-5">
                            <input type="file" multiple class="form-control-file form-control-sm" id="imagenes" name="imagenes[]" accept="image/jpeg,image/jpg,image/JPEG,image/JPG" @if($proyecto->pro_id == 0) required @endif >
                            @error('imagenes')
                            <p class="form-text text-danger">{{ $message }}</p>
                            @enderror
                            <p style="font-size:12px">  Las imagenes no puede ser mayor a 600 x 600 pixeles y debe de ser en formato jpeg o png y menor de 4Mb</p>
                        </div>
                    </div>
                    @if($proyecto->pro_id > 0)
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-md-10">
                                    <table class="table table-sm table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th width="10%">N°</th>
                                            <th width="70%" align="center">Imagen</th>
                                            <th width="20%">Acciones</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php
                                            $imagenes = $proyecto->proyectoImagenes->filter(function ($value, $key) {
                                                return $value->estado == 'AC';
                                            });
                                        @endphp
                                        @if(count($imagenes) > 0)
                                            @foreach($imagenes as $key=>$imagen)
                                                <tr>
                                                    <td>{{$key+1}}</td>
                                                    <td align="center">
                                                        {{
                                                          Html::image(asset('storage/uploads/'.$imagen->imagen), 'Sin Imagen', array('id'=>'imagen', 'class' =>'img-thumbnail','width'=>'90'))
                                                        }}
                                                    </td>
                                                    <td>
                                                        @if(count($imagenes) == 1)
                                                            No se puede quitar esta imagen, debe existir minimo una imagen.
                                                        @else
                                                            <button type="button" onclick="quitarImagen('{{$imagen->poi_id}}')" class="btn btn-sm btn-danger">Quitar</button>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="3" class="text-center">Sin Imagenes</td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
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
                        <a href="{{ url('sisadmin/proyecto/'.$und_id.'/lista') }}" class="btn btn-danger btn-sm">Cancelar</a>
                    </div>
            </div>
          </form>
      </div>
    </div>
@endsection

@section('footer_scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            validarInputDecimal("#inversion",2);
            validarInputDecimal("#ejecucion_fisica",2);
            $("#formulario").submit(function (){
                loaderR.showPleaseWait();
            });
        });
        function quitarImagen(poi_id){
            console.log(poi_id);
            loaderR.showPleaseWait();
            $.ajax({
                url : '{{url("sisadmin/proyecto/_quitarImagen")}}',
                data : {
                    poi_id:poi_id
                },
                type : 'POST',
                success : function(resp) {
                    console.log(resp);
                    if(resp.res == true){
                        toastr.success('Operación completada','');
                        location.reload(true);
                    }else{
                        toastr.error(resp.mensaje,'');
                    }
                },
                error : function(xhr, status) {
                    toastr.error('Ocurrio un error en la operación','');
                },
                complete : function(xhr, status) {
                    loaderR.hidePleaseWait();
                }
            });
        }
    </script>
@endsection
