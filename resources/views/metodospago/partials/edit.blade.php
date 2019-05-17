@extends('layouts.dashboard')
@section('content')
<div class="content">
    <div class="container-fluid">
        <a href="{{ route('metodospago.index')}}" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Volver</a>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-profile">

                    <form method="POST" action="{{ route('metodospago.actualizar')}}">
                        @csrf
                        {{ method_field('PUT') }}
                        <input id="name" type="hidden" class="form-control" name="id" value="{{$metodoPago->id}}" required>
                        <div class="card-content">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fas fa-money-bill"></i>
                                    </span>
                                    <div class="form-group label-floating">
                                        <label class="control-label">Nombre metodo de pago</label>
                                        <input id="name" type="text" class="form-control" name="name" value="{{$metodoPago->name}}" required autofocus>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fas fa-file-signature"></i>
                                    </span>
                                    <div class="form-group label-floating">
                                        <label class="control-label">Descripción</label>
                                        <input id="descripcion" type="text" class="form-control" name="descripcion" value="{{$metodoPago->descripcion}}" required>

                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary pull-right"> <i class="fas fa-save"></i> {{ __('Guardar') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection