@extends('layouts.dashboard')
@section('content')
<div class="content">
    <div class="container-fluid">
        <a href="{{ route('modos.index')}}" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Volver</a>
        <form method="POST" action="{{ route('modos.actualizar')}}">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-profile">
                        @csrf
                        <input id="name" type="hidden" class="form-control" name="id" value="{{$modo->id}}" required>
                        <div class="row">
                            <div class="card-content">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="descripcion">Descripcion:</label>
                                            <textarea class="form-control" rows="1" name="descripcion"> {{$modo->descripcion}}</textarea>
                                        <span class="material-input"></span>
                                    </div>                                                                      
                                </div>
                                {{-- <small>En la api se registra el <cite title="idPuntoVenta">fechaAlta/horaAlta</cite></small> --}}
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