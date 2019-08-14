@extends('layouts.dashboard')
@section('content')
<div class="content">
    <div class="container-fluid">
         @php                                                                    
            $categoriaPermisoLeer= Session::get('Categorias.leer');                          
        @endphp
        <a href="{{ route('categorias.index') }}" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Volver</a>
        <div class="row">
            <div class="col-md-12">
                @if ($categoriaPermisoLeer==1)
                    <div class="card card-profile">                    
                        @php
                            $imgCategoria =$categoria->imagen;
                            $imgDefault=asset('img/faces/defaultAlergeno.png'); //Esto es para la imagen por default                    
                            $resultadoImg = (($imgCategoria == "SIN IMAGEN") || ($imgCategoria == NULL)) ? $imgDefault : asset('storage/categorias/'.$imgCategoria);    
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
                @else
                    <div class="card">                    
                        <div class="card-content">
                            <div class="col-md-2 text-center">
                                <p><i class="fa fa-exclamation-triangle fa-5x"></i><br/>Código: 403</p>
                            </div>
                            <div class="col-md-10">
                                    <h3>Usted no tiene permiso para ver una categoria</h3>
                                    <p>Primero tiene que tener permisos para la operación que pretende realizar<br/>Por favor solicita que se le asigne este permiso a su usuario.</p>                               
                            </div>
                        </div>                    
                    </div>
                @endif
                
            </div>
        </div>
    </div>
</div>
@endsection