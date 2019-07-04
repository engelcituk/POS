@extends('layouts.dashboard')
@section('content')
<div class="content">
    <div class="container-fluid">
        <a href="{{ route('productos.index') }}" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Volver</a>
        <div class="row">
            <div class="col-md-12">
                @php
                    $imgProducto =$producto->imagen;
                    $img =asset('img/faces/defaultProducto.png'); //Esto es para la imagen por default
                    $dataimg = "data:image/png;base64,";                       
                    $imgconfoto = $dataimg.$imgProducto;                                        
                    $resultadoImg = (($imgProducto == "AA==") || ($imgProducto == NULL)) ? $img : $imgconfoto;    
                @endphp
                <div class="card card-profile">
                    <div class="card-avatar">
                        <img class="img" src="{{$resultadoImg}}"/>                                                        
                    </div>
                    <div class="card-content">                        
                        <h3 class="category text-black"><strong>Nombre producto:</strong> {{$producto->nombreProducto}}</h3><br>  <h4 class="card-title"><strong>Fecha alta: </strong> {{$producto->fechaAlta}}</h4><br>
                        <h4 class="card-title"><strong>De la Categoria: </strong> {{$categoria->name}}</h4><br>                         
                    </div>
                    <a href="{{ route('productos.index') }}" class="btn btn-rose btn-round"><i class="fas fa-arrow-left"></i> Volver</a>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection()