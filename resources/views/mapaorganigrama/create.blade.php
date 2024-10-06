@extends('layouts.app')

@section('header_styles')
    <style type="text/css">
        /*body{overflow-x: hidden; overflow-y: auto;}*/
        /*.container { margin: 150px auto; }*/
        .imagemaps-wrapper{
            display: flex;
            justify-content: start;
            align-items: start;
            position: relative;
            background-color: #0c5460;
        }
        .imagemaps-wrapper img{
            /*max-width: 100%;*/
        }
        .imagemaps-control{}
        .table td, .table th{vertical-align: middle;}
    </style>
@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if ($editar == false)
                <h3 align="center">Nuevo Mapa Organigrama <br> {{$unidad->nombre}}</h3>
            @else
                <h3 align="center">Editar Mapa Organigrama <br> {{$unidad->nombre}}</h3>
            @endif
            <br>
            <form class="form-horizontal" id="formulario" autocomplete="off" method="POST" enctype="multipart/form-data" action="{{ url('sisadmin/mapaorganigrama/store') }}">
                {{ csrf_field() }}
                {{Form::hidden('und_id',$unidad->und_id)}}
                <input type="hidden" name="html_organigrama" id="html_organigrama" value="">
                <div class="col-md-12">
                    <div class="imagemaps-wrapper">
                        {!! $html_image !!}
                    </div>
                    <div class="imagemaps-control">
                        <fieldset>
                            <legend>Settings</legend>
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Link Destino</th>
                                    <th scope="col">Target</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                                </thead>
                                <tbody class="imagemaps-output">
                                <tr class="item-###">
                                    <th scope="row">###</th>
                                    <td><input type="text" class="form-control area-href"></td>
                                    <td>
                                        <select class="form-control area-target">
                                            <option value="_self">_self</option>
                                            <option value="_blank">_blank</option>
                                        </select>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-delete">Quitar</button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </fieldset>
                        <div>
                            <button type="button" class="btn btn-info btn-add-map">Agregar Nuevo</button>
                            {{--<button type="button" class="btn btn-success btn-get-map">Capturar Map</button>--}}
                            <input type="hidden" name="imagen-temp" id="imagen-temp" class="btn-get-map">
                        </div>
                    </div>
                </div>


                <div class="row justify-content-center" style="margin-top: 10px;">
                    <div class="col-md-2">
                        <button id="btn_guardar" class="btn btn-primary" type="submit" id="btnGuardar">Guardar</button>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ url('sisadmin/'.$rutaAdicional)}}" class="btn btn-danger">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('footer_scripts')
    <script src="{{asset('js/jquery.imagemaps.js')}}"></script>
    <script type="text/javascript">
        var url_storage = '{{asset('storage/uploads/')}}';
        var imagen_actual = '{{$unidad->organigrama}}';
        $(document).ready(function(){
            window.localStorage.removeItem('imageMapsItemTemplate');
            if (imagen_actual === ''){
            }else{
                $('.imagemaps-wrapper').children('img').attr('src',url_storage+'/'+imagen_actual);
            }

            $("#formulario").submit(function (){
                let oParent = $('.btn-get-map').parent().parent().parent();
                let result  = oParent.find('.imagemaps-wrapper').clone();
                result.children('div').remove();
                // console.log(result.html());
                //alert(result.html());
                $("#html_organigrama").val(result.html());
                //toastr.success('','Mapa Organigrama Capturado Correctamente');
                loaderR.showPleaseWait();
            });

            $('.imagemaps-wrapper').imageMaps({
                addBtn: '.btn-add-map',
                // rectWidth: 100,
                // rectHeight: 60,
                // areaHref: '.area-href',
                // areaTarget: '.area-target',
                //btnDelete: '.btn-delete',
                output: '.imagemaps-output',
                stopCallBack: function(active, coords){
                    //console.log(active);
                    // console.log(coords);
                }
            });

            $('.btn-get-map').on('click', function(){
                let oParent = $(this).parent().parent().parent();
                let result  = oParent.find('.imagemaps-wrapper').clone();
                //console.log(result.html());
                result.children('div').remove();
                //console.log(result.html());
                //result.children('img').remove();
                //console.log(result.html());
                //alert(result.html());
                $("#html_organigrama").val(result.html());
                toastr.success('','Mapa Organigrama Capturado Correctamente');
            });

            /*$('.imagemaps-wrapper').imageMaps({
                rectWidth: 100,
                rectHeight: 60,
                areaHref: '.area-href',
                areaTarget: '.area-target',
                btnDelete: '.btn-delete'
            });*/

        });


    </script>
@endsection
