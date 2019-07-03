<div class="modal fade" id="modalCancelarCuenta" tabindex="-1" role="dialog" aria-labelledby="modalCancelarCuenta">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header modal-header-personalizado">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"> <strong>Indique un motivo para cancelar esta cuenta</strong></h4>
      </div>     
        <form action="">
            <div class="modal-body">                              
              <input type="text" class="form-control hidden" id="idCuentaCancelar">                     
                <div class="row">
                    <div class="col-md-12">
                        <input type="text" class="form-control" id="motivoCancelacion" placeholder="indique el motivo de cancelacion" required>        
                    </div>
                </div>            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning pull-left" data-dismiss="modal"> <i class="fas fa-undo"></i> Descartar</button>
                <button type="button" class="btn btn-danger" id="cancelarCuentaBtn" onclick="cancelarCuenta()"><i class="fas fa-ban"></i> Cancelar</button>        
            </div>
        </form>
    </div>
  </div>
</div>