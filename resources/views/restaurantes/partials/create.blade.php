@extends('layouts.dashboard')
@section('content')
<div class="content">
    <div class="container-fluid">
        <a href="{{ route('restaurantes.index')}}" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Volver</a>
        <form method="POST" action="{{ route('restaurantes.store')}}">
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
                                            <label class="control-label">Nombre Restaurante</label>
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
                                            <i class="fas fa-h-square"></i>
                                        </span>
                                        <div class="form-group">
                                            <!-- <label for="sel1">Select list:</label> -->
                                            <select class="form-control" name="idHotel" required>
                                                <option value="">Seleccione hotel</option>
                                                @foreach($hoteles as $hotel)
                                                <option value="{{ $hotel->id }}">{{ $hotel->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fas fa-file-signature"></i>
                                        </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">homoclave</label>
                                            <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="homoclave" required autofocus>
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
                                            <i class="fas fa-print"></i>
                                        </span>
                                        <div class="form-group">
                                            <!-- <label for="sel1">Select list:</label> -->
                                            <select class="form-control" name="idImpresora" required>
                                                <option value="">Seleccione impresora</option>
                                                @foreach($impresoras as $impresora)
                                                <option value="{{ $impresora->id }}">{{$impresora->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>                                
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fas fa-key"></i>
                                        </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">codCP</label>
                                            <input id="codCP" type="text" class="form-control{{ $errors->has('codCP') ? ' is-invalid' : '' }}" name="codCP" required>
                                            @if ($errors->has('codCP'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('codCP') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fas fa-dollar-sign"></i>
                                        </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Moneda</label>
                                            <input id="moneda" type="text" class="form-control{{ $errors->has('moneda') ? ' is-invalid' : '' }}" name="moneda" required>
                                            @if ($errors->has('moneda'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('moneda') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fas fa-dollar-sign"></i>
                                        </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Símbolo Moneda</label>
                                            <input id="simboloM" type="text" class="form-control{{ $errors->has('simboloM') ? ' is-invalid' : '' }}" name="simboloM" required>
                                            @if ($errors->has('simboloM'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('simboloM') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="comment">Descripcion:</label>
                                        <textarea class="form-control" rows="2" name="descripcion" required></textarea>
                                    </div>
                                </div>
                                <!-- <small>En la api se registar el <cite title="idHotel">idHotel</cite></small> -->
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