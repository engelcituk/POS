<div class="modal fade" id="wizardModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#home">Home</a></li>
            <li><a data-toggle="tab" href="#menu1">Menu 1</a></li>            
        </ul>

            <div class="tab-content">
            <div id="home" class="tab-pane fade in active">
                
                <div class="row">
                    <div class="col-md-4 col-sm-6 hidden">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fas fa-hotel"></i>
                        </span>
                        <div class="form-group label-floating">
                            {{-- <label class="control-label">Codigo Hotel</label> --}}
                            @php
                                $idHotel= Session::get('idHotel');
                                $datosHotel=App\Http\Controllers\HotelesController::obtenerHotelSesion($idHotel);  
                                // dd($datosHotel);           
                            @endphp
                            <input id="codigoHotel" type="text" class="form-control" name="codigoHotel" value="{{$datosHotel->codHotel}}">
                            <input id="idMesaModal" type="number" class="form-control" name="idMesaModal">   
                            <input id="idPVModalOrdenar" type="number" class="form-control" name="idPVModalOrdenar" value="{{Session::get('idPuntoVenta')}}">  
                            <input type="text" class="form-control" name="idCartaPVModal" id="idCartaPVModal" value="{{Session::get('idCarta')}} "> 
                            <input id="idUserModalOrdenar" type="text" class="form-control" name="idUserModalOrdenar" value="{{Session::get('idUsuarioLogueado')}}">
                        </div>
                    </div>
                </div>
                
                <div class="col-md-12">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fas fa-bed"></i>
                        </span>
                        <div class="form-group label-floating">
                            <label class="control-label">Habitación</label>
                            <input id="numHabitacion" type="text" class="form-control" name="numHabitacion" autofocus>                     
                            <span class="btn btn-success pull-right" onclick="buscarHuesped()"><i class="fas fa-search"></i> Buscar</span>
                        </div>
                    </div>
                </div>
                  
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
                            <input type="text" class="form-control" id="nombre" name="nombre">  
                        </div>
                    </div>
                  </div>
                 
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
                            {{-- <i class="fas fa-users"></i> --}}Pax
                        </span>
                        <div class="form-group label-floating">
                            {{-- <label class="control-label">Ocupante</label> --}}
                            <input type="number" min="1" class="form-control" id="ocupante" name="ocupante" >  
                        </div>
                    </div>
                  </div>
                 
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
            <div id="menu1" class="tab-pane fade">                               
             @if ($alergenos!="")
                @foreach($alergenos as $alergeno)                                
                  
                    <div class="checkbox checkbox-group required">                              
                          <label class="">
                          <input type="checkbox" id="idAlergenoCheck" name="idAlergeno[]" value="{{$alergeno->id}}"><strong>{{$alergeno->name}}</strong>
                          </label>                                            
                      </div>
                                                         
                @endforeach
              @else
                Aún no hay alergenos dados de alta                                    
              @endif 
              
            </div>            
            </div>
      </div>
      <div class="modal-footer">
        
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

