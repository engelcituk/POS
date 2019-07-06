@extends('layouts.dashboard')
@section('content')
<div class="content">
    <div class="container-fluid">
        <a href="{{ route('categorias.index')}}" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Volver</a>
        <form method="POST" action="{{ route('categorias.store')}}">
            <div class="row">
                <div class="col-md-12"> 
                    <div class="card card-profile">
                        @csrf
                        <div class="row">
                            <div class="card-content">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fab fa-elementor"></i>
                                        </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Nombre de la categoria</label>
                                            <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" required autofocus>
                                            @if ($errors->has('name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 hidden">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fab fa-elementor"></i>
                                        </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Usuario</label>
                                            <input id="idUsuarioAlta" type="text" class="form-control{{ $errors->has('idUsuario') ? ' is-invalid' : '' }}" name="idUsuarioAlta" value="{{Session::get('idUsuarioLogueado')}}" required readonly>
                                           
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group label-floating">
                                            <label class="control-label">orden</label>
                                            <input id="ordenCategoria" type="number" class="form-control{{ $errors->has('orden') ? ' is-invalid' : '' }}" name="orden" required>
                                            @if ($errors->has('orden'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('orden') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                </div>                                
                                <button type="submit" class="btn btn-primary pull-right"> <i class="fas fa-save"></i> {{ __('Guardar') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('.selectUsuarios').select2();
    });
</script>
@endsection