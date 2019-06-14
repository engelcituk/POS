<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header modal-header-personalizado">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"> <strong>Indique habitación || Alergenos</strong></h4>
      </div>
      <div class="modal-body">                
          <ul class="nav nav-tabs navPersonalizado">
            <li class="active"><a data-toggle="tab" href="#buscarHabitacion">Habitación</a></li>
            <li><a data-toggle="tab" href="#alergenos">Alergenos</a></li>   
          </ul>
          <div class="tab-content">
            <div id="buscarHabitacion" class="tab-pane fade in active">
              <div class="row">         
                <div class="col-md-4 col-sm-6 hidden">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fas fa-hotel"></i>
                        </span>
                        <div class="form-group label-floating">
                            <label class="control-label">Codigo Hotel</label>
                            <input id="codigoHotel" type="text" class="form-control" name="codigoHotel" value="CARACOL">
                            <input id="idMesaModal" type="number" class="form-control" name="idMesaModal">   
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fas fa-bed"></i>
                        </span>
                        <div class="form-group label-floating">
                            <label class="control-label">Habitación</label>
                            <input id="numHabitacion" type="text" class="form-control" name="numHabitacion" autofocus>                     
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                  {{-- span de tipo button que ejecuta funcion que trae datos del huesped --}}
                  <span class="btn btn-success pull-right" onclick="buscarHuesped()"><i class="fas fa-search"></i> Buscar</span>
                </div>
               </div>        
              <div id="mensajeRespuesta"></div>                      
              <div class="row">    
                  <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-addon">
                            {{-- <i class="fas fa-restroom"></i> --}}Reserva
                        </span>
                        
                        <div class="form-group label-floating">
                            {{-- <label class="control-label">Reserva</label> --}}
                            <input type="text" class="form-control" id="reserva" name="reserva" readonly>  
                        </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                      <div class="input-group">
                        <span class="input-group-addon">
                            {{-- <i class="fas fa-file-signature"></i> --}}Nombre
                        </span>
                        <div class="form-group label-floating">
                            {{-- <label class="control-label">Nombre</label> --}}
                            <input type="text" class="form-control" id="nombre" name="nombre" readonly>  
                        </div>
                    </div>
                  </div>
              </div>
              <div class="row">    
                  <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-addon">
                            {{-- <i class="fas fa-child"></i> --}}room
                        </span>
                        <div class="form-group label-floating">
                            {{-- <label class="control-label">Edad</label> --}}
                            <input type="text" class="form-control" id="room" name="room" readonly>  
                        </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                      <div class="input-group">
                        <span class="input-group-addon">
                            {{-- <i class="fas fa-users"></i> --}}Ocupante
                        </span>
                        <div class="form-group label-floating">
                            {{-- <label class="control-label">Ocupante</label> --}}
                            <input type="number" class="form-control" id="ocupante" name="ocupante" >  
                        </div>
                    </div>
                  </div>
              </div>
              <div class="row">    
                  <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-addon">
                            {{-- <i class="fas fa-calendar-alt"></i> --}}Fecha salida
                        </span>
                        <div class="form-group label-floating">
                            {{-- <label class="control-label">Fecha salida</label> --}}
                            <input type="text" class="form-control" id="fechaSalida" name="fechaSalida"  readonly>  
                        </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                      <div class="input-group">
                        <span class="input-group-addon">
                            {{-- <i class="fas fa-ring"></i> --}}Brazalete
                        </span>
                        <div class="form-group label-floating">
                            {{-- <label class="control-label">Brazalete</label> --}}
                            <input type="text" class="form-control" id="brazalete" name="brazalete" readonly>  
                        </div>
                    </div>
                  </div>
              </div>
            </div>
            <div id="alergenos" class="tab-pane fade">
              <p>Seleccione alergenos</p>
               <div class="row">
                @foreach($alergenos as $alergeno)                                
                  <div class="col-md-4">
                    <div class="checkbox checkbox-group required">                              
                          <label class="">
                          <input type="checkbox" id="idAlergenoCheck" name="idAlergeno[]" value="{{$alergeno->id}}"><strong>{{$alergeno->name}}</strong>
                          </label>                                            
                      </div>
                  </div>                                         
                @endforeach
              </div> 
            </div>
          
          </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning pull-left" data-dismiss="modal"> <i class="fas fa-undo"></i> Descartar</button>
        <button type="button" class="btn btn-primary" onclick="abrirCuenta()"><i class="fas fa-sign-in-alt" ></i> Abrir mesa</button>
        
      </div>
    </div>
  </div>
</div>