@extends('layouts.dashboard')
@section('content')
<div class="content">
    <div class="container-fluid">
        <a href="{{ route('productos.index') }}" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Volver</a>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-profile">
                    <div class="card-avatar">
                        <img class="img" src="{{asset('img/faces/producto.png')}}">
                    </div>
                    <div class="card-content">
                        
                    <h3 class="category text-black"><strong>Nombre producto:</strong> {{$producto->nombreProducto}}</h3><br>                   <h4 class="card-title"><strong>Fecha alta: </strong> {{$producto->fechaAlta}}</h4><br>

                    <h4 class="card-title"><strong>Subcategoria: </strong> {{$subCategoria->name}}</h4><br>

                    <h4 class="card-title"><strong>De la Categoria: </strong> {{$categoria->name}}</h4><br>
                    
                    @php
                       $img = '<img class="img" src="{{asset("img/faces/producto.png")}}">';
                    //   $img =  '<input type="text" value="123" />'."\n";
                        // $imagen = ($producto->imagen == "SIN IMAGEN") ? $img : $producto->imagen ;
                        // <img class="img" src="{{asset('img/faces/default.png')}}">
                    @endphp
                        <h4 class="card-title"><strong>Imagen:  </strong> </h4><br>
                        <img src="data:image/png;base64, {{$producto->imagen}}"/>

                    <a href="{{ route('subcategorias.index') }}" class="btn btn-rose btn-round"><i class="fas fa-arrow-left"></i> Volver</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@lo