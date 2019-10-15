<div class="modal fade" id="myModalAlergenos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header modal-header-personalizado">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"> <strong>Alergenos del producto</strong></h4>
      </div>
      <div class="modal-body">                              
        <div class="row">
          <form action="#" id="formAlergenos">
             @if ($alergenos!="")
                @foreach($alergenos as $alergeno)                                
                  <div class="col-md-4">
                      <div class="checkbox checkbox-group required">                              
                          <label class="">
                            <input type="checkbox" id="idAlergenoCheckProducto{{$alergeno->id}}" name="idAlergenoProducto[]" value="{{$alergeno->id}}" onclick="return false;">
                          <strong><span id="labelCheck{{$alergeno->id}}">{{$alergeno->name}}</span> </strong>                         
                          </label>                                            
                      </div>
                  </div>                                         
                @endforeach
             @else
              Aún no hay alergenos dados de alta                                    
             @endif            
          </form>         
        </div>            
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning pull-right" data-dismiss="modal"> <i class="fas fa-undo"></i> Descartar</button>        
      </div>
    </div>
  </div>
</div>