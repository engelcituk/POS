@extends('layouts.dashboard')
@section('content')
<div class="content">
    <div class="container-fluid">
        <a href="{{ route('roles.index')}}" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Volver</a>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-profile">
                    <div class="card-avatar">
                        <a href="#">
                            <img src="{{asset('img/default-avatar.png')}}" />
                        </a>
                    </div>
                    <form method="POST" action="{{ route('roles.update',['usuario' => $role])}}">
                        @method('PUT')
                        @csrf
                        <div class="card-content">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">create</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Nombre Rol</label>
                                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ $role->name }}" required autofocus>
                                    @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">create</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Slug</label>
                                    <input id="slug" type="text" class="form-control{{ $errors->has('slug') ? ' is-invalid' : '' }}" name="slug" value="{{ $role->slug }}" required autofocus>
                                    @if ($errors->has('slug'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('slug') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">create</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Descripción</label>
                                    <input id="description" type="text" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description" value="{{ $role->description }}" required autofocus>
                                    @if ($errors->has('description'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <!-- <hr> -->
                            <h4 class="card-title">Asignar roles al permiso</h4>
                            @foreach($permisos as $permiso)
                            <div class="col-md-6">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="permisos[]" value="{{$permiso->id}}" > <strong>{{$permiso->name}}</strong>
                                    </label>
                                </div>
                            </div>
                            @endforeach
                            <br><br>
                            <button type="submit" class="btn btn-primary">{{ __('Guardar Cambios') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection