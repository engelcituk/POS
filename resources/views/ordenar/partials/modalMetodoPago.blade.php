<div class="modal fade" id="modalMetodoPago" tabindex="-1" role="dialog" aria-labelledby="modalMetodoPago">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header modal-header-personalizado">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"> <strong>Indique Método de pago</strong></h4>
      </div>     
        <form action="">
            <div class="modal-body">
              <input type="text" class="form-control hidden" id="idCuentaCerrar">                                                   
                <div class="row">
                    <div class="col-md-12">                                                        
                        <div class="form-group">
                          <select class="form-control" name="formaPagoSelect" id=formaPagoSelect>                              
                              @foreach($metodosPago as $mp)
                                  <option value="{{$mp->id}}">{{$mp->name}}</option>
                              @endforeach
                          </select>
                        </div>
                    </div>
                </div>            
            </div>
            <div class="modal-footer">                                
                <button type="button" class="btn btn-danger pull-left" data-dismiss="modal"> <i class="fas fa-undo"></i> Descartar</button>
                <button type="button" class="btn btn-success pull-right" id="cerrarCuentaBtn" onclick="cerrarCuenta()"><i class="fas fa-check-circle"></i> Aceptar</button> 
            </div>
        </form>
    </div>
  </div>
</div>