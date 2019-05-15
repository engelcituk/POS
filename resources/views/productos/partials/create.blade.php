@extends('layouts.dashboard')
@section('content')
<div class="content">
    <div class="container-fluid">
        <a href="{{ route('productos.index')}}" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Volver</a>
        <form method="POST" action="{{ route('productos.store')}}">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-profile">
                        @csrf
                        <div class="row">
                            <div class="card-content">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fas fa-code"></i>
                                        </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Codigo producto</label>
                                            <input id="codigoProducto" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="codigoProducto" required autofocus>
                                            @if ($errors->has('codigoProducto'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('codigoProducto') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fas fa-grip-horizontal"></i>
                                        </span>
                                        <div class="form-group">
                                            <!-- <label for="sel1">Select list:</label> -->
                                            <select class="form-control" id="sel1">
                                                <option>Seleccione Subcategoria</option>
                                                <option>Subcategoria 1</option>
                                                <option>Subcategoria 2</option>
                                                <option>Subcategoria 3</option>
                                                <option>Subcategoria 4</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fas fa-file-signature"></i>
                                        </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Nombre producto</label>
                                            <input id="nombreProducto" type="text" class="form-control{{ $errors->has('nombreProducto') ? ' is-invalid' : '' }}" name="nombreProducto" required autofocus>
                                            @if ($errors->has('nombreProducto'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('nombreProducto') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        Con propina
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="propina" checked="true" value="true"> Sí
                                            </label>
                                            <label>
                                                <input type="radio" name="propina" value="false"> No
                                            </label>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fas fa-file-signature"></i>
                                        </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Tipo propina</label>
                                            <input id="tipoPropina" type="text" class="form-control{{ $errors->has('tipoPropina') ? ' is-invalid' : '' }}" name="tipoPropina" required autofocus>
                                            @if ($errors->has('tipoPropina'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('tipoPropina') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fab fa-gratipay"></i>
                                        </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Monto propina</label>
                                            <input id="montoPropina" type="text" class="form-control{{ $errors->has('montoPropina') ? ' is-invalid' : '' }}" name="montoPropina" required autofocus>
                                            @if ($errors->has('montoPropina'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('montoPropina') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fas fa-money-bill-alt"></i>
                                        </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Precio</label>
                                            <input id="precio" type="text" class="form-control{{ $errors->has('precio') ? ' is-invalid' : '' }}" name="precio" required autofocus>
                                            @if ($errors->has('precio'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('precio') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fas fa-grip-horizontal"></i>
                                        </span>
                                        <div class="form-group">
                                            <!-- <label for="sel1">Select list:</label> -->
                                            <select class="form-control" id="receta">
                                                <option>Seleccione receta</option>
                                                <option>receta 1</option>
                                                <option>receta 2</option>
                                                <option>receta 3</option>
                                                <option>receta 4</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        Complemento
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="complemento" checked="true" value="true"> Sí
                                            </label>
                                            <label>
                                                <input type="radio" name="complemento" value="false"> No
                                            </label>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        Estado
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="status" checked="true" value="true">Activo
                                            </label>
                                            <label>
                                                <input type="radio" name="status" value="false">Desactivado
                                            </label>
                                        </div>

                                    </div>
                                </div>

                                <small>En la api se registra el <cite title="idPuntoVenta">fechaAlta/horaAlta/idReceta/status </cite></small>
                                <button type="submit" class="btn btn-primary pull-right"> <i class="fas fa-save"></i> {{ __('Guardar') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection