<div class="modal fade" id="modalVerDetalle" tabindex="-1" role="dialog" aria-labelledby="modalVerDetalle">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header modal-header-personalizado">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"> <strong>Detalles de la cuenta</strong></h4>
      </div>
      <div class="modal-body">                              
        <div class="row">
          <div class="col-md-4">
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fas fa-info-circle"></i>
                </span>
                <div class="form-group label-floating">
                    <strong>Folio cuenta</strong>
                    <input  type="text" id="folioCuenta" class="form-control" name="folioCuenta" disabled>
                    
                </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fas fa-info-circle"></i>
                </span>
                <div class="form-group label-floating">
                    <strong>Habitación</strong>
                    <input  type="text" id="habitacion" class="form-control" name="habitacion" disabled>                    
                </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fas fa-info-circle"></i>
                </span>
                <div class="form-group label-floating">
                    <strong>Pax</strong>
                    <input  type="text" id="pax" class="form-control" name="pax" disabled>
                    
                </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fas fa-info-circle"></i>
                </span>
                <div class="form-group label-floating">
                    <strong>Reserva</strong>
                    <input  type="text" id="reserva" class="form-control" name="reserva" disabled>
                    
                </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fas fa-info-circle"></i>
                </span>
                <div class="form-group label-floating">
                    <strong>Nombre cliente</strong>
                    <input  type="text" id="nombreCliente" class="form-control" name="nombreCliente" disabled>
                    
                </div>
            </div>
          </div>
        </div>
        <br>
        <div id="showLoader"></div>
        <div class="row">          
          <div id="invoice-POS">
            <div class="table-responsive">
              <table id="detalleCuenta" class="table table-hover" cellspacing="0" width="100%" style="width:100%">
                <thead>
                    <tr class="info">
                        <th>Cantidad</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Subtotal</th>                        
                        <th>Estado</th> 
                    </tr>
                </thead>                
                <tbody>
                    
                </tbody>
              </table>            
            </div>              
          </div><!--End Invoice-->         
        </div> 
        <div class="row">
          <div class="col-md-4 pull-right">
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fas fa-money-check-alt"></i>
                </span>
                <div class="form-group label-floating">
                    <strong>Total cuenta</strong>
                    <input  type="text" id="sumSubTotales" class="form-control" name="sumSubTotales" disabled>
                    
                </div>
            </div>
          </div>
        </div>           
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning pull-right" data-dismiss="modal"> <i class="fas fa-sign-out-alt"></i> Salir</button>        
      </div>
    </div>
  </div>
</div>