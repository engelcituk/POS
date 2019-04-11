@extends('layouts.dashboard')
@section('content')
<div class="content">
    <div class="container-fluid">
        <a href="{{ route('productos.index') }}" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Volver</a>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-profile">
                    <div class="card-avatar">
                        <a href="#">
                            <img src="{{asset('img/default-avatar.png')}}" />
                        </a>
                    </div>
                    <div class="card-content">
                        {{$producto->id}} {{$producto->nombre}} {{$producto->telefono}}
                        {{$producto->carrera}} {{$producto->direccion}}
                        <!-- <a href="#pablo" class="btn btn-rose btn-round">Follow</a> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection