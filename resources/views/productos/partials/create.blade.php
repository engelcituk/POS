@extends('layouts.dashboard')
@section('content')
<div class="content">
    <div class="container-fluid">
        <a href="{{ route('productos.index')}}" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Volver</a>
        <form method="POST" action="{{ route('productos.store')}}"  enctype="multipart/form-data">
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
                                                <option value="">Elija subcategoria del producto </option>
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
                                            <input id="codigoProducto" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="codigoProducto" required autofocus>
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
                                            <input id="nombreProducto" type="text" class="form-control{{ $errors->has('nombreProducto') ? ' is-invalid' : '' }}" name="nombreProducto" required autofocus>
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
                                                <option value="">Seleccione tipo de propina </option>                    
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
                                            <input id="montoPropina" type="number" class="form-control{{ $errors->has('montoPropina') ? ' is-invalid' : '' }}" name="montoPropina" required>
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
                                            <input id="precio" type="number" class="form-control{{ $errors->has('precio') ? ' is-invalid' : '' }}" name="precio" required>
                                            @if ($errors->has('precio'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('precio') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                                                
                                <div class="col-md-12 centerImg">                                   
                                    <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                        <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                            <div>
                                                <span class="btn btn-rose btn-round btn-file">
                                                    <span class="fileinput-new"> <i class="fas fa-file-image"></i> Subir icono</span>
                                                    <span class="fileinput-exists">Change</span>
                                                    <input type="file" name="imagen" id="file" onchange="return fileValidation()"/>
                                                </span>

                                                    <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                            </div>
                                        </div>                                       
                                    </div>
                                    
                                
                                <div class="col-md-4">
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
                                <div class="col-md-4">
                                    <div class="form-group">
                                        Complemento
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="complemento" value="true"> Sí
                                            </label>
                                            <label>
                                                <input type="radio" name="complemento" checked="true"  value="false"> No
                                            </label>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-4">
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
                                <h4>Seleccione un alergeno si el producto tiene alergenos</h4>
                                @foreach($alergenos as $alergeno)                                
                                    <div class="col-md-4">
	                                    <div class="checkbox checkbox-group required">                              
                                            <label class="labelCheckbox ">
                                            <input type="checkbox" name="idAlergeno[]" value="{{$alergeno->id}}"><strong>{{$alergeno->name}}</strong>
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
        </form>
    </div>
</div>

@endsection