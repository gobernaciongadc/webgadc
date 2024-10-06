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
            <li class="breadcrumb-item active" aria-current="page">Mi Unidad / Estadisticas</li>
        </ol>
    </nav>
    <!-- Breadcrumb Area End-->
    <h3 align="center">Estadísticas: {{$unidad->nombre}}</h3>
    <div class="col-md-12">
        {{--<form class="col-md-12" action="{{url('sisadmin/usuario/usuarios')}}" method="get">
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-1">
                    <label for="search">Buscar por:</label>
                </div>
                <div class="col-md-2">
                    {{
                        Form::select('searchtype',[1=>'Nombre',2=>'Correo'],$searchtype,  ['class' => 'form-control form-control-sm','id' => 'searchtype'])
                    }}
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control form-control-sm" placeholder="Ingrese su busqueda" id="search" name="search" value="{{$search}}">
                </div>
                <div class="col-md-1">
                    <label>Ordenar por:</label>
                </div>
                <div class="col-md-2">
                    {{
                        Form::select('sort',[1=>'Nombre'],$sort,  ['class' => 'form-control form-control-sm','id' => 'sort'])
                    }}
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-search"></i> Buscar</button>
                </div>

            </div>
        </form>--}}
        <div class="col-md-12">
            <div class="row">
                @if (verificarAcceso(24))
                    <a href="{{ url('sisadmin/estadistica/create/'.$unidad->und_id) }}" class="btn btn-primary btn-sm" id="btnNuevo"><i class="fa fa-plus"></i> Agregar</a>
                @else
                    <a href="#" class="btn btn-primary btn-sm disabled" id="btnNuevo"><i class="fa fa-plus"></i> Agregar</a>
                @endif
            </div>
            <div class="content" id="contenidoLista">
                <table class="table table-hover table-responsive-xl table-sm" id="tablaContenido">
                    <thead>
                    <tr>
                        <th>N°</th>
                        <th>Creado por</th>
                        <th>Título</th>
                        {{--<th>Descripción</th>--}}
                        <th>Imagen</th>
                        <th>Archivo</th>
                        <th>Fecha</th>
                        <th>Publicar</th>
                        <th width="20%">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($lista as $key => $item)
                        <tr>
                            <td>{{$lista->firstItem() + $key}}</td>
                            <td>{{$item->usuario->name}}</td>
                            <td>{{$item->titulo}}</td>
                            {{--<td>{{$item->descripcion}}</td>--}}
                            <td>
                                {{
                                    Html::image(asset('storage/uploads/'.$item->imagen), 'Sin Imagen', array('id'=>'imagen', 'class' =>'img-thumbnail','width'=>'90'))
                                }}
                            </td>
                            <td>
                                <a target="_blank" href="{{asset('storage/uploads/'.$item->archivo)}}"><i class="fa fa-download"></i> Descargar Archivo</a>
                            </td>
                            <td>{{date('d/m/Y',strtotime($item->fecha))}}</td>
                            <td>
                                @if (verificarAcceso(26))
                                    {{
                                        Form::select('publicar',$publicar,$item->publicar,['class'=>'form-control form-control-sm','id'=>'publicar','onchange'=>"cambiarPublicar('$item->est_id',this.value);"])
                                    }}
                                @else
                                    {{$publicar[$item->publicar]}}
                                @endif
                            </td>
                            <td>
                                @if (verificarAcceso(25))
                                    <a href="{{ url('sisadmin/estadistica/edit/'.$item->est_id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Editar</a>
                                @else
                                    <a href="#" class="btn btn-primary btn-sm disabled"><i class="fa fa-edit"></i> Editar</a>
                                @endif
                                @if (verificarAcceso(27))
                                    <button type="button" class="btn btn-danger btn-sm" onclick="cambiarEstado('{{$item->est_id}}','EL')"><i class="fa fa-trash"></i> Eliminar</button>
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

@endsection

@section('footer_scripts')
    <script type="text/javascript">

        $(document).ready(function(){

        });

        function cambiarEstado(id,estado){
            $.confirm({
                theme: 'modern',
                title: false,
                content: '¿Desea eliminar esta estadística?',
                buttons: {
                    SI: {
                        text: 'SI',
                        btnClass: 'btn-blue',
                        keys: ['enter'],
                        action: function(){
                            loaderR.showPleaseWait();
                            $.ajax({
                                url : '{{url("sisadmin/estadistica/_cambiarEstado")}}',
                                data : {
                                    id:id,
                                    estado:estado
                                },
                                type : 'POST',
                                success : function(resp) {
                                    console.log(resp);
                                    if(resp.res == true){
                                        toastr.success(resp.mensaje,'');
                                        location.reload(true);
                                    }else{
                                        toastr.error(resp.mensaje,'');
                                    }
                                },
                                error : function(xhr, status) {
                                    toastr.error('Ocurrio un error al modificar el dato','');
                                },
                                complete : function(xhr, status) {
                                    loaderR.hidePleaseWait();
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

        function cambiarPublicar(est_id,publicar){
            console.log(est_id+' '+publicar);
            loaderR.showPleaseWait();
            $.ajax({
                url : '{{url("sisadmin/estadistica/_cambiarPublicar")}}',
                data : {
                    est_id:est_id,
                    publicar:publicar
                },
                type : 'POST',
                success : function(resp) {
                    console.log(resp);
                    if (resp.res == true){
                        toastr.success(resp.mensaje,'');
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
