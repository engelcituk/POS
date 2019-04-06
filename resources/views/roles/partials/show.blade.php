@extends('layouts.dashboard')
@section('content')
<div class="content">
    <div class="container-fluid">
        <a href="{{ route('roles.index') }}" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Volver</a>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-profile">
                    <div class="card-avatar">
                        <a href="#">
                            <img src="{{asset('img/default-avatar.png')}}" />
                        </a>
                    </div>
                    <div class="card-content">
                        <h6 class="card-title"><strong>Nombre Completo:</strong> {{ $role->name }}</h6>
                        <h4 class="card-title"><strong>Email:</strong> {{ $role->slug }}</h4>
                        <hr>
                        <p class="description">
                            <strong>Descripcion:</strong> {{ $role->description }}
                        </p>
                        <!-- <a href="#pablo" class="btn btn-rose btn-round">Follow</a> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection