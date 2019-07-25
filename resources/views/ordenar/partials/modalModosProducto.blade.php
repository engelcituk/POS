<div class="modal fade" id="modalModosProducto" tabindex="-1" role="dialog" aria-labelledby="modalModosProducto">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header modal-header-personalizado">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"> <strong>Indique modo de preparacion para el producto</strong></h4>
      </div>     
        <form action="">
            <div class="modal-body">                                                   
                <div class="row">
                    <div class="col-md-3">
                        <input type="number" class="form-control hidden" id="idProductoModalModo">           
                    </div>
                    <div class="col-md-3">                               
                        <input type="number" class="form-control hidden" id="idMenuCartaModalModo">                                             
                    </div>
                </div>
                <div class="row" id="modosProducto">
                    
                </div>
                <div class="row" id="descProducto">
                    
                </div>
                {{-- <div class="row">
                    <h4>Seleccione un modo para el producto</h4>
                    @foreach($modos as $modo)                                
                        <div class="col-md-4">  
                          <div class="radio">
                            <label>
                                <input id="radioModo" type="radio" name="idModo[]" value="{{$modo->id}}"> {{$modo->descripcion}}
                            </label>
                          </div>                                                       
                        </div>                                         
                    @endforeach 
                </div> --}}
            </div>
            <div class="modal-footer">                                
                <button type="button" class="btn btn-danger pull-left" data-dismiss="modal"> <i class="fas fa-undo"></i> Descartar</button>
                <button type="button" class="btn btn-success pull-right" id="addProductoBtn" onclick="seleccionarModo()"><i class="fas fa-check-circle"></i> Aceptar</button> 
            </div>
        </form>
    </div>
  </div>
</div>