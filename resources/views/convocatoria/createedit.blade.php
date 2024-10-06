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
            <li class="breadcrumb-item active" aria-current="page">Convocatoria</li>

        </ol>
    </nav>
    <!-- Breadcrumb Area End-->
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if ( $convocatoria->con_id == 0)
                <h3 align="center">Nuevo Convocatoria</h3>
            @else
                <h3 align="center">Editar Convocatoria</h3>
            @endif
            <br>
            <form class="form-horizontal" id="formulario" autocomplete="off" method="POST" enctype="multipart/form-data" action="{{ url('sisadmin/convocatoria/store') }}">
                {{ csrf_field() }}
            <div class="col-md-12 row ">
                <div class="col-md-7">
                        <div class="form-group row">
                            {{Form::hidden('con_id',$convocatoria->con_id)}}
                            <input type="hidden" value="{{$und_id}}" name="und_id" id="und_id" >
                            <label class="col-md-3 col-form-label text-right">Titulo*:</label>
                            <div class="col-md-9">
                                <textarea rows="3" cols="30" type="text"  class="form-control form-control-sm" name="titulo" id="titulo" required >{{ old('titulo',$convocatoria->titulo) }}</textarea>
                                @error('titulo')
                                <p class="form-text text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right" >Resumen*:</label>
                            <div class="col-md-9">
                                <textarea rows="3" cols="30" type="text"  class="form-control form-control-sm" name="resumen" id="resumen" required >{{ old('resumen',$convocatoria->resumen) }}</textarea>
                                @error('resumen')
                                <p class="form-text text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right" >Contenido*:</label>
                            <div class="col-md-9">
                                <textarea rows="3" cols="30" type="text"  class="form-control form-control-sm" name="contenido" id="contenido">{{ old('contenido',$convocatoria->contenido) }}</textarea>
                                @error('contenido')
                                <p class="form-text text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right" >Convocante*:</label>
                            <div class="col-md-9">
                                <textarea rows="2" cols="20" type="text" class="form-control form-control-sm" name="convocante" id="convocante" required>{{ old('convocante',$convocatoria->convocante) }}</textarea>
                                @error('convocante')
                                <p class="form-text text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        @if ( $convocatoria->con_id == 0)
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label text-right">Fecha*:</label>
                                <div class="col-md-4">
                                    <input type="text"   value="{{date('d/m/Y')}}"  class="form-control form-control-sm"  name="fecha_publicacion" id="fecha_publicacion" onkeypress="return false;" required="required">
                                </div>
                            </div>
                        @else
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label text-right">Fecha*:</label>
                                <div class="col-md-4">
                                    <input type="text"   value="{{ old('fecha_publicacion',date('d/m/Y',strtotime($convocatoria->fecha_publicacion))) }}" class="form-control form-control-sm"  name="fecha_publicacion" id="fecha_publicacion" onkeypress="return false;" required="required">
                                </div>
                            </div>
                        @endif<br>
                    </div>
                    <div class="col-md-5">
                        @if ( $convocatoria->con_id  == 0)
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label text-right">Archivo*:</label>
                                <div class="col-md-8">
                                    <input type="file" class="form-control-file form-control-sm" id="archivo" name="archivo" accept="application/msword, application/vnd.ms-excel,.xlsx, application/pdf" required >
                                    @error('archivo')
                                    <p class="form-text text-danger">{{ $message }}</p>
                                    @enderror
                                    <p style="font-size:12px">  El archivo debe de ser en formato pdf,word o excel y menor de 4MB</p>
                                </div>
                            </div>
                        @else
                            <br>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-right">Archivo Actual:</label>
                                <div class="col-md-8">
                                    <a target="_blank" href="{{asset('storage/uploads/'.$convocatoria->archivo)}}"><i class="fa fa-download"></i> Descargar Archivo</a>
                                </div>
                            </div>
                            <br><br>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-right">Nuevo Archivo:</label>
                                <div class="col-md-8">
                                    <input type="file" class="form-control-file form-control-sm" id="archivo" name="archivo" accept="application/msword, application/vnd.ms-excel,.xlsx, application/pdf" >
                                    @error('archivo')
                                    <p class="form-text text-danger">{{ $message }}</p>
                                    @enderror
                                    <p style="font-size:12px">  El archivo debe de ser en formato pdf,word o excel y menor de 4MB</p>
                                </div>
                            </div>
                        @endif
                        @if ( $convocatoria->con_id  == 0)
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-right">Nueva Imagen*:</label>
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
                                <label class="col-md-4 col-form-label text-right">Imagen:</label>
                                <div class="col-md-8">
                                    {{
                                        Html::image(asset('storage/uploads/'.$convocatoria->imagen), 'Sin imagen', array('id'=>'imagen', 'class' =>'img-thumbnail','width'=>'200'))
                                    }}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-right">Nueva Imagen:</label>
                                <div class="col-md-8">
                                    <input type="file" class="form-control-file form-control-sm" id="imagen" name="imagen" accept="image/jpeg, image/jpg, image/JPEG, image/JPG" >
                                    <p style="font-size:12px">  La nueva imagen no puede ser mayor a 600 x 600 pixeles y debe de ser en formato jpeg o png y menor de 4Mb </p>
                                    @error('imagen')
                                    <p class="form-text text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        @endif
                    </div>
                        <div class="col-md-12 row">
                          <div class="col-md-5"></div>
                            <div class="col-md-2">
                                <button id="btn_guardar" class="btn btn-primary btn-sm" type="submit" id="btnGuardar">Guardar</button>
                            </div>
                            <div class="col-md-2">
                                <a href="{{ url('sisadmin/convocatoria/'.$und_id.'/lista') }}" class="btn btn-danger btn-sm">Cancelar</a>
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
            asignarDatepicker("#fecha_publicacion");
            $("#formulario").submit(function (){
                loaderR.showPleaseWait();
            });

            tinymce.init({
                selector: '#contenido',
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
    </script>
@endsection
