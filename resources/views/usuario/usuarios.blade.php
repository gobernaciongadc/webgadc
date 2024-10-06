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
            <li class="breadcrumb-item active" aria-current="page">Administración / Usuarios</li>
        </ol>
    </nav>
    <!-- Breadcrumb Area End-->
    <h3 align="center">Usuarios</h3>
    <div class="col-md-12">
        <form class="col-md-12" action="{{url('sisadmin/usuario/usuarios')}}" method="get">
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
        </form>
        <div class="col-md-12">
            <div class="row">
                @if (verificarAcceso(148))
                    <a href="{{ url('sisadmin/usuario/create') }}" class="btn btn-primary btn-sm" id="btnNuevo"><i class="fa fa-plus"></i> Agregar</a>
                @else
                    <a href="#" class="btn btn-primary btn-sm disabled" id="btnNuevo"><i class="fa fa-plus"></i> Agregar</a>
                @endif
            </div>
            <div class="content" id="contenidoLista">
                <table class="table table-hover table-responsive-xl table-sm" id="tablaContenido">
                    <thead>
                    <tr>
                        <th>N°</th>
                        <th>Unidad</th>
                        <th>Nombre Completo</th>
                        <th>Login</th>
                        <th>Estado</th>
                        <th width="20%">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($usuarios as $key => $usuario)
                        <tr>
                            <td>{{$usuarios->firstItem() + $key}}</td>
                            <td>{{$usuario->unidad->nombre}}</td>
                            <td>{{$usuario->name}}</td>
                            <td>{{$usuario->email}}</td>
                            <td>
                                @php
                                    $estado = 'Inhabilitado';
                                    if($usuario->estado == 'AC'){
                                        $estado = 'Habilitado';
                                    }
                                @endphp
                                {{$estado}}
                            </td>
                            <td>
                                @if (verificarAcceso(149))
                                    <a href="{{ url('sisadmin/usuario/edit/'.$usuario->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Editar</a>
                                @else
                                    <a href="#" class="btn btn-primary btn-sm disabled"><i class="fa fa-edit"></i> Editar</a>
                                @endif
                                @if (verificarAcceso(150))
                                    <a href="{{ url('sisadmin/usuario/editContrasenia/'.$usuario->id) }}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> Cambiar Contraseña</a>
                                @else
                                    <a href="#" class="btn btn-warning btn-sm disabled"><i class="fa fa-edit"></i> Cambiar Contraseña</a>
                                @endif
                                @if (verificarAcceso(152))
                                    @if($usuario->estado == 'AC')
                                        <button type="button" class="btn btn-danger btn-sm" onclick="cambiarEstado('{{$usuario->id}}','EL')"><i class="fa fa-trash"></i> Inhabilitar</button>
                                    @else
                                        <button type="button" class="btn btn-success btn-sm" onclick="cambiarEstado('{{$usuario->id}}','AC')"><i class="fa fa-check-circle"></i> Habilitar</button>
                                    @endif
                                @else
                                    @if($usuario->estado == 'AC')
                                        <button type="button" class="btn btn-danger btn-sm disabled"><i class="fa fa-trash"></i> Inhabilitar</button>
                                    @else
                                        <button type="button" class="btn btn-success btn-sm disabled"><i class="fa fa-check-circle"></i> Habilitar</button>
                                    @endif
                                @endif
                                @if (verificarAcceso(151))
                                    <a href="{{ url('sisadmin/usuario/roles/'.$usuario->id) }}" class="btn btn-success btn-sm"><i class="fa fa-user"></i> Roles</a>
                                @else
                                    <a href="#" class="btn btn-success btn-sm disabled"><i class="fa fa-user"></i> Roles</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    {{ $usuarios->appends(['searchtype'=>$searchtype,'search'=>$search,'sort'=>$sort])->links() }}
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
            var literal = estado == 'EL'?'Inhabilitar':'Habilitar';
            $.confirm({
                theme: 'modern',
                title: false,
                content: '¿Desea '+literal+' este usuario?',
                buttons: {
                    SI: {
                        text: 'SI',
                        btnClass: 'btn-blue',
                        keys: ['enter'],
                        action: function(){
                            loaderR.showPleaseWait();
                            $.ajax({
                                url : '{{url("sisadmin/usuario/_cambiarEstado")}}',
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
                                    toastr.error('Ocurrio un error al modificar el usuario','');
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


    </script>
@endsection
