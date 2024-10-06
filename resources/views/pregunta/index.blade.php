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
            <li class="breadcrumb-item active" aria-current="page">Administracion</li>
            <li class="breadcrumb-item active" aria-current="page">Encuestas</li>
        </ol>
    </nav>
    <!-- Breadcrumb Area End-->
    <h3 align="center">Lista de Encuestas</h3>
    <div class="col-md-12">
        <div class="col-md-12">
            @if (verificarAcceso(100))
                <a href="{{ url('sisadmin/pregunta/create/') }}" class="btn btn-primary btn-sm" id="btnNuevo"><i class="fa fa-plus"></i> Agregar</a>
            @else
                <a href="#" class="btn btn-primary btn-sm disabled" ><i class="fa fa-plus"></i> Agregar</a>
            @endif
        <br>
        <div class="content" id="contenidoLista">
            <table class="table table-hover table-responsive-xl table-sm" id="tablaContenido">
                <thead>
                <tr>
                    <th width="3%">
                        N°
                    </th>
                    <th width="60%">
                        Pregunta
                    </th>
                    <th>
                        Respuestas
                    </th>
                    <th>
                        Fecha
                    </th>
                    <th width="7%">
                        Publicar
                    </th>
                     <th width="15%">
                        Acciones
                    </th>
                </tr>
                </thead>
                <tbody>
                @php
                    $indice = 1;
                @endphp
                @foreach ($lista as $item)
                    <tr>
                        <td>
                            {{$indice++}}
                        </td>
                        <td>
                            {{$item->pregunta}}
                        </td>
                        <td>
                            @foreach ($item->opciones as $itemes)
                            <p>
                                @if ($itemes->estado == 'AC')
                                    - {{$itemes->texto_respuesta}}
                                @endif
                            </p>
                            @endforeach
                        </td>
                        <td>
                            {{date('d/m/Y',strtotime($item->fecha_registro))}}
                        </td>
                        <td>
                            {{
                               Form::select('publicar',$publicar,$item->publicar,['class'=>'form-control form-control-sm','id'=>'publicar','onchange'=>"cambiarPublicar('$item->pre_id',this.value);"])
                            }}
                        </td>
                        <td>
                            @if (verificarAcceso(101))
                                <a href="{{ url('sisadmin/pregunta/edit/'.$item->pre_id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Editar</a>
                            @else
                                <a href="#" class="btn btn-primary btn-sm disabled"><i class="fa fa-edit"></i> Editar</a>
                            @endif

                            @if (verificarAcceso(103))
                                <button type="button" class="btn btn-danger btn-sm" onclick="modificarEstado('{{$item->pre_id}}','{{$item->pregunta}}');"><i class="fa fa-trash"></i> Eliminar</button>
                            @else
                                <button type="button" class="btn btn-danger btn-sm disabled" ><i class="fa fa-trash"></i> Eliminar</button>
                            @endif

                            @if (verificarAcceso(104))                        
                                <a href="{{ url('sisadmin/pregunta/resultado/'.$item->pre_id) }}" class="btn btn-warning btn-sm"><i class="fa fa-eye"></i> Ver Resultados</a>
                            @else
                                <a href="#" class="btn btn-warning btn-sm disabled"><i class="fa fa-eye"></i> Ver Resultados</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {{ $lista->links() }}
            </div>
        </div>
      </div>
    </div>
@endsection

@section('footer_scripts')
    <script type="text/javascript">

        function modificarEstado(pre_id,pregunta)
        {
            var mensajeConsulta = '¿Desea eliminar la pregunta: '+pregunta+'?';
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
                                url : '{{url("sisadmin/pregunta/_modificarEstado")}}',
                                data : {
                                    pre_id:pre_id
                                },
                                type : 'POST',
                                success : function(resp) {
                                    console.log(resp);
                                    if(resp.res == true){
                                        toastr.success('Operación completada','');
                                        location.reload(true);
                                    }else{
                                        toastr.error('Ocurrio un error al eliminar la pregunta','');
                                    }
                                },
                                error : function(xhr, status) {
                                    toastr.error('Ocurrio un error al eliminar la pregunta','');
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

        function cambiarPublicar(pre_id,publicar){
            console.log(pre_id+' '+publicar);
            loaderR.showPleaseWait();
            $.ajax({
                url : '{{url("sisadmin/pregunta/_cambiarPublicar")}}',
                data : {
                    pre_id:pre_id,
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
