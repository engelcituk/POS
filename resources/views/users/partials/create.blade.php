@extends('layouts.dashboard')
@section('content')
<div class="content">
    <div class="container-fluid">
        <a href="{{ route('users.index')}}" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Volver</a>
        <form method="POST" action="{{ route('users.store')}}">
            <div class="row">
                    <div class="col-md-12">
                        <div class="card card-profile">
                            @csrf
                            <div class="row">
                                <div class="card-content">
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fas fa-file-signature"></i>
                                            </span>
                                            <div class="form-group label-floating">
                                                <label class="control-label">Nombre Completo</label>
                                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" required autofocus>
                                                @if ($errors->has('name'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('name') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fas fa-user-edit"></i>
                                            </span>
                                            <div class="form-group label-floating">
                                                <label class="control-label">Nombre de usuario</label>
                                                <input id="usuario" type="text" class="form-control{{ $errors->has('usuario') ? ' is-invalid' : '' }}" name="usuario" required>
                                                @if ($errors->has('usuario'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('usuario') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fas fa-key"></i>
                                            </span>
                                            <div class="form-group label-floating">
                                                <label class="control-label">Contraseña</label>
                                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" password="password" required autofocus>
                                                @if ($errors->has('password'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fas fa-user-cog"></i>
                                            </span>
                                            <div class="form-group">
                                                <!-- <label for="sel1">Select list:</label> -->
                                                <select class="form-control" id="sel1">
                                                    <option>Seleccione un rol</option>
                                                    <option>Admin</option>
                                                    <option>Admin</option>
                                                    <option>Admin</option>
                                                    <option>Admin</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <small>En la api se requiere registar el <cite title="idUsuarioAlta y la fechaalta">idRol y la fechaAlta</cite></small>
                                    <button type="submit" class="btn btn-primary pull-right">{{ __('Guardar') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </form>
    </div>
</div>

@endsection