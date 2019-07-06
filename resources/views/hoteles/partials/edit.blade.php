@extends('layouts.dashboard')
@section('content')
<div class="content">
    <div class="container-fluid">
        <a href="{{ route('hoteles.index')}}" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Volver</a>
        <div class="row">
            <form method="POST" action="{{ route('hoteles.actualizar')}}">
                <div class="col-md-12">
                    <div class="card card-profile">
                        @csrf
                        {{-- {{ method_field('PUT') }} --}}
                        <input id="name" type="hidden"  class="form-control" name="id" value="{{$hotel->id}}" required>
                        <div class="form-group label-floating">
                            <div class="row">
                                <div class="card-content">
                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">create</i>
                                            </span>
                                            <div class="form-group label-floating">
                                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{$hotel->name}}" required autofocus>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">create</i>
                                            </span>
                                            <div class="form-group label-floating">
                                                <input id="direccion" type="text" class="form-control{{ $errors->has('empresa') ? ' is-invalid' : '' }}" name="empresa" value="{{$hotel->empresa}}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">create</i>
                                        </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Codigo Hotel</label>
                                            <input id="codHotel" type="text" class="form-control{{$errors->has('codHotel') ? ' is-invalid' : '' }}" name="codHotel"  value="{{$hotel->codHotel}}" required>
                                           
                                        </div>
                                    </div>
                                </div>
                                    <button type="submit" class="btn btn-primary pull-right">{{ __('Guardar') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
            </form>
        </div>
    </div>
</div>
@endsection