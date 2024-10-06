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
            <li class="breadcrumb-item active" aria-current="page">Mi unidad</li>
            <li class="breadcrumb-item active" aria-current="page">Producto</li>
        </ol>
    </nav>
    <!-- Breadcrumb Area End-->
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if ( $producto->pro_id == 0)
                <h3 align="center">Nuevo Producto</h3>
            @else
                <h3 align="center">Editar Producto</h3>
            @endif
            <br>
            <form class="form-horizontal" id="formulario" autocomplete="off" method="POST" enctype="multipart/form-data" action="{{ url('sisadmin/producto/store') }}">
                {{ csrf_field() }}
                <div class="form-group row">
                    {{Form::hidden('pro_id',$producto->pro_id)}}
                    <input type="hidden" value="{{$und_id}}" name="und_id" id="und_id" >
                    <label class="col-md-3 col-form-label text-right" >Nombre*:</label>
                    <div class="col-md-7">
                        <textarea rows="3" cols="30" type="text"  class="form-control form-control-sm" name="nombre" id="nombre" required >{{ old('nombre',$producto->nombre) }}</textarea>
                        @error('nombre')
                        <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label text-right" >Descripcion*:</label>
                    <div class="col-md-7">
                        <textarea rows="4" cols="40" type="text"  class="form-control form-control-sm" name="descripcion" id="descripcion" >{{ old('descripcion',$producto->descripcion) }}</textarea>
                        @error('descripcion')
                        <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label text-right">Imagenes @if($producto->pro_id == 0) * @endif :</label>
                    <div class="col-md-7">
                        <input type="file" multiple class="form-control-file form-control-sm" id="imagenes" name="imagenes[]" accept="image/jpeg,image/jpg,image/JPEG,image/JPG" @if($producto->pro_id == 0) required @endif >
                        @error('imagenes')
                        <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                        <p style="font-size:12px">  Las imagenes no puede ser mayor a 600 x 600 pixeles y debe de ser en formato jpeg o png y menor de 4Mb</p>
                    </div>
                </div>
                @if($producto->pro_id > 0)
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
                                        $imagenes = $producto->productoImagenes->filter(function ($value, $key) {
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
                                                        <button type="button" onclick="quitarImagen('{{$imagen->pri_id}}')" class="btn btn-sm btn-danger">Quitar</button>
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
                        <a href="{{ url('sisadmin/producto/'.$und_id.'/lista') }}" class="btn btn-danger btn-sm">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('footer_scripts')
    <script src="{{asset('js/tinymce.min.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#formulario").submit(function (){
                loaderR.showPleaseWait();
            });
            tinymce.init({
                selector: '#descripcion',
                language: 'es',
                theme: 'modern',
                width: 550,
                height: 200,
                plugins: [
                    'advlist code lists charmap preview hr searchreplace wordcount visualblocks visualchars fullscreen',
                    'insertdatetime nonbreaking table contextmenu directionality paste link'
                ],
                //toolbar: ['fontselect fontsizeselect formatselect'],
                toolbar: 'fontselect fontsizeselect formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat',
            });
        });
        function quitarImagen(pri_id){
            console.log(pri_id);
            loaderR.showPleaseWait();
            $.ajax({
                url : '{{url("sisadmin/producto/_quitarImagen")}}',
                data : {
                    pri_id:pri_id
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
