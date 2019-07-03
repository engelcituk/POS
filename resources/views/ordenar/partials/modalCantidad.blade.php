<div class="modal fade" id="modalCantidadProducto" tabindex="-1" role="dialog" aria-labelledby="modalCantidadProducto">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header modal-header-personalizado">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"> <strong>Indique cantidad de producto</strong></h4>
      </div>     
        <form action="">
            <div class="modal-body">                                                   
                <div class="row">
                    <div class="col-md-12">
                        <input type="number" class="form-control hidden" id="idProductoModal">        
                        <input type="number" class="form-control hidden" id="idMenuCartaModal"> 
                        <input type="number" class="form-control" id="cantidadProducto" min="1" value="1">
                    </div>
                </div>            
            </div>
            <div class="modal-footer">                                
                <button type="button" class="btn btn-danger pull-left" data-dismiss="modal"> <i class="fas fa-undo"></i> Descartar</button>
                <button type="button" class="btn btn-success pull-right" id="addProductoBtn" onclick="addProducto()"><i class="fas fa-check-circle"></i> Aceptar</button> 
            </div>
        </form>
    </div>
  </div>
</div>