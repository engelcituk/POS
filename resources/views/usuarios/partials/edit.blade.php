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
                        <h4 class="card-title">Editar usuario || modificar datos</h4>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="material-icons">create</i>
                            </span>
                            <div class="form-group label-floating">
                                <label class="control-label">Nombre Completo</label>
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ $usuario->name }}" required autofocus>
                                @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="material-icons">email</i>
                            </span>
                            <div class="form-group label-floating">
                                <label class="control-label">Email address</label>
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $usuario->email }}" required autofocus>
                                @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="material-icons">lock_outline</i>
                            </span>
                            <div class="form-group label-floating">
                                <label class="control-label">Password</label>
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password">
                                @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="footer text-center">
                        <!-- <button type="submit" class="btn btn-primary btn-simple btn-wd btn-lg">Let's go</button> -->
                        <button type="submit" class="btn btn-primary">
                            {{ __('Guardar') }}
                        </button>
                    </div>
                    <!-- <a href="#pablo" class="btn btn-rose btn-round">Follow</a> -->
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection