@extends('layouts.dashboard')
@section('content')
<div class="content">
    <div class="container-fluid">
        <a href="{{ route('productos.index')}}" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Volver</a>
        <form method="POST" action="{{ route('productos.store')}}"  enctype="multipart/form-data" >
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-profile">
                        @csrf
                        <div class="row">
                            <div class="card-content">                                
                                <div class="row">
                                    @if ($categorias!="")
                                       <div class="col-md-4">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fas fa-grip-horizontal"></i>
                                            </span>
                                            <div class="form-group">
                                                <select class="form-control selectCategoria" name="idCategoria" required>
                                                    <option value="">Elija categoria del producto </option>
                                                    @foreach($categorias as $categoria)
                                                        <option value="{{$categoria->id}}">{{$categoria->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    @else 
                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fas fa-grip-horizontal"></i>
                                            </span>
                                            <div class="form-group">
                                                <select class="form-control selectCategoria" name="idCategoria" required>
                                                    <option value=""> Sin categorías registradas aun</option>      
                                                </select>
                                            </div>
                                        </div>
                                    </div>                                        
                                    @endif
                                    
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
                                                <select class="form-control" name="tipoPropina">
                                                    <option value="">Seleccione tipo de propina </option>
                                                        <option value="0">Sin propina</option>
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
                                                <input id="montoPropina" type="number" class="form-control{{ $errors->has('montoPropina') ? ' is-invalid' : '' }}" name="montoPropina">
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
                                                        <span class="fileinput-new"> <i class="fas fa-file-image"></i> Subir imagen</span>
                                                        <span class="fileinput-exists">Change</span>
                                                        <input type="file" name="imagen" id="file" onchange="return fileValidation()"/>
                                                    </span>

                                                        <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                                </div>
                                            </div>                                       
                                        </div>                           
                                        <div class="col-md-3">
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
                                        <div class="col-md-3">
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
                                        <div class="col-md-3"> 
                                            <div class="form-group">
                                                Precio Manual
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" name="temporada" value="true"> Sí
                                                    </label>
                                                    <label>
                                                        <input type="radio" name="temporada" checked="true"  value="false"> No
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
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
                                    </div>
                                    @if ($alergenos!="")
                                       <div class="row">
                                        <h4>Seleccione un alergeno si el producto tiene alergenos (opcional)</h4>
                                        @foreach($alergenos as $alergeno)                                
                                            <div class="col-md-4">
                                                <div class="checkbox checkbox-group required">                              
                                                    <label class="labelCheckbox ">
                                                    <input type="checkbox" name="idAlergeno[]" value="{{$alergeno->id}}"><strong>{{$alergeno->name}}</strong>
                                                    </label>                                            
                                                </div>
                                            </div>                                          
                                        @endforeach 
                                    </div>
                                    @else 
                                        <div class="row"><h4>Sin alergenos registrados para seleccionar</h4></div>
                                    @endif                                                          
                                    
                                    @if ($modos!="")
                                        <div class="row">
                                        <h4>Seleccione un modo y establece uno como principal (opcional)</h4>
                                        <div class="col-md-12">                                            
                                        <table class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">                  
                                            <tr id="id1" class="tr_clone">
                                                <td>
                                                    <select class="form-control listaProductos" id="templateLista" name="idModo[]">
                                                        <option value="">Elija modo</option>
                                                                @foreach($modos as $modo)
                                                        <option value="{{$modo->id}}">{{$modo->descripcion}}</option>
                                                                @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                <div class="radio">
                                                    <label>
                                                        <input id="radioP1" type="radio" name="principalRadio[]" onclick="seleccionarRadio()" checked> Principal                          
                                                        <input type="text" id="valorP1" class="hidden" name="principal[]" value="true" readonly>                                                    
                                                    </label>
                                                </div>                                                               
                                                </td>                                                     
                                                <td>
                                                    <a class='btn btn-primary btn-sm tr_clone_add'> <i class="fas fa-plus"></i></a> 
                                                    <a class='btn btn-danger btn-sm tr_clone_remove'> <i class="fas fa-remove"></i></a>
                                                    <td>
                                            </tr>
                                        </table>                                          
                                        </div>                                            
                                    </div>
                                    @else 
                                        <div class="row">                                            
                                            <h4>Sin modos registrados para seleccionar</h4>
                                        </div>
                                    @endif
                                     
                                <button type="submit" class="btn btn-primary pull-right"> <i class="fas fa-save"></i> {{ __('Guardar') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    
    $(document).ready(function() {
        $('.selectCategoria').select2();
    });
</script>
@endsection