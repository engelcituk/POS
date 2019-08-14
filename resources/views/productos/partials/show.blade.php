@extends('layouts.dashboard')
@section('content')
<div class="content">
    <div class="container-fluid">
        @php
            $productoPermisoLeer= Session::get('Productos.leer');                       
        @endphp
        <a href="{{ route('productos.index') }}" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Volver</a>
        <div class="row">
            <div class="col-md-12">                
                @php
                    $imgProducto =$producto->imagen;
                    $imgDefault=asset('img/faces/defaultProducto.png'); //Esto es para la imagen por default                    
                    $resultadoImg = (($imgProducto == "SIN IMAGEN") || ($imgProducto == NULL)) ? $imgDefault : asset('storage/productos/'.$imgProducto);                                        
                @endphp
                @if ($productoPermisoLeer==1)
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
                @else
                    <div class="card">                    
                        <div class="card-content">
                            <div class="col-md-2 text-center">
                                <p><i class="fa fa-exclamation-triangle fa-5x"></i><br/>Código: 403</p>
                            </div>
                            <div class="col-md-10">
                                    <h3>Usted no tiene permiso para ver un producto</h3>
                                    <p>Primero tiene que tener permisos para la operación que pretende realizar<br/>Por favor solicita que se le asigne este permiso a su usuario.</p>                               
                            </div>
                        </div>                    
                    </div>
                @endif                
            </div>
        </div>
    </div>
</div>
@endsection()