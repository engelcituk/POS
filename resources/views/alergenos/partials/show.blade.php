@extends('layouts.dashboard')
@section('content')
<div class="content">
    <div class="container-fluid">
        @php
            $alergenoPermisoLeer= Session::get('Alergenos.leer'); 
        @endphp
        <a href="{{ route('alergenos.index') }}" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Volver</a>
        <div class="row">
            <div class="col-md-12">
                @php
                    $imgAlergeno =$alergeno->icono;
                    $imgDefault=asset('img/faces/defaultAlergeno.png'); //Esto es para la imagen por default
                    // $dataimg = "data:image/png;base64,";                       
                    // $imgBase64 = $dataimg.$imgAlergeno;                                        
                    $resultadoImg = (($imgAlergeno == "SIN IMAGEN") || ($imgAlergeno == NULL)) ? $imgDefault : asset('storage/alergenos/'.$imgAlergeno);                        
                @endphp
                @if ($alergenoPermisoLeer==1)
                    <div class="card card-profile">
                        <div class="card-avatar">
                            <img class="img" src="{{$resultadoImg}}"/> 
                        </div>
                            <div class="card-content">     
                            <h4 class="card-title"><strong>Nombre Alergia: </strong> {{$alergeno->name}}</h4><br>                       <a href="{{ route('alergenos.index') }}" class="btn btn-rose btn-round"><i class="fas fa-arrow-left"></i> Volver</a>
                        </div>
                    </div>
                @else
                    <div class="card">                    
                            <div class="card-content">
                                <div class="col-md-2 text-center">
                                    <p><i class="fa fa-exclamation-triangle fa-5x"></i><br/>Código: 403</p>
                                </div>
                                <div class="col-md-10">
                                        <h3>Usted no tiene permiso para ver un alergeno</h3>
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