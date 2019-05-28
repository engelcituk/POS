@extends('layouts.dashboard')
@section('content')
<div class="content">
    <div class="container-fluid">
        <a href="{{ route('alergenos.index') }}" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Volver</a>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-profile">
                    <div class="card-avatar">
                        <img class="img" src="{{asset('img/faces/alergia.png')}}">
                    </div>
                    <div class="card-content">                                                                                       
                    <h4 class="card-title"><strong>Nombre Alergia: </strong> {{$alergeno->name}}</h4><br>
                          
                        <h4 class="card-title"><strong>Icono: </strong> </h4><br><br><br>                        
                        <div class="card-avatar">
                            <img src="data:image/png;base64,{{$alergeno->icono}}">
                        </div>
                        
                        <a href="{{ route('alergenos.index') }}" class="btn btn-rose btn-round"><i class="fas fa-arrow-left"></i> Volver</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection