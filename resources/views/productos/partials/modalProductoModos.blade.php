<div id="myModalModos" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header modal-header-personalizado">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title ">Agrega o quita modos de preparacion para el producto</h4>
      </div>
       <form action="">
            <div class="modal-body">
                <input type="text" class="form-control" id="idProductoModo">   
                <table id="productos" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                    <thead>
                        <tr>
                            <th>Descripcion</th>   
                            <th>Añadir</th>                          
                            <th class="disabled-sorting text-right">Volver principal</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        @foreach($modos as $modo)                                            
                            <tr>
                                <td>{{$modo->descripcion}}</td>                                
                                <td>
                                    <div class="checkbox checkbox-group required">                              
                                        <label class="labelCheckbox ">
                                        <input type="checkbox" id="checkModo{{$modo->id}}" name="idModo[]" value="{{$modo->id}}" onclick="seleccionarCheckModo({{$modo->id}})">
                                        </label>                                            
                                    </div>                                    
                                </td>
                                <td>                                    
                                    <label>
                                        <input id="radioModo{{$modo->id}}" type="radio" name="principalRadio[]" onclick="seleccionarRadioModo({{$modo->id}})" value="{{$modo->id}}"> Principal                          
                                        <input type="text" id="inputPrincipalModo{{$modo->id}}" class="hidden" name="principal[]" value="true" readonly> 
                                    </label>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
       </form>      
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>