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
            <li class="breadcrumb-item active" aria-current="page">Servicio Publico</li>
        </ol>
    </nav>
    <!-- Breadcrumb Area End-->
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if ( $servicioPublico->sep_id == 0)
                <h3 align="center">Nuevo Servicio Publico</h3>
            @else
                <h3 align="center">Editar Servicio Publico</h3>
            @endif
            <br>
            <form class="form-horizontal" id="formulario" autocomplete="off" method="POST" enctype="multipart/form-data" action="{{ url('sisadmin/serviciopublico/store') }}">
                {{ csrf_field() }}
                <div class="form-group row">
                    {{Form::hidden('sep_id',$servicioPublico->sep_id)}}
                    <input type="hidden" value="{{$und_id}}" name="und_id" id="und_id" >
                    <label class="col-md-3 col-form-label text-right" >Nombre*:</label>
                    <div class="col-md-8">
                        <input type="text" value="{{ old('nombre',$servicioPublico->nombre) }}" class="form-control form-control-sm"  name="nombre" id="nombre" required>
                        @error('nombre')
                        <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label text-right" >Descripcion*:</label>
                    <div class="col-md-8">
                        <textarea rows="2" cols="40" type="text"  class="form-control form-control-sm" name="descripcion" id="descripcion" required >{{ old('descripcion',$servicioPublico->descripcion) }}</textarea>
                        @error('descripcion')
                        <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label text-right" >Horario atencion*:</label>
                    <div class="col-md-8">
                        <textarea rows="2" cols="40" type="text"  class="form-control form-control-sm" name="horario_atencion" id="horario_atencion" required >{{ old('horario_atencion',$servicioPublico->horario_atencion) }}</textarea>
                        @error('horario_atencion')
                        <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label text-right" >Costo Base:</label>
                    <div class="col-md-4">
                        <input type="text" value="{{ old('costo_base',$servicioPublico->costo_base) }}" class="form-control form-control-sm"  name="costo_base" id="costo_base" required>
                        @error('costo_base')
                        <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label text-right">Ubicacion*:</label>
                    <div class="col-md-8">
                        {{
                             Form::select('ubi_id',$listaUbicaciones, $servicioPublico->ubi_id,  ['class' => 'form-control form-control-sm','id' => 'ubi_id','style' => 'width:100%;' ,'name'=>'ubi_id','require'=>'require'])
                        }}
                    </div>
                    @error('ubi_id')
                    <p class="form-text text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label text-right">Imagenes @if($servicioPublico->sep_id == 0) * @endif :</label>
                    <div class="col-md-7">
                        <input type="file" multiple class="form-control-file form-control-sm" id="imagenes" name="imagenes[]" accept="image/jpeg,image/jpg,image/JPEG,image/JPG" @if($servicioPublico->sep_id == 0) required @endif >
                        @error('imagenes')
                        <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                        <p style="font-size:12px">  Las imagenes no puede ser mayor a 600 x 600 pixeles y debe de ser en formato jpeg o png y menor de 4Mb</p>
                    </div>
                </div>
                @if($servicioPublico->sep_id > 0)
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
                                        $imagenes = $servicioPublico->servicioImagenes->filter(function ($value, $key) {
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
                                                        <button type="button" onclick="quitarImagen('{{$imagen->sei_id}}')" class="btn btn-sm btn-danger">Quitar</button>
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

                <div class="row justify-content-center" style="margin-top: 10px;">
                    <div class="col-md-2">
                        <button id="btn_guardar" class="btn btn-primary btn-sm" type="submit" id="btnGuardar">Guardar</button>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ url('sisadmin/serviciopublico/'.$und_id.'/lista') }}" class="btn btn-danger btn-sm">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('footer_scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            validarInputDecimal("#costo_base",2);
            $("#formulario").submit(function (){
                loaderR.showPleaseWait();
            });
        });
        function quitarImagen(sei_id){
            console.log(sei_id);
            loaderR.showPleaseWait();
            $.ajax({
                url : '{{url("sisadmin/serviciopublico/_quitarImagen")}}',
                data : {
                    sei_id:sei_id
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
