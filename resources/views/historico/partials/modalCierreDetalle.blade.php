
<div class="modal fade" id="modalDetalleFiltro" tabindex="-1" role="dialog" aria-labelledby="modalDetalleFiltro">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header modal-header-personalizado">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"> <strong>Desglose: <span id="fechaDesglose"></span> </strong></h4>
      </div>
      <div class="modal-body">                              
                
        <div id="showLoader"></div>
        <div class="row">
          <div id="invoice-POS">
            {{-- <button class="btn btn-danger pull-right" id="fechaFiltroBtn" onclick="generarPdfFiltro()"> <i class="far fa-file-pdf"></i> PDF</button> --}}
            
            <button class="btn btn-success pull-right" id="fechaFiltroBtn" onclick="generarExcelFiltro()"> <i class="far fa-file-excel"></i> Excel</button>  
            <button class="btn btn-info pull-right" id="fechaFiltroBtn" onclick="imprimirDesglose()"> <i class="far fa-file-excel"></i> Imprimir</button>        
          </div>
        </div>
        <div class="row">          
          <div id="invoice-POS">
            <div class="well well-sm">
              <strong>Total de cuentas: </strong><span class="label label-success" id="totalCuentas"></span> 
                <strong>Total adultos: </strong><span class="label label-success" id="totalAdultos"></span> 
                <strong>Total niños: </strong><span class="label label-success" id="totalNinos"></span> 
                <strong>Total pax: </strong><span class="label label-success" id="totalPax"></span>                
            </div>
            <div class="table-responsive">
              <table id="detalleCuentasFiltro" class="table table-hover" cellspacing="0" width="100%" style="width:100%">
                <thead>
                    <tr class="info">
                        <th>Cuenta</th>
                        <th>Folio</th>
                        <th>Fecha apertura</th>
                        <th>Hora Alta</th>
                        <th>Hora Cierre</th>
                        <th>Hab.</th>
                        <th>Cliente</th>
                        <th>Pax</th>                        
                        <th>Total cuenta</th> 
                    </tr>
                </thead>                
                <tbody>
                    
                </tbody>
              </table>            
            </div>
            <br>
            <div class="well well-sm">
              <strong>Productos favoritos: </strong><span class="label label-success" id="productosFavoritos"></span>                  
            </div>
            <div class="table-responsive">
              <table id="productosFavoritosFiltro" class="table table-hover" cellspacing="0" width="100%" style="width:100%">
                <thead>
                    <tr class="info">
                        <th>Producto</th>
                        <th>Cantidad</th>                         
                    </tr>
                </thead>                
                <tbody>
                    
                </tbody>
              </table>            
            </div>            
          </div><!--End Invoice-->         
        </div>                    
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning pull-right" data-dismiss="modal"> <i class="fas fa-sign-out-alt"></i> Salir</button>        
      </div>
    </div>
  </div>
</div>