<div class="modal fade" id="modalDescuentoCuenta" tabindex="-1" role="dialog" aria-labelledby="modalDescuentoCuenta">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header modal-header-personalizado">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"> <strong>Indique el descuento</strong></h4>
      </div>     
        <form action="">
            <div class="modal-body">                                                   
                <div class="row">
                    <div class="col-md-12">
                        <input type="number" class="form-control hidden" id="idCuentaModalDescuento">        
                        <input type="number" class="form-control" id="cantidadDescuento" placeholder="Descuento (0 a 100) %">
                    </div>
                </div>            
            </div>
            <div class="modal-footer">                                
                <button type="button" class="btn btn-danger pull-left" data-dismiss="modal"> <i class="fas fa-undo"></i> Descartar</button>
                <button type="button" class="btn btn-success pull-right" id="addDescuentoBtn" onclick="addDescuento()"><i class="fas fa-check-circle"></i> Aceptar</button> 
            </div>
        </form>
    </div>
  </div>
</div>