<div class="modal fade" id="modalShowUserPermisos" tabindex="-1" role="dialog" aria-labelledby="modalShowUserPermisosLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header modal-header-personalizado">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="modalShowUserPermisosLabel"> <strong>Agregar o quitar permisos para el usuario</strong></h4>
      </div>
      <div class="modal-body">        
        @if ($permisos!="")
        <form action="">
            <table  class="table table-bordered table-hover table-condensed">
                <thead>
                    <tr class="info">
                        <th>Permiso</th>
                        <th><i class="fas fa-plus-circle"></i></th>
                        <th><i class="fab fa-readme"></i></th>
                        <th><i class="fas fa-pen-alt"></i></th>                                        
                        <th><i class="fas fa-trash-alt"></i></th>                                        
                    </tr>
                </thead>
                <tbody>
                    @foreach($permisos as $permiso)        
                    <tr>
                        <td>
                            <div class="checkbox checkbox-group required">                              
                                <label class="labelCheckbox">
                                   <strong>{{$permiso->name}}</strong> 
                                <input type="checkbox" id="chekPermiso{{$permiso->id}}" name="permiso[]" value="{{$permiso->id}}">
                                </label>                                            
                            </div>
                        </td>
                        <td>
                            <div class="checkbox checkbox-group required">
                                <label>
                                <input type="checkbox" id="crear{{$permiso->id}}">
                                </label>                                            
                            </div>
                        </td>                                           
                        <td>
                            <div class="checkbox checkbox-group required">
                                <label>
                                <input type="checkbox" id="leer{{$permiso->id}}">
                                </label>                                            
                            </div>
                        </td>                                                         
                        <td>
                            <div class="checkbox checkbox-group required">
                                <label>
                                <input type="checkbox" id="actualizar{{$permiso->id}}">
                                </label>                                            
                            </div>
                        </td> 
                        <td>
                            <div class="checkbox checkbox-group required">
                                <label>
                                <input type="checkbox" id="borrar{{$permiso->id}}">
                                </label>                                            
                            </div>
                        </td>                      
                    </tr>
                @endforeach
                </tbody>
            </table>                                          
            
        </form>        
        @else
            No hay permisos registrados 
        @endif                                                                               
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning pull-left" data-dismiss="modal"> <i class="fas fa-undo"></i> Descartar</button>     
      </div>
    </div>
  </div>
</div>