@extends('layouts.dashboard')
@section('content')
<div class="content">
    <div class="container-fluid">
        <a href="{{ route('subcategorias.index')}}" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Volver</a>
        <form method="POST" action="{{ route('subcategorias.store')}}">
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
                                        <div class="form-group">
                                            <select class="form-control" name="idCategoria" required>
                                                <option value="">Seleccione categoria</option>
                                                @foreach($categorias as $categoria)
                                                    <option value="{{$categoria->id }}">{{ $categoria->name }}</option>
                                                  @endforeach                      
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fab fa-elementor"></i>
                                        </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Nombre de la subcategoria</label>
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
                                           <i class="fas fa-user"></i>
                                        </span>
                                        <div class="form-group">
                                            <select class="form-control" name="idUsuarioAlta" required>
                                                <option value="">Seleccione usuario</option>
                                                @foreach($users as $user)
                                                    <option value="{{$user->id }}">{{ $user->name }}</option>
                                                  @endforeach                      
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group label-floating">
                                            <label class="control-label">orden</label>
                                            <input id="ordenCategoria" type="number" class="form-control{{ $errors->has('orden') ? ' is-invalid' : '' }}" name="orden" required autofocus>
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
@endsection