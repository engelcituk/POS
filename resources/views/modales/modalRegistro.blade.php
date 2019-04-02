<div id="modalRegistro" class="modal fade" role="dialog">
    <form id="formUsuario">
        {{ csrf_field() }} {{ method_field('POST') }}
        <input type="hidden" id="id" name="id">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header modal-header-personalizado">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <div class="card-content">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="material-icons">face</i>
                            </span>
                            <div class="form-group is-empty">
                                <input type="text" class="form-control" name="nombreCompleto" placeholder="Nombre completo...">
                                <span class="material-input"></span>
                            </div>
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="material-icons">email</i>
                            </span>
                            <div class="form-group is-empty">
                                <input type="email" class="form-control" name="email" placeholder="Email...">
                                <span class="material-input"></span>
                            </div>
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="material-icons">lock_outline</i>
                            </span>
                            <div class="form-group is-empty">
                                <input type="password" name="password" placeholder="Contraseña..." class="form-control"><span class="material-input"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning pull-left" data-dismiss="modal"><i class="fas fa-window-close"></i> Cerrar</button>
                    <button type="submit" class="btn btn-fill btn-primary pull-right" id="btnRegistrar"></button>
                </div>
    </form>
</div> 