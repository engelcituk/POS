@extends('layouts.dashboard')
@section('content')
<div class="content">
    <div class="container-fluid">
        <a href="{{ route('menuscartas.index')}}" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Volver</a>
        <div class="row">
                <div class="col-md-12">
                    <div class="card card-profile">
                        @csrf
                        <div class="row">
                            <div class="card-content">                                
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fas fa-grip-horizontal"></i>
                                        </span>
                                        <div class="form-group">
                                            <select class="form-control" name="idSubCategoria" required>
                                                <option value="">Elija carta</option>
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
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fas fa-file-signature"></i>
                                        </span>
                                        <div class="form-group">
                                            <select class="form-control" name="tipoPropina" required>
                                                <option value="">Seleccione producto </option>                    
                                                    <option value="1">Porcentaje</option>
                                                    <option value="2">Dinero</option>         
                                                </optgroup>                                        
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fas fa-file-signature"></i>
                                        </span>
                                        <div class="form-group">
                                            <select class="form-control" name="tipoPropina" required>
                                                <option value="">Seleccione centro de preparación </option>                    
                                                    <option value="1">Porcentaje</option>
                                                    <option value="2">Dinero</option>         
                                                </optgroup>                                        
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fas fa-code"></i>
                                        </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Precio</label>
                                            <input id="codigoProducto" type="number" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="codigoProducto" required autofocus>
                                            @if ($errors->has('codigoProducto'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('codigoProducto') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>                                 
                                <button type="submit" class="btn btn-primary pull-right"> <i class="fas fa-save"></i> {{ __('Guardar') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                
    </div>
</div>

@endsection