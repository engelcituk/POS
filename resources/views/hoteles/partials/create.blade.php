@extends('layouts.dashboard')
@section('content')
<div class="content">
    <div class="container-fluid">
        <a href="{{ route('hoteles.index')}}" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Volver</a>
        <div class="row">
            @php 
                $hotelPermisocrear= Session::get('Hoteles.crear');                                                         
            @endphp 
            @if ($hotelPermisocrear==1)
               <form method="POST" action="{{ route('hoteles.store')}}">
                <div class="col-md-12">
                    <div class="card card-profile">
                        @csrf
                        <div class="row">
                            <div class="card-content">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">create</i>
                                        </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Nombre hotel</label>
                                            <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" required autofocus>
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
                                            <i class="material-icons">create</i>
                                        </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Empresa</label>
                                            <input type="text" class="form-control{{ $errors->has('empresa') ? ' is-invalid' : '' }}" name="empresa" required>
                                            @if ($errors->has('empresa'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('empresa') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">create</i>
                                        </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Codigo Hotel</label>
                                            <input id="codHotel" type="text" class="form-control{{$errors->has('codHotel') ? ' is-invalid' : '' }}" name="codHotel" required>
                                            @if ($errors->has('codHotel'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('codHotel') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">create</i>
                                        </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Cif hotel</label>
                                            <input id="cif" type="text"  maxlength="20" class="form-control{{$errors->has('cif') ? ' is-invalid' : '' }}" name="cif" required>
                                            @if ($errors->has('cif'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('cif') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fas fa-clock"></i>
                                        </span>
                                        <div class="form-group">                                            
                                        @if ($zonasHorarias!="")
                                            <select class="form-control" name="zonaHoraria" required>
                                                <option value="">Seleccione zona horaria</option>
                                                @foreach($zonasHorarias as $zh)
                                                <option value="{{ $zh->idZona }}">{{ $zh->nombreZona }}</option>
                                                @endforeach
                                            </select>  
                                            @else
                                                <select class="form-control" name="zonaHoraria" required>
                                                    <option value="">Aun no hay zonas horarias</option>                           
                                                </select> 
                                        @endif   
                                        </div>                                        
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary pull-right">{{ __('Guardar') }}</button>
                            </div>                                                       
                        </div>
                    </div>
                </div>
            </form> 
            @else
              <div class="card">                    
                    <div class="card-content">
                      <div class="col-md-2 text-center">
                            <p><i class="fa fa-exclamation-triangle fa-5x"></i><br/>Código: 403</p>
                      </div>
                        <div class="col-md-10">
                                <h3>Usted no cuenta con permisos para crear un hotel</h3>
                                <p>Primero tiene que tener permisos para la operación que pretende realizar<br/>Por favor solicita que se le asigne este permiso a su usuario.</p>                               
                        </div>
                    </div>                    
                </div> 
            @endif            
        </div>
    </div>
</div>
@endsection