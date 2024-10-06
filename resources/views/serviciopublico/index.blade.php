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
            <li class="breadcrumb-item active" aria-current="page">Servicios Publicos</li>
        </ol>
    </nav>
    <!-- Breadcrumb Area End-->
    <div class="row justify-content-center">
        <h3 align="center">Lista de Servicios Publicos: {{$unidad->nombre}}</h3>
        <div class="col-md-12">
            <div class="col-md-12">
                    @if (verificarAcceso(54))
                        <a href="{{ url('sisadmin/serviciopublico/create/'.$und_id) }}" class="btn btn-primary btn-sm" id="btnNuevo"><i class="fa fa-plus"></i> Agregar</a>
                    @else
                        <a href="#" class="btn btn-primary btn-sm disabled" ><i class="fa fa-plus"></i> Agregar</a>
                    @endif
                <br>
                <div class="content" id="contenidoLista">
                    <table class="table table-hover table-responsive-xl table-sm" id="tablaContenido">
                        <thead>
                        <tr>
                            <th>N° </th>
                            <th>Nombre</th>
                            <th>Descripcion</th>
                            <th>Horario atencion</th>
                            <th>Imagen</th>
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
                                    {{$item->horario_atencion}}
                                </td>
                                <td>
                                    @php
                                        $imagen = $item->servicioImagenes->first(function ($value, $key) {
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
                                    @if (verificarAcceso(56))
                                        {{
                                            Form::select('publicar',$publicar,$item->publicar,['class'=>'form-control form-control-sm','id'=>'publicar','onchange'=>"cambiarPublicar('$item->sep_id',this.value);"])
                                        }}
                                     @else
                                          {{$publicar[$item->publicar]}}
                                     @endif
                                </td>
                                <td>
                                    @if (verificarAcceso(55))
                                        <a href="{{ url('sisadmin/serviciopublico/edit/'.$item->sep_id.'/'.$und_id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Editar</a>
                                    @else
                                        <a href="#" class="btn btn-primary btn-sm disabled"><i class="fa fa-edit"></i> Editar</a>
                                    @endif
                                    @if (verificarAcceso(57))
                                        <button type="button" class="btn btn-danger btn-sm" onclick="modificarEstado('{{$item->sep_id}}','{{$item->nombre}}');"><i class="fa fa-trash"></i> Eliminar</button>
                                    @else
                                        <button type="button" class="btn btn-danger btn-sm disabled" ><i class="fa fa-trash"></i> Eliminar</button>
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
        function modificarEstado(sep_id,nombre)
        {
            var mensajeConsulta = '¿Desea eliminar el servicio publico: '+nombre+'?';
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
                                url : '{{url("sisadmin/serviciopublico/_modificarEstado")}}',
                                data : {
                                    sep_id:sep_id
                                },
                                type : 'POST',
                                success : function(resp) {
                                    console.log(resp);
                                    if(resp.res == true){
                                        toastr.success('Operación completada','');
                                        location.reload(true);
                                    }else{
                                        toastr.error('Ocurrio un error al eliminar el servicio publico : '+nombre+'','');
                                    }
                                },
                                error : function(xhr, status) {
                                    toastr.error('Ocurrio un error el servicio publico: '+nombre+'','');
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

        function cambiarPublicar(sep_id,publicar){
            console.log(sep_id+' '+publicar);
            loaderR.showPleaseWait();
            $.ajax({
                url : '{{url("sisadmin/serviciopublico/_cambiarPublicar")}}',
                data : {
                    sep_id:sep_id,
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

    </script>
@endsection
