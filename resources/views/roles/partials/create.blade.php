@extends('layouts.dashboard')
@section('content')
<div class="content">
    <div class="container-fluid">
        <a href="{{ route('roles.index')}}" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Volver</a>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-profile">

                    <form method="POST" action="{{ route('roles.store')}}">
                        @csrf
                        <div class="card-content">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">create</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Nombre Rol</label>
                                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" required autofocus>
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
                                    <label class="control-label">URL Amigable</label>
                                    <input id="slug" type="text" class="form-control{{ $errors->has('slug') ? ' is-invalid' : '' }}" name="slug" required autofocus>
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
                                    <div class="form-group">
                                        <label for="comment">Descripción:</label>
                                        <textarea class="form-control" name="description" value="" required rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                            <!-- <hr> -->
                            <h4 class="card-title">Permiso Especial</h4>
                            <label class="radio-inline"><input type="radio" name="special" value=all-access>Acceso total</label>
                            <label class="radio-inline"><input type="radio" name="special" value=no-access>Ningún acceso</label>
                            <br><br>
                            <h4 class="card-title">Asignar roles al permiso</h4>
                            @foreach($permisos as $permiso)
                            <div class="col-md-4">
                                <div class="checkbox"> 
                                    <label>
                                        <input type="checkbox" name="permissions[]" value="{{$permiso->id}}" <strong>{{$permiso->name}}</strong>
                                    </label>
                                </div>
                            </div>
                            @endforeach
                            <br>
                            <button type="submit" class="btn btn-primary pull-right">{{ __('Guardar Cambios') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection