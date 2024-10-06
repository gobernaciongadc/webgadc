
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
            <li class="breadcrumb-item active" aria-current="page">Pregunta</li>
        </ol>
    </nav>
    <!-- Breadcrumb Area End-->
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if ( $Pregunta->pre_id == 0)
                <h3 align="center">Nueva Pregunta</h3>
            @else
                <h3 align="center">Editar Pregunta</h3>
            @endif
            <br>
            <form class="form-horizontal" id="formulario" autocomplete="off" method="POST" enctype="multipart/form-data" action="{{ url('sisadmin/pregunta/store') }}">
                {{ csrf_field() }}
                <div class="form-group row">
                    <label class="col-md-2 col-form-label text-right">Pregunta*:</label>
                    {{Form::hidden('pre_id',$Pregunta->pre_id)}}
                    <div class="col-md-10">
                         <input type="hidden" class="form-control form-control-sm" value="{{$pre_id}}" name="pre_id" id="pre_id" >
                        <textarea rows="3" cols="30" type="text"  class="form-control form-control-sm" name="pregunta" id="pregunta" required >{{ old('pregunta',$Pregunta->pregunta) }}</textarea>
                        @error('pregunta')
                        <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div><br>

                <div class="form-group row">
                   <label class="col-md-4 col-form-label"><b>Lista de respuestas:</b></label>
                   <div class="col-md-5"></div>
                   <div class="col-md-3 text-right">
                      <button type="button" class="btn btn-success btn-sm   " onclick="agregarfila();"><i class="fa fa-plus"></i> Agregar Respuesta</button>
                   </div>
                </div>
                <div class="form-group row">
                  <div class="col-md-12" id="contenidoLista">
                    <table  class="table table-hover table-bordered" id="tabla">
                          <thead>
                            <tr>                          
                              <th align="center">Opciones de Respuesta</th>
                              <th></th>
                            </tr>
                          </thead>
                          <tbody>
                            @php
                              $indiceUno = 1;
                              $cantidadRows = 1;
                            @endphp
                            @foreach ($opciones as $itemes)
                                  <tr id="filaPlanificacion-${indiceUno }">    
                                      <td width="90%">
                                           <div class="form-group row">
                                              <label class="col-md-2 col-form-label text-right" >Respuesta {{$cantidadRows++}}*:</label>
                                              <div class="col-md-10">
                                                  <input type="hidden" class="form-control form-control-sm" value="{{$itemes->ops_id}}" 
                                                     name="ops_id{{$indiceUno}}"  id="ops_id{{$indiceUno}}">
                                                  <input type="text" class="form-control form-control-sm" value="{{$itemes->texto_respuesta}}" 
                                                     name="texto_respuesta{{$indiceUno}}"  id="texto_respuesta{{$indiceUno}}" required>
                                              </div>  
                                          </div> 
                                      </td>  
                                      <td width="7%">
                                        <button type="button" class="btn btn-danger btn-sm" onclick="quitarHijoLista('{{$itemes->ops_id}}',0);">Quitar</button>
                                      </td>                         
                                  </tr>
                            @php
                              $indiceUno++;
                            @endphp
                            @endforeach
                          </tbody>                
                    </table>
                  </div>
                </div>
                
                <input type="hidden" class="form-control form-control-sm"  name="cantidad" id="cantidad" >
                <div class="row justify-content-center" style="margin-top: 10px;">
                    <div class="col-md-2">
                        <input id="button" class="btn btn-primary btn-sm"   type="button" value="Guardar"/>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ url('sisadmin/pregunta/') }}" class="btn btn-danger btn-sm">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('footer_scripts')
    <script type="text/javascript">

    $("#button").click(function(event){
        var cantIma =  $('#tabla > tbody  > tr').length;
        if(cantIma >= 2) {
              $('#formulario').submit();       

        }else{
          toastr.warning('Como minimo debe de tener Dos Opciones de respuesta','');
        }
    });

    function VerificarCantidadRespuesta() {
          var variables = 0;
          $('#tabla > tbody  > tr').each(function(index,value) {
              var item = {};
              var valor = $("#texto_respuesta"+index).val();
              if (valor === undefined || valor==="") {
              }else{
                variables = variables + 1;

              }
          });

          $("#cantidad").val(variables);
    }

    function agregarfila() {
        var can = $('#tabla > tbody  > tr').length;
        if(can<=5){
         var cantidadRows = 0;
           $('#tabla > tbody  > tr').each(function(index,value) {
                cantidadRows++;
           });  
           cantidadRows = can + 1;
            var rowAgregar = '<tr id="filaPlanificacion-'+cantidadRows+'">'+                           
                                   '<td><div class="form-group row"><label class="col-md-2 col-form-label text-right" >Respuesta '+cantidadRows+'*:</label><div class="col-md-10"><input type="hidden" id="estado'+cantidadRows+'"name="estado'+cantidadRows+'" value="AC"><input type="hidden" name="ops_id'+cantidadRows+'"  id="ops_id'+cantidadRows+'" value="0"><input class="form-control form-control-sm" id="texto_respuesta'+cantidadRows+'" name="texto_respuesta'+cantidadRows+'"  type="text" required="required" ></div></div></td>'+
                                   '<td width="7%">'+ '<button type="button" class="btn btn-danger btn-sm" onclick="quitarHijo('+cantidadRows+',0);"> Quitar</button> '+'</td>'+
                             '</tr>'; 
            $("#tabla tbody").append(rowAgregar);
        }else{
           toastr.warning('No puede agregar mas de 6 respuestas ','');
        }

    }

    function quitarHijoLista(ops_id,imagen){
            var cantIma =  $('#tabla > tbody  > tr').length;
            if(cantIma>=3) {
                var pre_id = $("#pre_id").val();
                loaderR.showPleaseWait();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '{{url("sisadmin/pregunta/_eliminaropcion")}}',
                    data: {
                        ops_id: ops_id,
                        pre_id: pre_id
                    },
                    type: 'POST',
                    success: function (resp) {
                        loaderR.hidePleaseWait();
                        console.log(resp);
                        $("#contenidoLista").html(resp);
                    },
                    error: function (xhr, status) {
                        loaderR.hidePleaseWait();
                        alert('Disculpe, existió un problema');
                    },
                    complete: function (xhr, status) {

                    }
                });
          }else{
                toastr.warning('Como minimo debe de tener Dos Opciones de respuesta','');
          }

    }

    //ELIMINAR LOS HIJOS
    function quitarHijo(cantidadRows,indice,id) {
          $("#estado"+cantidadRows).val("EL");  
          $("#texto_respuesta"+cantidadRows).val(""); 
          console.log("#estado"+cantidadRows);     
          actualizarTablaHijo(cantidadRows);
    }

    function actualizarTablaHijo(idePapa) {  
     $('#tabla > tbody  > tr').each(function(index,value) {
       var estadoRow = $("#estado"+index).val();
       if(estadoRow != 'AC'){
          $("#filaPlanificacion-"+idePapa).hide();
         }
     });
    } 





    </script>
@endsection
