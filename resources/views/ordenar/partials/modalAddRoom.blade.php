<div class="modal fade" id="myModalAddRoom" tabindex="-1" role="dialog" aria-labelledby="myModalAddRoomLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header modal-header-personalizado">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalAddRoomLabel"> <strong>Agregar habitación a la cuenta</strong></h4>
      </div>
      <div class="modal-body">
        <form action="">
            <div class="row">
              <div class="col-md-4 col-sm-4">
                  <div class="input-group">
                      <span class="input-group-addon">
                          <i class="fas fa-user-circle"></i>
                      </span>
                      @php
                        $idHotel= Session::get('idHotel');
                        $datosHotel=App\Http\Controllers\HotelesController::obtenerHotelSesion($idHotel);  
                        // dd($datosHotel);           
                      @endphp
                      <div class="form-group label-floating">
                        Cuenta                      
                          <input id="idCuentaModal" type="text" class="form-control" name="idCuentaModal" readonly>
                          <input id="codigoHotelModal" type="text" class="form-control hidden" value="{{$datosHotel->codHotel}}" readonly>                     
                      </div>
                  </div>
              </div>
              <div class="col-md-4 col-sm-4">
                  <div class="input-group">
                      <span class="input-group-addon">
                          <i class="fas fa-bed"></i>
                      </span>
                      <div class="form-group label-floating">
                          Habitación
                          <input id="habitacionModal" type="text" class="form-control" autofocus>                     
                      </div>
                  </div>
              </div>
              <div class="col-md-4 col-sm-4">
                  <span class="btn btn-success btn-sm" onclick="buscarDatosHuesped()"><i class="fas fa-search"></i> Buscar</span>
              </div>
          </div>
          <div id="mensajeRespuestaModal"></div> 
          <div class="row">    
              <div class="col-md-6">
                <div class="input-group"> 
                    <span class="input-group-addon"><i class="fas fa-restroom"></i> Reserva</span>
                    
                    <div class="form-group label-floating">                            
                        <input type="text" class="form-control" id="reservaModal" name="reservaModal" readonly>  
                    </div>
                </div>
              </div>
              <div class="col-md-6">
                  <div class="input-group">
                    <span class="input-group-addon"> <i class="fas fa-file-signature"></i> Nombre</span>
                    <div class="form-group label-floating">
                        <input type="text" class="form-control" id="nombreModal" name="nombreModal">  
                    </div>
                </div>
              </div>
          </div>
          <div class="row">    
              <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fas fa-bed"></i> Habitación</span>
                    <div class="form-group label-floating">                            
                        <input type="text" class="form-control" id="roomModal" name="roomModal" readonly>  
                    </div>
                </div>
              </div>
              <div class="col-md-6">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fas fa-sort-numeric-up"></i> Pax</span>
                    <div class="form-group label-floating">                            
                        <input type="number" min="1" pattern="\d*" class="form-control" id="ocupanteModal" name="ocupanteModal" >  
                    </div>
                </div>
              </div>
          </div>
          <div class="row">    
              <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fas fa-bed"></i> Fecha Salida</span>
                    <div class="form-group label-floating">                            
                        <input type="text" class="form-control" id="fechaSalidaModal" name="fechaSalidaModal" readonly>  
                    </div>
                </div>
              </div>
              <div class="col-md-6">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fas fa-sort-numeric-up"></i> Brazalete</span>
                    <div class="form-group label-floating">                            
                        <input type="number" min="1" class="form-control" id="brazaleteModal" name="brazaleteModal" >  
                    </div>
                </div>
              </div>
          </div>
          {{-- <div class="row">    
              <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fas fa-calendar-alt"></i> Fecha salida</span>
                    <div class="form-group label-floating">                            
                        <input type="text" class="form-control" id="fechaSalidaModal" name="fechaSalidaModal"  readonly>  
                    </div>
                </div>
              </div>
              <div class="col-md-6">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fas fa-ring"></i> Brazalete</span>
                    <div class="form-group label-floating">                           
                        <input type="text" class="form-control" id="brazaleteModal" name="brazaleteModal" readonly>  
                    </div>
                </div>
              </div>
          </div> --}}
        </form>                         
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning pull-left" data-dismiss="modal"> <i class="fas fa-undo"></i> Descartar</button>
        <button type="button" class="btn btn-primary" onclick="updateRoom()"><i class="fas fa-plus-circle"></i> Guardar</button>        
      </div>
    </div>
  </div>
</div>