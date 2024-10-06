@extends('layouts.app')

@section('header_styles')
    <link href="{{ asset('css/gijgo.min.css') }}" rel="stylesheet" type='text/css'>
    <style type="text/css">

    </style>
@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if ($rol->rol_id == 0)
                <h3 align="center">Nuevo Rol</h3>
            @else
                <h3 align="center">Editar Rol</h3>
            @endif
            <br>
            <form class="form-horizontal" id="formulario" autocomplete="off" method="POST" enctype="multipart/form-data" action="{{ url('sisadmin/roles/store') }}">
                {{ csrf_field() }}
                <div class="form-group row">
                    <label class="col-md-1 col-form-label"></label>
                    <label class="col-md-2 col-form-label">Nombre del Rol*:</label>
                    <div class="col-md-8">
                        {{Form::hidden('rol_id',$rol->rol_id)}}
                        {{Form::hidden('estado',$rol->estado)}}
                        <input type="hidden" name="idsAccesos" id="idsAccesos" value="">
                        <input type="text" value="{{ old('descripcion',$rol->descripcion) }}" class="form-control form-control-sm"  name="descripcion" id="descripcion" required >
                        @error('descripcion')
                        <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6" id="treeview1">

                    </div>
                    <div class="col-md-3"></div>
                </div>

                <div class="row justify-content-center" style="margin-top: 10px;">
                    <div class="col-md-2">
                        <button id="btn_guardar" class="btn btn-primary" type="submit" id="btnGuardar">Guardar</button>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ url('sisadmin/roles')}}" class="btn btn-danger">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('footer_scripts')
    <script type="text/javascript" src="{{ asset('js/gijgo.min.js') }}"></script>
    <script type="text/javascript">
        var listaS = {!!$accesos->toJson()!!};
        var modelo = {idUsuario:1};
        modelo.datos = new Array();
        var tree = null;
        $(document).ready(function(){
            //asignarDatepicker($("#fecha"));
            $("#formulario").submit(function (){
                loaderR.showPleaseWait();
            });

            tree = $('#treeview1').tree({
                primaryKey: 'idSelect',
                iconsLibrary: 'fontawesome',
                width: 500,
                uiLibrary: 'bootstrap4',
                dataSource: listaS,
                checkboxes: true
            });
            //para mostrar el select todos expandidos
            //tree.expandAll();
            tree.on('checkboxChange', function (e, node, record, state) {
                // console.log(node);
                //console.log(record);
                // console.log(state);
                var res = getTodosSeleccionados();
                console.log(res.join('-'));
                $("#idsAccesos").val(res.join('-'));
            });

            //actualizamos los ids
            armarIds();

        });

        function getTodosSeleccionados() {
            var res = new Array();
            var nodosChekeados = tree.getCheckedNodes();
            nodosChekeados.forEach( function(element, index) {
                var nodo = tree.getDataById(element);
                var idSelect = nodo.idSelect;
                if (idSelect.startsWith("N3-")){
                    res.push(nodo.id);
                }
            });
            return res;
        }

        function armarIds()
        {
            var res = getTodosSeleccionados();
            console.log(res.join('-'));
            $("#idsAccesos").val(res.join('-'));
        }
    </script>
@endsection
