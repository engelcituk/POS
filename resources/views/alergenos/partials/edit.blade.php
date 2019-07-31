@extends('layouts.dashboard')
@section('content')
<div class="content">
    <div class="container-fluid">
        <a href="{{ route('alergenos.index')}}" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Volver</a>
        <form method="POST" action="{{ route('alergenos.actualizar')}}" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-12">
                    @php
                        $imgAlergeno =$alergeno->icono;
                    $imgDefault=asset('img/faces/defaultAlergeno.png'); //Esto es para la imagen por default
                    // $dataimg = "data:image/png;base64,";                       
                    // $imgBase64 = $dataimg.$imgAlergeno;                                        
                    $resultadoImg = (($imgAlergeno == "SIN IMAGEN") || ($imgAlergeno == NULL)) ? $imgDefault : "/storage/alergenos/".$imgAlergeno; 
                    @endphp
                    <div class="card card-profile">
                        <div class="card-avatar">
                                <img class="img" src="{{$resultadoImg}}"/> 
                        </div>
                        @csrf
                        {{-- {{ method_field('PUT') }} --}}
                        <input id="name" type="hidden"  class="form-control" name="id" value="{{$alergeno->id}}" required>
                        <div class="row">                            
                            <div class="card-content">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fas fa-code"></i>
                                        </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Nombre del alergeno</label>
                                        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{$alergeno->name}}" required autofocus>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
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
                                                        <span class="fileinput-new"> <i class="fas fa-file-image"></i> Cambiar Icono</span>
                                                        <span class="fileinput-exists">Change</span>
                                                        <input type="file" id="icono" name="icono" onchange="return fileValidation()"/>
                                                    </span>
                                                    <a href="#" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- <small>En la api se registra el <cite title="idPuntoVenta">fechaAlta/horaAlta/idReceta/status </cite></small> --}}
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
function fileValidation(){
    var fileInput = document.getElementById('icono');
    var filePath = fileInput.value;
    var allowedExtensions = /(.png)$/i;

    if(!allowedExtensions.exec(filePath)){
        if (fileInput.value != ''){
            $.notify({	
                message: '<i class="fas fa-sun"></i><strong>Nota:</strong> No se ha podigo cargar la imagen:'+filePath+', favor de seleccionar solo formato: <strong>png</strong>' 
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