<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('img/apple-icon.png')}}" />
    <link rel="icon" type="image/png" href="{{asset('img/favicon.png')}}" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Administrador</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

    <!-- Bootstrap core CSS     -->
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet" />
    <!--  Material Dashboard CSS    -->
    <link href="{{asset('css/material-dashboard.css')}}" rel="stylesheet" />    
    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="{{asset('css/demo.css')}}" rel="stylesheet" />
    {{-- estilos swtiches --}}
    <link href="{{asset('css/carousel.css')}}" rel="stylesheet"/>
    <link href="{{asset('css/owl.carousel.min.css')}}" rel="stylesheet"/>
    {{-- <link href="{{asset('css/owl.theme.min.css')}}" rel="stylesheet"/> --}}
    <link href="{{asset('css/estilo.css')}}" rel="stylesheet"/>

    <!--     Fonts and icons     -->
    <link href="{{asset('css/font-awesome.css')}}" rel="stylesheet" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link href="{{asset('css/google-roboto-300-700.css')}}" rel="stylesheet" />
    <link href="{{asset('css/select2.min.css')}}" rel="stylesheet"/>
    <script src="{{asset('js/jquery-3.1.1.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/bootstrap.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/select2.min.js')}}"></script>
    <script src="{{asset('js/bootstrap-timepicker.js')}}"></script> 
    <script src="{{asset('js/MultiCarousel.js')}}"></script>   
    <script src="{{asset('js/scriptSlider.js')}}"></script>
    <script src="{{asset('js/slider.js')}}"></script>
    
    
</head>

<body>       
    <div class="wrapper">
        <div class="sidebar" data-active-color="rose" data-background-color="black" data-image="{{asset('img/sidebar-1.jpg')}}">
              <div class="logo">
                <a href="#" class="simple-text">
                    SANDOS TPV
                </a>
            </div>
            <div class="logo logo-mini">
                <a href="#" class="simple-text">
                    S T
                </a>
            </div>
            <div class="sidebar-wrapper">
                <div class="user">
                    <div class="photo">
                        <img src="{{asset('img/faces/avatar.jpg')}}" />
                    </div>
                    <div class="info">
                        <a data-toggle="collapse" href="#collapseExample" class="collapsed">
                            @if(Session::has('UsuarioLogueado'))
                                {{Session::get('UsuarioLogueado')}}-
                                {{Session::get('idUsuarioLogueado')}}-
                                {{Session::get('idPuntoVenta')}} 
                            @endif
                            {{-- <b class="caret"></b> --}}
                        </a>
                        
                    </div>
                </div>
                <ul class="nav">
                    
                    <li>
                        @if(session()->has('accesoOrden') || session()->has('accesoHistorico'))
                            <a data-toggle="collapse" href="#pagesExamples">
                                <i class="fas fa-cart-plus"></i>
                                <p>Operaciones
                                    <b class="caret"></b>
                                </p>
                            </a>
                        @endif
                        
                        <div class="collapse" id="pagesExamples">
                            <ul class="nav">
                                 @if(session()->has('accesoOrden'))
                                    <li class="">
                                        <a href="{{ route('ordenar.index') }}">Tomar orden</a>
                                    </li>
                                 @endif                                                                                                
                                @if(session()->has('accesoHistorico'))
                                    <li>
                                        <a href="{{ route('historico.index')}}">Historico</a>
                                    </li>
                                @endif
                                
                            </ul>
                        </div>
                    </li>

                    <!--  -->
                    <li>
                        {{-- @if(session()->has('accesoHoteles')|| session()->has('accesoRoles')||session()->has('accesoUsuarios')||session()->has('accesoPuntosVenta')||session()->has('accesoImpresoras')||session()->has('accesoCentrosPreparacion')||session()->has('accesoTurnos')||session()->has('accesoZonas')||session()->has('accesoMesas')||session()->has('accesoCartas')||session()->has('accesoCategorias')||session()->has('accesoProductos')||session()->has('accesoMenusCarta')||session()->has('accesoMetodosPago')||session()->has('accesoModos')||session()->has('accesoAlergenos')) --}}
                            <a data-toggle="collapse" href="#componentsExamples">
                                <i class="fas fa-cogs"></i>
                                <p>Configuración
                                    <b class="caret"></b>
                                </p>
                            </a>        
                        {{-- @endif                          --}}
                        <div class="collapse" id="componentsExamples">
                            <ul class="nav">
                                {{-- @if(session()->has('accesoHoteles')) --}}
                                    <li>
                                        <a href="{{ route('hoteles.index') }}">Hoteles</a>
                                    </li>
                                {{-- @endif                                 --}}
                                {{-- @if(session()->has('accesoRoles')) --}}
                                    <li>
                                        <a href="{{ route('rolesapi.index') }}">Roles</a>
                                    </li>
                                {{-- @endif --}}
                                {{-- @if(session()->has('accesoUsuarios')) --}}
                                    <li>
                                        <a href="{{ route('users.index') }}">Usuarios</a>
                                    </li>
                                {{-- @endif --}}
                                {{-- @if(session()->has('accesoPuntosVenta')) --}}
                                    <li>
                                        <a href="{{ route('restaurantes.index') }}">Puntos de venta</a>
                                    </li>
                                {{-- @endif --}}
                                 {{-- @if(session()->has('accesoImpresoras')) --}}
                                    <li>
                                        <a href="{{ route('impresoras.index') }}">Impresoras</a>
                                    </li>
                                {{-- @endif --}}
                                 {{-- @if(session()->has('accesoCentrosPreparacion')) --}}
                                    <li>
                                        <a href="{{ route('centrospreparacion.index') }}">Centros de preparación</a>
                                    </li>
                                {{-- @endif --}}
                                 {{-- @if(session()->has('accesoTurnos')) --}}
                                    <li>
                                        <a href="{{ route('turnos.index') }}">Turnos PV</a>
                                    </li>
                                {{-- @endif --}}
                                 {{-- @if(session()->has('accesoZonas')) --}}
                                    <li>
                                        <a href="{{ route('zonas.index') }}">Zonas</a>
                                    </li>
                                {{-- @endif --}}
                                {{-- @if(session()->has('accesoMesas')) --}}
                                    <li>
                                        <a href="{{ route('mesas.index') }}">Mesas</a>
                                    </li>
                                {{-- @endif  --}}
                                {{-- @if(session()->has('accesoCartas')) --}}
                                    <li>                               
                                        <a href="{{ route('cartas.index') }}">Cartas</a>
                                    </li>
                                {{-- @endif  --}}
                                {{-- @if(session()->has('accesoCategorias')) --}}
                                    <li>                        
                                        <a href="{{ route('categorias.index') }}">Categorias</a>
                                    </li>
                                {{-- @endif  --}}
                                {{-- @if(session()->has('accesoProductos')) --}}
                                    <li>
                                        <a href="{{ route('productos.index') }}">Productos</a>
                                    </li>
                                {{-- @endif  --}}
                                {{-- @if(session()->has('accesoMenusCarta')) --}}
                                    <li>
                                        <a href="{{ route('menuscartas.index') }}">Menús cartas</a>
                                    </li>
                                {{-- @endif  --}}
                                {{-- @if(session()->has('accesoMetodosPago')) --}}
                                    <li>
                                        <a href="{{ route('metodospago.index') }}">Métodos de pago</a>
                                    </li>
                                {{-- @endif  --}}
                                {{-- @if(session()->has('accesoModos')) --}}
                                    <li>
                                        <a href="{{ route('modos.index') }}">Modos</a>
                                    </li>
                                {{-- @endif --}}
                                {{-- @if(session()->has('accesoAlergenos')) --}}
                                    <li>
                                        <a href="{{ route('alergenos.index') }}">Alergénos</a>
                                    </li>
                                {{-- @endif --}}                                                               
                            </ul>
                        </div>
                    </li>                    
                </ul>
            </div>
        </div>
        <div class="main-panel">
            <nav class="navbar navbar-transparent navbar-absolute">
                <div class="container-fluid">
                    <div class="navbar-minimize">
                        <button id="minimizeSidebar" class="btn btn-round btn-white btn-fill btn-just-icon">                            
                            <i class="fas fa-ellipsis-v visible-on-sidebar-regular"></i> 
                            <i class="fas fa-bars visible-on-sidebar-mini"></i>                                                      
                        </button>
                    </div>
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        {{-- <a class="navbar-brand" href="#"> PanelControl </a> --}}                        
                    </div>
                    @if(request()->is('ordenar'))        
                        <div class="col-md-3">
                            <nav aria-label="breadcrumb" role="navigation">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </span>
                                    <div class="form-group">                               
                                        <select class="form-control" id="zonaElige">                             
                                        @foreach($zonas as $zona)
                                        <option value="zona{{$zona->id}}">{{$zona->name}}</option>
                                        @endforeach                                
                                        </select>
                                    </div>
                                </div>
                            </nav>                                                
                        </div>                                                                              
                    @endif
                    
                    <div class="collapse navbar-collapse">
                        <ul class="nav navbar-nav navbar-right">                                                        
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fas fa-user"></i>
                                    <!-- <span class="notification">5</span> -->
                                    <p class="hidden-lg hidden-md">
                                        Opciones
                                        <b class="caret"></b>
                                    </p>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item btn btn-danger" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"> <i class="fas fa-sign-out-alt"></i>
                                            {{ __('Salir') }}
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                            {{-- <button class="btn btn-danger btn-xs"> Cerrar sesion</button>  --}}
                                        </form>

                                    </li>
                                </ul>

                            </li>
                            <li class="separator hidden-lg hidden-md"></li>
                        </ul>                        
                    </div>
                </div>
            </nav>
            @yield('content')
            
        </div>
    </div>
    <script src="{{asset('sweetalert/dist/sweetalert.min.js')}}" type="text/javascript"></script>
    @include('sweet::alert')
</body>
<!--   Core JS Files   -->

<script src="{{asset('js/jquery-ui.min.js')}}" type="text/javascript"></script>

<script src="{{asset('js/material.min.js')}}" type="text/javascript"></script>
<script src="{{asset('js/perfect-scrollbar.jquery.min.js')}}" type="text/javascript"></script>
<!-- Forms Validations Plugin -->
<script src="{{asset('js/jquery.validate.min.js')}}"></script>
<script src="{{asset('js/validator.min.js') }}"></script>
<!--  Plugin for Date Time Picker and Full Calendar Plugin-->
<script src="{{asset('js/moment.min.js')}}"></script>
<!--  Charts Plugin -->
<!-- <script src="{{asset('js/chartist.min.js')}}"></script> -->
<!--  Plugin for the Wizard -->
<script src="{{asset('js/jquery.bootstrap-wizard.js')}}"></script>
<!--  Notifications Plugin    -->
<script src="{{asset('js/bootstrap-notify.js')}}"></script>
<!--   Sharrre Library    -->
<script src="{{asset('js/jquery.sharrre.js')}}"></script>
<!-- DateTimePicker Plugin -->
<script src="{{asset('js/bootstrap-datetimepicker.js')}}"></script>
<!-- Vector Map plugin -->
<!-- <script src="{{asset('js/jquery-jvectormap.js')}}"></script> -->
<!-- Sliders Plugin -->
<script src="{{asset('js/nouislider.min.js')}}"></script>
<!--  Google Maps Plugin    -->
<!--<script src="{{asset('')}}js/jquery.select-bootstrap.js"></script>-->
<!-- Select Plugin -->
<script src="{{asset('js/jquery.select-bootstrap.js')}}"></script>
<!--  DataTables.net Plugin    -->
<script src="{{asset('js/jquery.datatables.js')}}"></script>
<!-- Sweet Alert 2 plugin -->
<script src="{{asset('js/sweetalert2.js')}}"></script>
<!--	Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
<script src="{{asset('js/jasny-bootstrap.min.js')}}"></script>
<!--  Full Calendar Plugin    -->
<script src="{{asset('js/fullcalendar.min.js')}}"></script>
<!-- TagsInput Plugin -->
<script src="{{asset('js/jquery.tagsinput.js')}}"></script>
<!-- Material Dashboard javascript methods -->
<script src="{{asset('js/material-dashboard.js')}}"></script>
{{-- para alertas de notificaciones --}}
<script src="{{asset('js/bootstrap-notify.min.js')}}"></script>

<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<!-- <script src="{{asset('js/demo.js')}}"></script> -->
<!-- <script src="{{asset('js/init.js')}}"></script> -->
<script src="{{asset('js/datatables.js')}}"></script>
<script src="{{asset('js/owl.carousel.min.js')}}"></script>



<!-- <script src="{{asset('js/crudUsuarios.js')}}"></script> -->
<!-- Mirrored from demos.creative-tim.com/material-dashboard-pro/examples/dashboard.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 20 Mar 2017 21:32:16 GMT -->
@include('scriptjs/ticketRecibo')
@if(request()->is('ordenar'))
    @include('scriptjs/orden')
    {{-- <script src="{{asset('js/scriptCarousel.js')}}"></script> --}}
    
@endif
@if(request()->is('historico'))
    @include('scriptjs/historico')
    @include('scriptjs/datatables/datatableHistorico')
    @include('scriptjs/validacionesHistorico') {{--validaciones  --}}
@endif
@if(request()->is('hoteles')) 
    @include('scriptjs/datatables/datatableHoteles')
    @include('scriptjs/sweetalerts/sweetalertHotel')
@endif
@if(request()->is('rolesapi')) 
    @include('scriptjs/datatables/datatableRoles')
    @include('scriptjs/sweetalerts/sweetalertRol')
    @include('scriptjs/permisosRol')
    @include('scriptjs/validacionesRoles')
@endif
@if(request()->is('users')) 
    @include('scriptjs/datatables/datatableUsuarios')
    @include('scriptjs/sweetalerts/sweetalertUsuario') 
    @include('scriptjs/permisosRolUsuario')
@endif
@if(request()->is('restaurantes'))
    @include('scriptjs/datatables/datatablePVRestaurantes')
    @include('scriptjs/sweetalerts/sweetalertRestaurante') 
@endif
@if(request()->is('impresoras')) 
    @include('scriptjs/datatables/datatableImpresoras')
    @include('scriptjs/sweetalerts/sweetalertImpresora') 
    @include('scriptjs/validacionesImpresoras')
@endif
@if(request()->is('impresoras/create'))      
    @include('scriptjs/validacionesImpresoras')

@endif
@if(request()->is('centrospreparacion'))
    @include('scriptjs/datatables/datatableCentrosPrep')
    @include('scriptjs/sweetalerts/sweetalertCentroPreparacion') 
@endif
@if(request()->is('turnos'))
    @include('scriptjs/datatables/datatableTurnosPV')
    @include('scriptjs/sweetalerts/sweetalertTurno')     
@endif
@if(request()->is('turnos/create'))     
    @include('scriptjs/validacionesTurnos') {{--validaciones  --}}
@endif

@if(request()->is('zonas'))
    @include('scriptjs/datatables/datatableZonas')
    @include('scriptjs/sweetalerts/sweetalertZona')
@endif
@if(request()->is('mesas')) 
    @include('scriptjs/datatables/datatableMesas')
    @include('scriptjs/sweetalerts/sweetalertMesa')
@endif
@if(request()->is('cartas'))
    @include('scriptjs/datatables/datatableCartas')
    @include('scriptjs/sweetalerts/sweetalertCarta')
    {{-- @include('scriptjs/cartas') --}}
@endif
@if(request()->is('categorias'))
    @include('scriptjs/datatables/datatableCategorias')
    @include('scriptjs/sweetalerts/sweetalertCategoria')
    @include('scriptjs/validacionesCategorias') {{-- validaciones --}}
@endif
@if(request()->is('subcategorias'))
    @include('scriptjs/datatables/datatableSubCategorias')
    @include('scriptjs/sweetalerts/sweetalertSubCategoria')
@endif
@if(request()->is('productos'))
    @include('scriptjs/datatables/datatableProductos')
    @include('scriptjs/sweetalerts/sweetalertProducto') 
     @include('scriptjs/productosModos')  
@endif
@if(request()->is('productos/create'))
    @include('scriptjs/validacionImgProducto')
    @include('scriptjs/productosModos')
@endif
    
@if(request()->is('menuscartas'))
    @include('scriptjs/datatables/datatableMenuCartas')
    @include('scriptjs/sweetalerts/sweetalertMenuCarta')
@endif
@if(request()->is('menuscartas/create'))
    @include('scriptjs/menucartas')
@endif

@if(request()->is('metodospago'))
    @include('scriptjs/datatables/datatableMetodosPago')
    @include('scriptjs/sweetalerts/sweetalertMetodoPago')
@endif
@if(request()->is('modos'))
    @include('scriptjs/datatables/datatableModos')
    @include('scriptjs/sweetalerts/sweetalertModo')
@endif
@if(request()->is('alergenos'))
    @include('scriptjs/datatables/datatableAlergenos')
    @include('scriptjs/sweetalerts/sweetalertAlergeno')
@endif

@if(request()->is('alergenos/create'))
    @include('scriptjs/validacionImgAlergeno')   
@endif

</html>

