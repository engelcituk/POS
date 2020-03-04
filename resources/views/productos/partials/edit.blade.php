@extends('layouts.dashboard')
@section('content')
<div class="content">
    <div class="container-fluid">
        @php 
            $productoPermisoActualizar= Session::get('Productos.actualizar'); 
        @endphp
        <a href="{{ route('productos.index')}}" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Volver</a>
        @if ($productoPermisoActualizar==1)
            <form method="POST" action="{{ route('productos.actualizar')}}" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-12">                                                         
                    @php
                        $imgProducto =$producto->imagen;
                        $imgDefault=asset('img/faces/defaultProducto.png'); //Esto es para la imagen por default                    
                        $resultadoImg = (($imgProducto == "SIN IMAGEN") || ($imgProducto == NULL)) ? $imgDefault : asset('storage/productos/'.$imgProducto);    
                    @endphp
                    <div class="row">
                        <div class="card card-profile">
                            <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                <div class="fileinput-preview fileinput-exists thumbnail"></div>     
                                <div>
                                    <span class="btn btn-rose btn-round btn-file">
                                        <span class="fileinput-new"> <i class="fas fa-file-image"></i> Cambiar imagen</span>
                                        <span class="fileinput-exists">Change</span>
                                        <input type="file" id="imagenP" name="imagen" onchange="return fileValidation()"/>
                                    </span>
                                    <a href="#" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                </div>
                            </div>                               
                            <div class="card-avatar">
                                <img class="img" src="{{$resultadoImg}}"/>                                                        
                            </div>
                            @csrf
                            <input id="name" type="hidden" class="form-control" name="id" value="{{$producto->id}}" required>
                            <input id="nombreImg" class="form-control hidden" name="nombreImg" value="{{$producto->imagen}}">
                            <div class="row">
                                <div class="card-content">                                                                     
                                    <div class="row">
                                        <div class="col-md-3">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fas fa-grip-horizontal"></i>
                                            </span>
                                            <div class="form-group">
                                                <select class="form-control listaCategoriaEdit" name="idCategoria" required>
                                                <option value="{{$categoriaProducto->id}}">{{$categoriaProducto->name}}</option>
                                                    @foreach($categorias as $categoria)
                                                        <option value="{{$categoria->id}}">{{$categoria->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fas fa-code"></i>
                                            </span>
                                            <div class="form-group label-floating">
                                                <label class="control-label">Codigo producto </label>
                                            <input id="codigoProducto" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" maxlength="20" name="codigoProducto" required value="{{$producto->codigoProducto}}">
                                                @if ($errors->has('codigoProducto'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('codigoProducto') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
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
                                    <div class="col-md-3">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fas fa-file-signature"></i>
                                            </span>
                                            <div class="form-group">
                                                @php
                                                    $valorTipoPropina=$producto->tipoPropina;
                                                    if($valorTipoPropina==1){
                                                       $texto="Porcentaje";
                                                   }elseif ($valorTipoPropina==2) {                                                    
                                                       $texto="Dinero";
                                                    }
                                                @endphp
                                                <select class="form-control" name="tipoPropina" required>
                                                <option value="{{$producto->tipoPropina}}">{{$texto}}</option>                 
                                                        <option value="1">Porcentaje</option>
                                                        <option value="2">Dinero</option>        
                                                    </optgroup>                                        
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fab fa-gratipay"></i>
                                            </span>
                                            <div class="form-group label-floating">
                                                <label class="control-label">Monto propina</label>
                                                <input id="montoPropina" type="number" step="0.01" class="form-control{{ $errors->has('montoPropina') ? ' is-invalid' : '' }}" name="montoPropina" value="{{$producto->montoPropina}}">
                                                @if ($errors->has('montoPropina'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('montoPropina') }}</strong>
                                                </span>
                                                @endif
                                            </div> 
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fas fa-money-bill-alt"></i>
                                            </span>
                                            <div class="form-group label-floating">
                                                <label class="control-label">Precio</label>
                                                <input id="precio" type="number" step="0.01" class="form-control{{ $errors->has('precio') ? ' is-invalid' : '' }}" name="precio" required  value="{{$producto->precio}}">
                                                @if ($errors->has('precio'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('precio') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fas fa-money-bill-alt"></i>
                                            </span>
                                            <div class="form-group label-floating">
                                                <label class="control-label">Precio todo incluido</label>
                                                <input id="precioTI" type="number" step="0.01" class="form-control{{ $errors->has('precioTI') ? ' is-invalid' : '' }}" name="precioTI" required  value="{{$producto->precioTI}}">
                                                @if ($errors->has('precioTI'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('precioTI') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @if ($centrosP!="")
                                       <div class="col-md-3">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fas fa-grip-horizontal"></i>
                                            </span>
                                            <div class="form-group">
                                                <label class="control-label">Centro productivo </label>
                                                <select class="form-control listaCategoriaEdit" name="idCentroProd" required>
                                                    <option value="">Elija centro productivo para el producto </option>
                                                    @foreach($centrosP as $cp)
                                                        <option value="{{ $cp->id }}" {{ old('idCentroProd',$producto->idCentroProd ) == $cp->id ? 'selected': '' }}>{{ $cp->codigo }}</option>  
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    @else 
                                    <div class="col-md-3">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fas fa-grip-horizontal"></i>
                                            </span>
                                            <div class="form-group">
                                                <select class="form-control listaCategoriaEdit" name="idCentroProd" required>
                                                    <option value=""> Sin centros productivos registrados aun</option>      
                                                </select>
                                            </div>
                                        </div>
                                    </div>                                        
                                    @endif                                                                         
                                </div> 
                                <div class="row">
                                  <div class="col-md-3">
                                        <div class="form-group">
                                            Con propina
                                            <div class="radio">
                                                @php
                                                $estado= $producto->propina;//para obtener si tiene propina
                                                $radios = ($estado == 1) ?
                                                "<label><input type='radio' name='propina' value='True' checked>SI</label>
                                                <label><input type='radio' name='propina' value='False'>NO</label>" :
                                                "<label><input type='radio' name='propina' value='True'>SI</label>
                                                <label><input type='radio' name='propina' value='False' checked>No</label>";
                                                echo $radios;
                                                @endphp
                                            </div>

                                        </div>
                                    </div>                               
                                    <div class="col-md-3">
                                        <div class="form-group">
                                           Complemento
                                            <div class="radio">
                                                @php
                                                $estado= $producto->complemento;//para obtener si tiene complemento
                                                $radios = ($estado == 1) ?
                                                "<label><input type='radio' name='complemento' value='True' checked>Si</label>
                                                <label><input type='radio' name='complemento' value='False'>No</label>" :
                                                "<label><input type='radio' name='complemento' value='True'>Si</label>
                                                <label><input type='radio' name='complemento' value='False' checked>No</label>";
                                                echo $radios;
                                                @endphp
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            Precio manual
                                            <div class="radio">
                                                @php
                                                $temporada= $producto->temporada;//para obtener si tiene status
                                                $radios = ($temporada == 1) ?
                                                "<label><input type='radio' name='temporada' value='True' checked>Si</label>
                                                <label><input type='radio' name='temporada' value='False'>No</label>" :
                                                "<label><input type='radio' name='temporada' value='True'>Si</label>
                                                <label><input type='radio' name='temporada' value='False' checked>No</label>";
                                                echo $radios;
                                                @endphp
                                            </div>
                                        </div>
                                    </div>                               
                                    <div class="col-md-3">
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
                                </div>                                      
                                <div class="row">
                                    <h4>Seleccione un alergeno si el producto tiene alergenos</h4>
                                    @foreach($alergenos as $alergeno)
                                    @php    
                                                                    
                                        $resultado = $idAlergenosColeccion->contains($alergeno->id);
                                        $checked = ($resultado == 1) ? "checked" : "";
                                        $idProducto =$producto->id;
                                        $idAlergeno = $alergeno->id;
                                        $nombreAlergeno=$alergeno->name;
                                        $nombreProducto=$producto->nombreProducto;
                                    @endphp                              
                                        <div class="col-md-3">
                                            <div class="checkbox checkbox-group required">                              
                                                <label class="labelCheckbox ">
                                                <input type="checkbox" nombreProducto={{$nombreProducto}} nombreAlergeno="{{$nombreAlergeno}}" name="idAlergeno[]" id="checkAlergeno{{$idAlergeno}}" idProducto="{{$idProducto}}" value="{{$idAlergeno}}" {{$checked}} onclick="AddDeleteProductoAlergeno({{$idAlergeno}})"><strong>{{$nombreAlergeno}}</strong>
                                                </label>                                            
                                            </div>
                                        </div>                                         
                                    @endforeach 
                                </div>                                 
                                <button type="submit" class="btn btn-primary pull-right"> <i class="fas fa-save"></i> {{ __('Guardar') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form> 
        @else
            <div class="card">                    
                <div class="card-content">
                    <div class="col-md-2 text-center">
                        <p><i class="fa fa-exclamation-triangle fa-5x"></i><br/>Código: 403</p>
                    </div>
                    <div class="col-md-10">
                            <h3>Usted no tiene permiso para editar un producto</h3>
                            <p>Primero tiene que tener permisos para la operación que pretende realizar<br/>Por favor solicita que se le asigne este permiso a su usuario.</p>                               
                    </div>
                </div>                    
            </div>
        @endif               
    </div>
</div>
<script>
    function AddDeleteProductoAlergeno(idAlergeno){
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        var idProducto = $("#checkAlergeno"+idAlergeno).attr("idProducto");
        var nombreAlergeno = $("#checkAlergeno"+idAlergeno).attr("nombreAlergeno");
        var nombreProducto = $("#checkAlergeno"+idAlergeno).attr("nombreProducto");
        
        valorCheck=$("#checkAlergeno"+idAlergeno).prop("checked");//obtengo true o false
        // console.log("idProducto "+idProducto+" idAlergeno "+idAlergeno+" Valorcheck "+valorCheck);        

        if(valorCheck) {    
            $.ajax({
                url: "{{ url('productos') }}"+'/'+idProducto+'/'+idAlergeno,
                type: "POST",
                data: {
                    '_method': 'POST',
                    '_token': csrf_token
                },
                success: function(respuesta) {
                    $.notify({							
                        message: '<i class="fas fa-sun"></i><strong>Nota:</strong> Se ha registrado alergeno: <strong>'+nombreAlergeno+' para el producto '+nombreProducto+' con id: '+idProducto 
                        },{								
                            type: 'info',
                            delay: 5000
                        });                    
                },
                error: function() {
                   $.notify({							
                        message: '<i class="fas fa-sun"></i><strong>Nota:</strong> Ocurrió un error al hacerse la petición'
                        },{								
                            type: 'danger',
                            delay: 5000
                        });
                }
            }); 
        }else{
            $.ajax({
                url: "{{ url('borrar') }}"+'/'+idProducto+'/'+idAlergeno,
                type: "POST",
                data: {
                    '_method': 'POST',
                    '_token': csrf_token
                },
                success: function(respuesta) {                    
                    $.notify({							
                        message: '<i class="fas fa-sun"></i><strong>Nota:</strong> Se ha borrado el alergeno: <strong>'+nombreAlergeno+' para el producto '+nombreProducto+' con id: '+idProducto 
                        },{								
                            type: 'warning',
                            delay: 5000
                        });
                },
                error: function(respuesta) {
                   $.notify({							
                        message: '<i class="fas fa-sun"></i><strong>Nota:</strong> Ocurrió un error al hacerse la petición'+respuesta
                        },{								
                            type: 'danger',
                            delay: 5000
                        });
                }
            });
        }
    }
    $(document).ready(function() {
        $('.listaCategoriaEdit').select2();
    });
    // validao img
    function fileValidation(){
    var fileInput = document.getElementById('imagenP');
    var filePath = fileInput.value;
    var allowedExtensions = /(.jpg|.jpeg|.png|.gif)$/i;
    

    if(!allowedExtensions.exec(filePath)){
        if (fileInput.value != ''){
            $.notify({	
                message: '<i class="fas fa-sun"></i><strong>Nota:</strong> No se ha podigo cargar la imagen:'+filePath+', favor de seleccionar solo formato:<trong>png</strong>' 
                },{	
                    type: 'danger',
                    delay: 5000
                });

        }
        fileInput.value = '';
        return false;
    }else{
    //Image preview
        if (fileInput.files && fileInput.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('imagePreview').innerHTML = '<img src="'+e.target.result+'"/>';
        };
        reader.readAsDataURL(fileInput.files[0]);
        }
    }
}
</script>
@endsection