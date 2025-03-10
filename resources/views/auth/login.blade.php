@extends('layouts.app')

@section('content')
<div class="full-page login-page" filter-color="black" data-image="{{asset('img/login.jpg')}}">
    <!--   you can change the color of the filter page using: data-color="blue | purple | green | orange | red | rose " -->
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-sm-6 col-md-offset-4 col-sm-offset-3">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                          
                         @if ($hoteles != "")
                            <div class="card card-login card-hidden">
                                <div class="card-header text-center" data-background-color="blue">
                                    <h4 class="card-title">Inicio de sesión</h4>                                
                                </div>                            
                            <div class="card-content">                                
                                <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fas fa-h-square"></i>
                                        </span>
                                        <div class="form-group">                                            
                                            <select class="form-control" id="idHotel" name="idHotel" onchange="eligeHotel()" required>
                                                <option value="">Seleccione hotel</option>
                                                @foreach($hoteles as $hotel)
                                                <option value="{{ $hotel->id }}">{{ $hotel->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                </div>                                
                                <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fas fa-utensils"></i>
                                        </span>
                                        <div class="form-group">                                            
                                            <select class="form-control" name="listaPuntosVenta" id="listaPuntosVenta"  onchange="obtenerCartasPV()" required>
                                              <option value="">Seleccione punto de venta</option>
                                          </select>
                                        </div>
                                </div>
                                <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fas fa-bars"></i>
                                        </span>
                                        <div class="form-group">                                            
                                            <select class="form-control" name="listaCartas" id="listaCartas" required>
                                              <option value="">Seleccione carta</option>
                                          </select>
                                        </div>
                                </div>

                                <p class="category text-center">
                                    Ingrese sus datos de acceso
                                </p>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fas fa-user"></i>
                                    </span>
                                    <div class="form-group label-floating">
                                        <label class="control-label">Nombre de usuario</label>
                                        <input id="email" type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="usuario" value="{{ old('email') }}" required autofocus>
                                        @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <div class="form-group label-floating">
                                        <label class="control-label">Password</label>
                                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                                        @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>                                                                
                            </div>
                            <div class="footer text-center">
                                <!-- <button type="submit" class="btn btn-primary btn-simple btn-wd btn-lg">Let's go</button> -->
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-sign-in-alt"></i> {{ __('Ingresar') }}
                                </button>
                            </div>
                        </div>
                         @else
                         <div class="card card-login card-hidden">
                                <div class="card-header text-center" data-background-color="red">
                                    <h4 class="card-title">Inicio de sesión</h4>                                
                                </div>                            
                                <div class="card-content">  
                                    <h6 class="card-title">Falta configurar el catalogo de hoteles</h6>                                

                                    <p class="category text-justify">
                                        El login se habilitará hasta que se haya terminado de dar de alta el catalogo de hoteles, productos,cartas.. etc                               
                                    </p>                                                                                                
                                </div>                            
                        </div>                            
                         @endif                        
                    </form>
                </div>
            </div>
        </div>
    </div>
    <footer class="footer">
        {{-- <div class="container">            
            <p class="copyright pull-right">
                &copy;
                <script>
                    document.write(new Date().getFullYear())
                </script>
                <a href="#">Ecituk</a>, the best TPV from the web
            </p>
        </div> --}}
    </footer>
</div>
<script>
$(document).ready(function() {
    $('#idHotel').select2();
    $('#listaPuntosVenta').select2();
    $('#listaCartas').select2();
});
</script>
@endsection 