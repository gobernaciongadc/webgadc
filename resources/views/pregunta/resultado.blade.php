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
            <li class="breadcrumb-item active" aria-current="page">Resultados</li>
        </ol>
    </nav>
    <!-- Breadcrumb Area End-->
 
    <div class="row justify-content-center">
        <div class="col-md-8">
                <h3 align="center">Resultados de la Encuesta</h3>
            <br>
            <form class="form-horizontal" id="formulario" autocomplete="off" method="POST" enctype="multipart/form-data" action="{{ url('sisadmin/respuesta/store') }}">
                {{ csrf_field() }}
   
 
                 <div class="form-group row">
                    <label class="col-md-2 col-form-label" >Pregunta*:</label>
                    <div class="col-md-10">
                        <textarea rows="3" cols="30" type="text"  class="form-control form-control-sm" name="pregunta" id="pregunta" required >{{$Pregunta->pregunta}}</textarea>
                    </div>
                </div><br>
                <div class="form-group row">
                  <div class="col-md-12" id="contenidoLista">
                    <label class="col-md-2 col-form-label text-right">Lista de respuestas:</label>
                    <table  class="table table-hover table-bordered" id="tabla">
                          <thead>
                            <tr>                          
                              <th>Opciones de Respuesta</th>
                              <th>Cantidad</th>
                              <th>Porcentaje</th>
                            </tr>
                          </thead>
                          <tbody>
                            @php
                              $indiceUno = 1;
                              $cantidadRows = 1;
                            @endphp
                            @foreach ($opciones as $itemes)
                                  <tr>    
                                      <td width="80%">
                                           <div class="form-group row">
                                            <div class="col-md-1">{{$indiceUno++}} </div>
                                              <div class="col-md-10">
                                                    <b>{{$itemes->texto}}</b>
                                              </div>  
                                          </div> 
                                      </td>  
                                      <td width="7%">
                                         <b>{{$itemes->cantidad}}</b>
                                      </td>  
                                      <td width="7%">
                                         <b>{{$itemes->porcentaje}}  %</b>
                                      </td>                         
                                  </tr>
                            @endforeach
                          </tbody>                
                    </table>
                  </div>
                </div>
                <br><br>

                <div class="row justify-content-center" style="margin-top: 10px;">
                    <div class="row">
                        <a href="{{ url('sisadmin/pregunta/') }}" class="btn btn-warning btn-sm">Atras</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('footer_scripts')
    <script type="text/javascript">

        function modificarEstado(pre_id,solicitante,texto)
        {
            var mensajeConsulta = '¿Desea '+texto+' la pregunta: '+solicitante+'?';
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
                                    pre_id:pre_id,
                                    texto:texto
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
