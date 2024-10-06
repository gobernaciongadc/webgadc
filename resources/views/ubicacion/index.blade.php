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
            <li class="breadcrumb-item active" aria-current="page">Tipologias</li>
            <li class="breadcrumb-item active" aria-current="page">Ubicacion</li>
        </ol>
    </nav>
    <!-- Breadcrumb Area End-->
    <div class="row justify-content-center">
        <h3 align="center">Lista de Ubicaciones</h3>
        <div class="col-md-12">
            <div class="col-md-12">
                @if (verificarAcceso(140))
                    <a href="{{ url('sisadmin/ubicacion/create/') }}" class="btn btn-primary btn-sm" id="btnNuevo"><i class="fa fa-plus"></i> Agregar</a>
                @else
                    <a href="#" class="btn btn-primary btn-sm disabled" id="btnNuevo"><i class="fa fa-plus"></i> Agregar</a>
                @endif
                <br>
                <div class="content" id="contenidoLista">
                    <table class="table table-hover table-responsive-xl table-sm" id="tablaContenido">
                        <thead>
                        <tr>
                            <th>N° </th>
                            <th>Unidad</th>
                            <th>Lugar</th>
                            <th>Direccion</th>
                            <th width="12%">Imagen</th>
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
                                    {{$item->unidad}}
                                </td>
                                <td>
                                    {{$item->lugar}}
                                </td>
                                <td>
                                    {{$item->direccion}}
                                </td>
                                <td>
                                    {{
                                      Html::image(asset('storage/uploads/'.$item->imagen), 'Sin Imagen', array('id'=>'imagen', 'class' =>'img-thumbnail','width'=>'90'))
                                    }}
                                </td>
                                <td>
                                    @if (verificarAcceso(141))
                                        <a href="{{ url('sisadmin/ubicacion/edit/'.$item->ubi_id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Editar</a>
                                    @else
                                        <a href="#" class="btn btn-primary btn-sm disabled"><i class="fa fa-edit"></i> Editar</a>
                                    @endif
                                    @if (verificarAcceso(142))
                                        <button type="button" class="btn btn-danger btn-sm" onclick="modificarEstado('{{$item->ubi_id}}','{{$item->unidad}}');"><i class="fa fa-trash"></i> Eliminar</button>
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
        function modificarEstado(ubi_id,nombre)
        {
            var mensajeConsulta = '¿Desea la eliminar la Ubicacion : '+nombre+' ?';
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
                                url : '{{url("sisadmin/ubicacion/_modificarEstado")}}',
                                data : {
                                    ubi_id:ubi_id
                                },
                                type : 'POST',
                                success : function(resp) {
                                    console.log(resp);
                                    if(resp.res == true){
                                        toastr.success('Operación completada','');
                                        location.reload(true);
                                    }else{
                                        toastr.error('Ocurrio un error al eliminar el video o sonido : '+nombre+'','');
                                    }
                                },
                                error : function(xhr, status) {
                                    toastr.error('Ocurrio un error el video o sonido : '+nombre+'','');
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
