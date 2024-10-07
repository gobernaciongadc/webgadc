@extends('layouts.app')

@section('header_styles')
<style type="text/css">

</style>
@endsection
@section('content')

<div class="row justify-content-center">
    <h3 align="center">Lista Parametricas</h3>
    <div class="col-md-12 row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <table class="table table-hover table-responsive-xl table-sm" id="tablaContenido">
                <thead>
                    <tr>
                        <th>N° </th>
                        <th>Codigo</th>
                        <th>Valor 1</th>
                        <th>Valor 2</th>
                        <th>Valor 3</th>
                        <th>Valor 4</th>
                        <th>Valor 5</th>
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
                            {{$item->codigo}}
                        </td>
                        <td>
                            {{$item->valor1}}
                        </td>
                        <td>
                            {{$item->valor2}}
                        </td>
                        <td>
                            {{$item->valor3}}
                        </td>
                        <td>
                            {{$item->valor4}}
                        </td>
                        <td>
                            {{$item->valor5}}
                        </td>
                        <td>
                            <a href="{{ url('sisadmin/parametrica/edit/'.$item->par_id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Editar</a>
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
    function modificarEstado(bio_id, nombre) {
        var mensajeConsulta = '¿Desea elimnar la biografia de : ' + nombre + '?';
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
                            url: '{{url("sisadmin/biografia/_modificarEstado")}}',
                            data: {
                                bio_id: bio_id
                            },
                            type: 'POST',
                            success: function(resp) {
                                console.log(resp);
                                if (resp.res == true) {
                                    toastr.success('Operación completada', '');
                                    location.reload(true);
                                } else {
                                    toastr.error('Ocurrio un error al eliminar la biografia de : ' + nombre + '', '');
                                }
                            },
                            error: function(xhr, status) {
                                toastr.error('Ocurrio un error al eliminar la biografia de : ' + nombre + '', '');
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
</script>
@endsection