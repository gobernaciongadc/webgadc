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
        <h3 align="center">Lista de Proyectos: {{$unidad->nombre}}</h3>
        <div class="col-md-12">
            <div class="col-md-12">
                    @if (verificarAcceso(154))
                        <a href="{{ url('sisadmin/proyecto/create/'.$und_id) }}" class="btn btn-primary btn-sm" id="btnNuevo"><i class="fa fa-plus"></i> Agregar</a>
                    @else
                        <a href="#" class="btn btn-primary btn-sm disabled"><i class="fa fa-plus"></i> Agregar</a>
                    @endif
                <br>

                <div class="content" id="contenidoLista">
                    <table class="table table-hover table-responsive-xl table-sm" id="tablaContenido">
                        <thead>
                        <tr>
                            <th>N° </th>
                            <th width="12%">Nombre</th>
                            <th>Descripcion</th>
                            <th>Fuente Financiamiento</th>
                            <th>Ejecucion Fisica</th>
                            <th>Estado Proyecto</th>
                            <th width="10%">Imagen</th>
                            <th>Publicar</th>
                            <th width="15%">Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $indice = 1;
                        @endphp
                        @foreach ($lista as $key => $item)
                            <tr>
                                <td>{{$lista->firstItem() + $key}}</td>
                                <td>
                                    {{$item->nombre}}
                                </td>
                                <td>
                                    {{$item->descripcion}}
                                </td>
                                <td>
                                    {{$item->fuente_financiamiento}}
                                </td>
                                <td>
                                    {{$item->ejecucion_fisica}}
                                </td>
                                <td>
                                    {{$item->estado_proyecto}}
                                </td>
                                <td>
                                    @php
                                        $imagen = $item->proyectoImagenes->first(function ($value, $key) {
                                            return $value->estado == 'AC';
                                        });
                                    @endphp
                                    @if(!empty($imagen))
                                        {{
                                            Html::image(asset('storage/uploads/'.$imagen->imagen), 'Sin Imagen', array('id'=>'imagen', 'class' =>'img-thumbnail','width'=>'90'))
                                        }}
                                    @endif
                                </td>
                                <td>
                                    @if (verificarAcceso(156))
                                        {{
                                            Form::select('publicar',$publicar,$item->publicar,['class'=>'form-control form-control-sm','id'=>'publicar','onchange'=>"cambiarPublicar('$item->pro_id',this.value);"])
                                        }}
                                     @else
                                          {{$publicar[$item->publicar]}}
                                     @endif
                                </td>

                                <td>
                                    @if (verificarAcceso(155))
                                        <a href="{{ url('sisadmin/proyecto/edit/'.$item->pro_id.'/'.$und_id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Editar</a>
                                    @else
                                        <a href="#" class="btn btn-primary btn-sm disabled"><i class="fa fa-edit"></i> Editar</a>
                                    @endif
                                    @if (verificarAcceso(157))
                                        <button type="button" class="btn btn-danger btn-sm" onclick="modificarEstado('{{$item->pro_id}}','{{$item->nombre}}');"><i class="fa fa-trash"></i> Eliminar</button>
                                    @else
                                        <button type="button" class="btn btn-danger btn-sm disabled"><i class="fa fa-trash"></i> Eliminar</button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center">
                        {{ $lista->appends(['searchtype'=>$searchtype,'search'=>$search,'sort'=>$sort])->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer_scripts')
    <script type="text/javascript">

        function cambiarPublicar(pro_id,publicar){
            console.log(pro_id+' '+publicar);
            loaderR.showPleaseWait();
            $.ajax({
                url : '{{url("sisadmin/proyecto/_cambiarPublicar")}}',
                data : {
                    pro_id:pro_id,
                    publicar:publicar
                },
                type : 'POST',
                success : function(resp) {
                    console.log(resp);

                },
                error : function(xhr, status) {
                    toastr.error('Ocurrio un error en la operación','');
                },
                complete : function(xhr, status) {
                    loaderR.hidePleaseWait();
                }
            });
        }



        function modificarEstado(pro_id,nombre)
        {
            var mensajeConsulta = '¿Desea elimnar el proyecto de :<br> '+nombre+'?';
            $.confirm({
                theme: 'modern',
                title: false,
                content: mensajeConsulta,
                buttons: {
                    SI: {
                        text: 'SI',
                        btnClass: 'btn-blue',
                        keys: ['enter'],
                        action: function(){
                            $.ajax({
                                url : '{{url("sisadmin/proyecto/_modificarEstado")}}',
                                data : {
                                    pro_id:pro_id
                                },
                                type : 'POST',
                                success : function(resp) {
                                    console.log(resp);
                                    if(resp.res == true){
                                        toastr.success('Operación completada','');
                                        location.reload(true);
                                    }else{
                                        toastr.error('Ocurrio un error al eliminar el proyecto : '+nombre+'','');
                                    }
                                },
                                error : function(xhr, status) {
                                    toastr.error('Ocurrio un error al eliminar el proyecto : '+nombre+'','');
                                },
                                complete : function(xhr, status) {
                                }
                            });
                        }
                    },
                    NO: {
                        text: 'NO',
                        btnClass: 'btn-red',
                        action: function(){
                            //location.reload(true);
                        }
                    }
                }
            });
        }

    </script>
@endsection
