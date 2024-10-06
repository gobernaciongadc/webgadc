                    <table  class="table table-hover table-bordered" id="tabla">
                          <thead>
                            <tr>                          
                              <th>Opciones de Respuesta</th>
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