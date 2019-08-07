@extends('layouts.dashboard')
@section('content')
<div class="content">
    <div class="container-fluid">
        <a href="{{ route('categorias.index')}}" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Volver</a>
        <form method="POST" action="{{ route('categorias.actualizar')}}" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-12"> 
                    <div class="card card-profile">
                        
                         @php
                            $imgCategoria =$categoria->imagen;
                            $imgDefault=asset('img/faces/defaultAlergeno.png'); //Esto es para la imagen por default                    
                            $resultadoImg = (($imgCategoria == "SIN IMAGEN") || ($imgCategoria == NULL)) ? $imgDefault : "/sandostpv/storage/categorias/".$imgCategoria;    
                        @endphp
                        <div class="card-avatar">
                                <img class="img" src="{{$resultadoImg}}"/> 
                        </div>
                        @csrf                        
                        {{-- {{ method_field('PUT') }} --}}
                        <input id="name" type="hidden" class="form-control" name="id" value="{{$categoria->id}}" required>
                        <input id="name"  class="form-control hidden" name="imagenValor" value="{{$categoria->imagen}}">
                        <div class="row">
                            <div class="card-content">
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fab fa-elementor"></i>
                                        </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Nombre de la categoria</label>
                                        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{$categoria->name}}" required autofocus>
                                            @if ($errors->has('name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 hidden">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fab fa-elementor"></i>
                                        </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Usuario</label>
                                            <input id="idUsuarioAlta" type="text" class="form-control" name="idUsuarioAlta" value="{{Session::get('idUsuarioLogueado')}}" required readonly>
                                           
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group label-floating">
                                        <label class="control-label">orden</label>
                                        <input id="ordenCategoria" type="number" class="form-control{{ $errors->has('orden') ? ' is-invalid' : '' }}" name="orden" value="{{$categoria->orden}}" required >
                                        @if ($errors->has('orden'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('orden') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div> 
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fas fa-file-image"></i>
                                        </span>
                                        <div class="form-group">                                            
                                            <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                                <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                                {{-- <img src="data:image/png;base64,{{$alergeno->icono}}"> --}}
                                                <div>
                                                    <span class="btn btn-rose btn-round btn-file">
                                                        <span class="fileinput-new"> <i class="fas fa-file-image"></i> Cambiar imagen</span>
                                                        <span class="fileinput-exists">Change</span>
                                                        <input type="file" id="imagen" name="imagen" onchange="return fileValidation()"/>
                                                    </span>
                                                    <a href="#" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>                               
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
      // validao img
function fileValidation(){
    var fileInput = document.getElementById('imagen');
    var filePath = fileInput.value;
    var allowedExtensions = /(.jpg|.jpeg|.png|.gif)$/i;
    

    if(!allowedExtensions.exec(filePath)){
        if (fileInput.value != ''){
            $.notify({	
                message: '<i class="fas fa-sun"></i><strong>Nota:</strong> No se ha podigo cargar la imagen:'+filePath+', favor de seleccionar solo formatos para:<trong> IMAGENES</strong>' 
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