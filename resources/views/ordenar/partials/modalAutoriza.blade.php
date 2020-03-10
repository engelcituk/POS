<div class="modal fade" id="modalAutoriza" tabindex="-1" role="dialog" aria-labelledby="modalAutorizaLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header modal-header-personalizado">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="modalAutorizaLabel"> <strong>Autorice cobro</strong></h4>
      </div>      
      <div class="modal-body">  
        <form id="formAutoriza">
          <div class="input-group">
            <span class="input-group-addon">
                <i class="fas fa-user"></i>
            </span>
            <div class="form-group label-floating">
                <label class="control-label">Nombre de usuario</label>
                <input id="usuarioModal" type="text" class="form-control{{ $errors->has('usuario') ? ' is-invalid' : '' }}" name="usuario" value="{{ old('usuario') }}" required autofocus>
                @if ($errors->has('usuario'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('usuario') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="input-group">
            <span class="input-group-addon">
                <i class="fas fa-lock"></i>
            </span>
            <div class="form-group label-floating">
                <label class="control-label">Password</label>
                <input id="passwordModal" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                @if ($errors->has('password'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
                @endif
            </div>
        </div>
        </form>        
      </div>           
      <div class="modal-footer">
        <button type="button" class="btn btn-warning pull-left" data-dismiss="modal"> <i class="fas fa-arrow-left"></i> Volver </button>
        <button type="button" class="btn btn-primary" onclick="autorizarCobro()"><i class="fas fa-dollar-sign"></i> Cobrar</button>        
      </div>
    </div>
  </div>
</div>