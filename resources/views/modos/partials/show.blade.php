@extends('layouts.dashboard')
@section('content')
<div class="content">
    <div class="container-fluid">
        <a href="{{ route('modos.index') }}" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Volver</a>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-profile">
                    <div class="card-avatar">
                        <img class="img" src="{{asset('img/faces/modos.png')}}">
                    </div>
                    <div class="card-content">
                        <h3 class="category text-black"><strong>Descripción del modo:</strong> {{$modo->descripcion}}</h3><br>
                        <h4 class="card-title"><strong>Fecha Alta:</strong> {{$modo->descripcion}}</h4><br>
                        <h4 class="card-title"><strong>Hora alta:</strong>{{$modo->descripcion}}</h4><br>
                        <h4 class="card-title"><strong>Usuario alta: </strong>{{$usuario->name}}</h4><br>
                      
                        <a href="{{ route('modos.index') }}" class="btn btn-rose btn-round"><i class="fas fa-arrow-left"></i> Volver</a>
                    </div>                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection