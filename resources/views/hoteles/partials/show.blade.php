@extends('layouts.dashboard')
@section('content')
<div class="content">
    <div class="container-fluid">
        <a href="{{ route('hoteles.index') }}" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Volver</a>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-profile">
                    <div class="card-avatar">
                        <img class="img" src="{{asset('img/faces/hotel.png')}}">
                    </div>
                    <div class="card-content">
                        <h3 class="category text-black">Nombre del hotel: {{$hotel->name}}</h3><br>
                        <h4 class="card-title">Empresa: {{$hotel->empresa}}</h4><br>
                        <h4 class="card-title">Codigo de Hotel:  {{$hotel->codHotel}}</h4>
                        <a href="{{ route('hoteles.index') }}" class="btn btn-rose btn-round"><i class="fas fa-arrow-left"></i> Volver</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection