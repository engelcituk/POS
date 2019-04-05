@extends('layouts.dashboard')
@section('content')
<div class="content">
    <div class="container-fluid">
        <a href="{{ route('usuarios.index') }}" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Volver</a>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-profile">
                    <div class="card-avatar">
                        <a href="#">
                            <img src="{{asset('img/default-avatar.png')}}" />
                        </a>
                    </div>
                    <div class="card-content">
                        <h6 class="card-title"><strong>Nombre Completo:</strong> {{ $usuario->name }}</h6>
                        <h4 class="card-title"><strong>Email:</strong> {{ $usuario->email }}</h4>
                        <hr>
                        <p class="description">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima quos dolor, omnis harum neque dignissimos laborum magni culpa tempora. Consequatur, officia quod fugiat quo quis quam reprehenderit distinctio accusamus a.
                        </p>
                        <!-- <a href="#pablo" class="btn btn-rose btn-round">Follow</a> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection