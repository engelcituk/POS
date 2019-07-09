@extends('layouts.dashboard')
@section('content')
<div class="content">
    <div class="container-fluid">
        <a href="{{ route('categorias.index') }}" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Volver</a>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-profile">
                    @php
                        $imgAlergeno =$categoria->imagen;
                        $imgDefault=asset('img/faces/defaultAlergeno.png'); //Esto es para la imagen por default
                        $dataimg = "data:image/png;base64,";                       
                        $imgBase64 = $dataimg.$imgAlergeno;                                        
                        $resultadoImg = (($imgAlergeno == "AA==") || ($imgAlergeno == NULL)) ? $imgDefault : $imgBase64;      
                    @endphp
                    <div class="card-avatar">
                        <img class="img" src="{{$resultadoImg}}"/> 
                    </div>
                    <div class="card-content">                        
                        <h3 class="category text-black"><strong>Nombre categoria:</strong> {{$categoria->name}}</h3><br>                  
                        <h4 class="card-title"><strong>Fecha alta categoria: </strong> {{$categoria->fechaAlta}}</h4><br>
                        <h4 class="card-title"><strong>Creado por: </strong> {{$usuario->name}}</h4><br>                        
                        <a href="{{ route('categorias.index') }}" class="btn btn-rose btn-round"><i class="fas fa-arrow-left"></i> Volver</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection