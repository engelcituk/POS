<div class="modal fade" id="modalVerDetalle" tabindex="-1" role="dialog" aria-labelledby="modalVerDetalle">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header modal-header-personalizado">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"> <strong>Detalles de la cuenta</strong></h4>
      </div>
      <div class="modal-body">                              
        <div class="row">
          <div id="invoice-POS">    
            <table id="detalleCuenta" class="table table-hover" cellspacing="0" width="100%" style="width:100%">
                <thead>
                    <tr class="info">
                        <th>IdCuenta</th>
                        <th>Cantidad</th>
                        <th>Comensal</th>                        
                        <th>Precio</th>
                    </tr>
                </thead>                
                <tbody>
                    <tr>
                        <td>John</td>
                        <td>Doe</td>
                        <td>john@example.com</td>
                        <td>Doe</td>

                    </tr>
                    <tr>
                        <td>Mary</td>
                        <td>Moe</td>
                        <td>mary@example.com</td>
                        <td>Doe</td>

                    </tr>
                </tbody>
            </table>
           </div><!--End Invoice-->         
        </div>            
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning pull-right" data-dismiss="modal"> <i class="fas fa-undo"></i> Descartar</button>        
      </div>
    </div>
  </div>
</div>