@extends('layouts.dashboard')
@section('content')
<div class="content">
    <div class="container-fluid">
        <a href="{{ route('productos.index')}}" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Volver</a>
        <div class="row">
                <div class="col-md-12">
                    <div class="card card-profile">
                        @csrf
                        <div class="row">
                            <div class="card-content">                                
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fas fa-grip-horizontal"></i>
                                        </span>
                                        <div class="form-group">
                                            <select class="form-control" name="idSubCategoria" required>
                                                <option value="{{$subCategoria->id}}">{{$subCategoria->name}}</option>
                                                @foreach($categorias as $categoria)
                                                <optgroup label="{{$categoria->name}}">
                                                    @foreach($subcategorias as $subcategoria)
                                                    @php
                                                        $collection = collect(['idCategoria' => $subcategoria->idCategoria, 'idCategoria' => $categoria->id]);
                                                        $respuesta = $collection->contains($subcategoria->idCategoria);
                                                    @endphp
                                                        @if($respuesta==1)
                                                        <option value="{{$subcategoria->id}}">{{$subcategoria->name}}</option>
                                                    @endif 
                                                    @endforeach
                                                </optgroup>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fas fa-code"></i>
                                        </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Codigo producto</label>
                                        <input id="codigoProducto" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="codigoProducto" required value="{{$producto->codigoProducto}}">
                                            @if ($errors->has('codigoProducto'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('codigoProducto') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fas fa-file-signature"></i>
                                        </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Nombre producto</label>
                                            <input id="nombreProducto" type="text" class="form-control{{ $errors->has('nombreProducto') ? ' is-invalid' : '' }}" name="nombreProducto" required value="{{$producto->nombreProducto}}">
                                            @if ($errors->has('nombreProducto'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('nombreProducto') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>                                
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fas fa-file-signature"></i>
                                        </span>
                                        <div class="form-group">
                                            <select class="form-control" name="tipoPropina" required>
                                                <option value="{{$producto->tipoPropina}}">Tipo propina </option>                    
                                                    <option value="1">Porcentaje</option>
                                                    <option value="2">Dinero</option>         
                                                </optgroup>                                        
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fab fa-gratipay"></i>
                                        </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Monto propina</label>
                                            <input id="montoPropina" type="number" class="form-control{{ $errors->has('montoPropina') ? ' is-invalid' : '' }}" name="montoPropina" required value="{{$producto->montoPropina}}">
                                            @if ($errors->has('montoPropina'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('montoPropina') }}</strong>
                                            </span>
                                            @endif
                                        </div> 
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fas fa-money-bill-alt"></i>
                                        </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Precio</label>
                                            <input id="precio" type="number" class="form-control{{ $errors->has('precio') ? ' is-invalid' : '' }}" name="precio" required  value="{{$producto->precio}}">
                                            @if ($errors->has('precio'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('precio') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        Con propina
                                        <div class="radio">
                                            @php
                                            $estado= $producto->propina;//para obtener si tiene propina
                                            $radios = ($estado == 1) ?
                                            "<label><input type='radio' name='propina' value='True' checked>Activado</label>
                                            <label><input type='radio' name='propina' value='False'>Desactivado</label>" :
                                            "<label><input type='radio' name='propina' value='True'>Activado</label>
                                            <label><input type='radio' name='propina' value='False' checked>Desactivado</label>";
                                            echo $radios;
                                            @endphp
                                        </div>

                                    </div>
                                </div>                               
                                <div class="col-md-4">
                                    <div class="form-group">
                                        Complemento
                                        <div class="radio">
                                            @php
                                            $estado= $producto->complemento;//para obtener si tiene complemento
                                            $radios = ($estado == 1) ?
                                            "<label><input type='radio' name='complemento' value='True' checked>Activado</label>
                                            <label><input type='radio' name='complemento' value='False'>Desactivado</label>" :
                                            "<label><input type='radio' name='complemento' value='True'>Activado</label>
                                            <label><input type='radio' name='complemento' value='False' checked>Desactivado</label>";
                                            echo $radios;
                                            @endphp
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        Estado
                                        <div class="radio">
                                           @php
                                            $estado= $producto->status;//para obtener si tiene status
                                            $radios = ($estado == 1) ?
                                            "<label><input type='radio' name='status' value='True' checked>Activado</label>
                                            <label><input type='radio' name='status' value='False'>Desactivado</label>" :
                                            "<label><input type='radio' name='status' value='True'>Activado</label>
                                            <label><input type='radio' name='status' value='False' checked>Desactivado</label>";
                                            echo $radios;
                                            @endphp
                                        </div>
                                    </div>
                                </div>

                                <h4>Seleccione un alergeno si el producto tiene alergenos</h4>
                                @foreach($alergenos as $alergeno)
                                {{-- @php                                	
                                    $resultado = $idPermisosRolColeccion->contains($permisoItem->id);
                                    $checked = ($resultado == 1) ? "checked" : "";
                                @endphp                               --}}
                                    <div class="col-md-4">
	                                    <div class="checkbox checkbox-group required">                              
                                            <label class="labelCheckbox ">
                                            <input type="checkbox" name="idAlergeno[]"><strong>{{$alergeno->name}}</strong>
                                            </label>                                            
                                        </div>
                                    </div>                                         
                                @endforeach 
                                <button type="submit" class="btn btn-primary pull-right"> <i class="fas fa-save"></i> {{ __('Guardar') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>
@endsection