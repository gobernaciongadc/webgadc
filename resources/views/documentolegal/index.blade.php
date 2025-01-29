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
        <li class="breadcrumb-item active" aria-current="page">Documentos legales</li>
    </ol>
</nav>
<!-- Breadcrumb Area End-->
<div class="row justify-content-center">
    <h3 align="center">Documentos legales: {{$unidad->nombre}}</h3>
    <div class="col-md-12">
        <div class="col-md-12">
            @if (verificarAcceso(34))
            <a href="{{ url('sisadmin/documentolegal/create/'.$und_id) }}" class="btn btn-primary btn-sm" id="btnNuevo"><i class="fa fa-plus"></i> Agregar</a>
            @else
            <a href="#" class="btn btn-primary btn-sm disabled"><i class="fa fa-plus"></i> Agregar</a>
            @endif
            <br>
            <div class="content" id="contenidoLista">
                <table class="table table-hover table-responsive-xl table-sm" id="tablaContenido">
                    <thead>
                        <tr>
                            <th>N° </th>
                            <th>Titulo</th>
                            <th>Resumen</th>
                            <th>Contenido</th>
                            <th>Fecha Publicación</th>
                            <th>Fecha Promulgación o Emisión</th>
                            <th width="8%">Archivo</th>
                            <th>Anexo</th>
                            <th width="8%">Publicar</th>
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
                                {{$item->titulo}}
                            </td>
                            <td>
                                {{$item->resumen}}
                            </td>
                            <td>
                                {{$item->contenido}}
                            </td>
                            <td>{{date('d/m/Y',strtotime($item->fecha_aprobacion))}}</td>
                            <td>{{date('d/m/Y',strtotime($item->fecha_promulgacion))}}</td>
                            <td>
                                <a target="_blank" href="{{asset('storage/uploads/'.$item->archivo)}}"><i class="fa fa-download"></i> Descargar</a>
                            </td>
                            @if($item->anexo != null)
                            <td>
                                <a target="_blank" href="{{asset('storage/uploads/'.$item->anexo)}}"><i class="fa fa-download"></i> Descargar</a>
                            </td>
                            @else
                            <td>Sin Anexo</td>
                            @endif
                            <td>
                                @if (verificarAcceso(36))
                                {{
                                            Form::select('publicar',$publicar,$item->publicar,['class'=>'form-control form-control-sm','id'=>'publicar','onchange'=>"cambiarPublicar('$item->dol_id',this.value);"])
                                        }}
                                @else
                                {{$publicar[$item->publicar]}}
                                @endif
                            </td>
                            <td>
                                @if (verificarAcceso(35))
                                <a href="{{ url('sisadmin/documentolegal/edit/'.$item->dol_id.'/'.$und_id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Editar</a>
                                @else
                                <a href="#" class="btn btn-primary btn-sm disabled"><i class="fa fa-edit"></i> Editar</a>
                                @endif
                                @if (verificarAcceso(37))
                                <button type="button" class="btn btn-danger btn-sm" onclick="modificarEstado('{{$item->dol_id}}','{{$item->titulo}}');"><i class="fa fa-trash"></i> Eliminar</button>
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
    function modificarEstado(dol_id, titulo) {
        var mensajeConsulta = '¿Desea eliminar el documento legal : <br> ' + titulo + '?';
        $.confirm({
            theme: 'modern',
            title: false,
            content: mensajeConsulta,
            buttons: {
                SI: {
                    text: 'SI',
                    btnClass: 'btn-blue',
                    keys: ['enter'],
                    action: function() {
                        $.ajax({
                            url: '{{url("sisadmin/documentolegal/_modificarEstado")}}',
                            data: {
                                dol_id: dol_id
                            },
                            type: 'POST',
                            success: function(resp) {
                                console.log(resp);
                                if (resp.res == true) {
                                    toastr.success('Operación completada', '');
                                    location.reload(true);
                                } else {
                                    toastr.error('Ocurrio un error al eliminar el video o sonido : ' + nombre + '', '');
                                }
                            },
                            error: function(xhr, status) {
                                toastr.error('Ocurrio un error el video o sonido : ' + nombre + '', '');
                            },
                            complete: function(xhr, status) {}
                        });
                    }
                },
                NO: {
                    text: 'NO',
                    btnClass: 'btn-red',
                    action: function() {
                        //location.reload(true);
                    }
                }
            }
        });
    }

    function cambiarPublicar(dol_id, publicar) {
        console.log(dol_id + ' ' + publicar);
        loaderR.showPleaseWait();
        $.ajax({
            url: '{{url("sisadmin/documentolegal/_cambiarPublicar")}}',
            data: {
                dol_id: dol_id,
                publicar: publicar
            },
            type: 'POST',
            success: function(resp) {
                console.log(resp);

            },
            error: function(xhr, status) {
                toastr.error('Ocurrio un error en la operación', '');
            },
            complete: function(xhr, status) {
                loaderR.hidePleaseWait();
            }
        });
    }
</script>
@endsection