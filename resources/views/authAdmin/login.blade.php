@extends('layouts.app')

@section('content')img/login.jpg
<div class="full-page login-page" filter-color="black" data-image="{{asset('img/login.jpg')}}">
    <!--   you can change the color of the filter page using: data-color="blue | purple | green | orange | red | rose " -->
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-sm-6 col-md-offset-4 col-sm-offset-3">
                    <form method="POST" action="{{ route('login') }}" >
                        @csrf
                        <div class="card card-login card-hidden">
                            <div class="card-header text-center" data-background-color="blue">
                                <h4 class="card-title">Inicio de sesión ADMIN</h4>                                
                            </div>                            
                            <div class="card-content">                                        
                                <p class="category text-center">
                                    Ingrese sus datos de acceso
                                </p>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fas fa-user"></i>
                                    </span>
                                    <div class="form-group label-floating">
                                        <label class="control-label">Nombre de usuario</label>
                                        <input type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="usuario" id="usuarioAdmin" value="{{ old('email') }}" required autofocus onchange="verificaSiEsAdmin()">
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
                                <!-- <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">check_circle</i>
                                    </span>
                                    <div class="form-group label-floating">         
                                        @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                        @endif
                                    </div>
                                </div> -->
                            </div>
                            <div class="footer text-center">
                                <!-- <button type="submit" class="btn btn-primary btn-simple btn-wd btn-lg">Let's go</button> -->
                                <button type="submit" id="btnIngresoAdmin" class="btn btn-primary" disabled>
                                    <i class="fas fa-sign-in-alt"></i> {{ __('Ingresar') }}
                                </button>
                            </div>
                        </div>
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
@endsection 