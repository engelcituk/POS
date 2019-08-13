@extends('layouts.dashboard')
@section('content')
<div class="content">
    <div class="container-fluid">
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
                <div class="card card-profile">
                    <div class="card-avatar">
                         <img class="img" src="{{$resultadoImg}}"/> 
                    </div>
                    <div class="card-content">                                                                                       
                    <h4 class="card-title"><strong>Nombre Alergia: </strong> {{$alergeno->name}}</h4><br>                                                                                                
                        <a href="{{ route('alergenos.index') }}" class="btn btn-rose btn-round"><i class="fas fa-arrow-left"></i> Volver</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection