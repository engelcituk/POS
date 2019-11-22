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
	@if(request()->is('ordenar'))
        <link href="{{asset('css/estiloTblComanda.css')}}" rel="stylesheet"/>                
    @endif
    @if(request()->is('historico'))
        <link href="{{asset('css/estiloModalHistorico.css')}}" rel="stylesheet"/>                
    @endif

    <!--     Fonts and icons     -->
    <link href="{{asset('css/font-awesome.css')}}" rel="stylesheet" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link href="{{asset('css/google-roboto-300-700.css')}}" rel="stylesheet" />
    <link href="{{asset('css/select2.min.css')}}" rel="stylesheet"/>
    <link href="{{asset('css/selectize.bootstrap3.css')}}" rel="stylesheet"/>
    <!-- Latest compiled and minified CSS -->
    
    
    <!-- Latest compiled and minified JavaScript -->
    <script src="{{asset('js/jquery-3.1.1.min.js')}}" type="text/javascript"></script>    
    <script src="{{asset('js/jquery.signalR-2.4.1.js')}}" type="text/javascript"></script>  
    <script src="http://172.16.1.45/TPVApi/signalr/hubs"></script>  

    
    <script src="{{asset('js/bootstrap.min.js')}}" type="text/javascript"></script>
    {{-- <script src="{{asset('js/selectize.js')}}"></script> --}}
    <script src="{{asset('js/select2.min.js')}}"></script>
    <script src="{{asset('js/bootstrap-timepicker.js')}}"></script> 
    {{-- <script src="{{asset('js/MultiCarousel.js')}}"></script>    --}}
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
                        @php
                          $tomarOrdenPermisoLeer= Session::get('TomarOrden.leer'); 
                          $historicoPermisoLeer= Session::get('Historico.leer');                         
                        @endphp                                                
                        @if($tomarOrdenPermisoLeer==1 || $historicoPermisoLeer==1)
                            <a data-toggle="collapse" href="#pagesExamples">
                                <i class="fas fa-cart-plus"></i>
                                <p>Operaciones
                                    <b class="caret"></b>
                                </p>
                            </a>
                        @endif
                        
                        <div class="collapse {{collapsarItemMenu(['ordenar.index','historico.index'])}}" id="pagesExamples">
                            <ul class="nav">
                                 @if($tomarOrdenPermisoLeer==1)
                                    <li class="{{activarRutaMenu('ordenar.index')}}">                                    
                                        <a href="{{ route('ordenar.index') }}">Tomar orden</a>
                                    </li>
                                 @endif                                                                                                
                                @if($historicoPermisoLeer==1)
                                    <li class="{{activarRutaMenu('historico.index')}}">                                    
                                        <a href="{{ route('historico.index')}}">Historico</a>
                                    </li>
                                @endif
                                
                            </ul>
                        </div>
                    </li>

                    <!--  -->
                     @php                         
                          $hotelesPermisoLeer= Session::get('Hoteles.leer');
                          $rolesPermisoLeer= Session::get('Roles.leer');
                          $usuariosPermisoLeer= Session::get('Usuarios.leer');
                          $pvPermisoLeer= Session::get('PuntosVenta.leer');
                          $impresorasPermisoLeer= Session::get('Impresoras.leer');
                          $cpPermisoLeer= Session::get('CentrosPreparacion.leer');
                          $turnosPermisoLeer= Session::get('TurnosPV.leer');
                          $zonasPermisoLeer= Session::get('Zonas.leer');
                          $mesasPermisoLeer= Session::get('Mesas.leer');
                          $cartasPermisoLeer= Session::get('Cartas.leer');
                          $categoriasPermisoLeer= Session::get('Categorias.leer');
                          $productosPermisoLeer= Session::get('Productos.leer');
                          $menuscartaPermisoLeer= Session::get('MenusCarta.leer');
                          $metodosPagoPermisoLeer= Session::get('MetodosPago.leer');
                          $modosPermisoLeer= Session::get('Modos.leer');
                          $alergenosPermisoLeer= Session::get('Alergenos.leer');
                        @endphp
                    <li>
                        @if($hotelesPermisoLeer==1 || $rolesPermisoLeer==1 || $usuariosPermisoLeer==1 || $pvPermisoLeer==1 || $impresorasPermisoLeer==1 ||$cpPermisoLeer==1 || $turnosPermisoLeer==1 || $zonasPermisoLeer==1 || $mesasPermisoLeer==1 || $cartasPermisoLeer==1 || $categoriasPermisoLeer==1 || $productosPermisoLeer==1 || $menuscartaPermisoLeer==1 || $metodosPagoPermisoLeer==1 || $modosPermisoLeer==1 || $alergenosPermisoLeer==1)
                            <a data-toggle="collapse" href="#componentsExamples">
                                <i class="fas fa-cogs"></i>
                                <p>Configuración
                                    <b class="caret"></b>
                                </p>
                            </a>        
                        @endif                         
                        <div class="collapse {{collapsarItemMenu(['hoteles.index','rolesapi.index','users.index','restaurantes.index','impresoras.index','centrospreparacion.index','turnos.index','zonas.index','mesas.index','cartas.index', 'categorias.index', 'productos.index','menuscartas.index','metodospago.index','modos.index','alergenos.index'])}}" id="componentsExamples">
                            <ul class="nav">
                                @if($hotelesPermisoLeer==1)
                                    <li class="{{activarRutaMenu('hoteles.index')}}">
                                        <a href="{{ route('hoteles.index') }}" >Hoteles</a>
                                    </li>
                                @endif                                
                                @if( $rolesPermisoLeer==1)
                                    <li class="{{activarRutaMenu('rolesapi.index')}}">
                                        <a href="{{ route('rolesapi.index') }}">Roles</a>
                                    </li>
                                @endif
                                @if($usuariosPermisoLeer==1)
                                    <li class="{{activarRutaMenu('users.index')}}">
                                        <a href="{{ route('users.index') }}">Usuarios</a>
                                    </li>
                                @endif
                                @if($pvPermisoLeer==1)
                                    <li class="{{activarRutaMenu('restaurantes.index')}}">                                    
                                        <a href="{{ route('restaurantes.index') }}">Puntos de venta</a>
                                    </li>
                                @endif
                                 @if($impresorasPermisoLeer==1)
                                    <li class="{{activarRutaMenu('impresoras.index')}}">                                    
                                        <a href="{{ route('impresoras.index') }}">Impresoras</a>
                                    </li>
                                @endif
                                 @if($cpPermisoLeer==1)
                                    <li class="{{activarRutaMenu('centrospreparacion.index')}}">                                    
                                        <a href="{{ route('centrospreparacion.index') }}">Centros de preparación</a>
                                    </li>
                                @endif
                                 @if($turnosPermisoLeer==1)
                                    <li class="{{activarRutaMenu('turnos.index')}}">                                    
                                        <a href="{{ route('turnos.index') }}">Turnos PV</a>
                                    </li>
                                @endif
                                 @if($zonasPermisoLeer==1)
                                    <li class="{{activarRutaMenu('zonas.index')}}">                                    
                                        <a href="{{ route('zonas.index') }}">Zonas</a>
                                    </li>
                                @endif
                                @if($mesasPermisoLeer==1)
                                    <li class="{{activarRutaMenu('mesas.index')}}">                                    
                                        <a href="{{ route('mesas.index') }}">Mesas</a>
                                    </li>
                                @endif 
                                @if($cartasPermisoLeer==1)
                                    <li class="{{activarRutaMenu('cartas.index')}}">           
                                        <a href="{{ route('cartas.index') }}">Cartas</a>
                                    </li>
                                @endif 
                                @if($categoriasPermisoLeer==1)
                                    <li class="{{activarRutaMenu('categorias.index')}}">        
                                        <a href="{{ route('categorias.index') }}">Categorias</a>
                                    </li>
                                @endif 
                                @if($productosPermisoLeer==1)
                                    <li class="{{activarRutaMenu('productos.index')}}">                                    
                                        <a href="{{ route('productos.index') }}">Productos</a>
                                    </li>
                                @endif 
                                @if(session()->has('MenusCarta'))
                                    <li class="{{activarRutaMenu('menuscartas.index')}}">                                    
                                        <a href="{{ route('menuscartas.index') }}">Menús cartas</a>
                                    </li>
                                @endif 
                                @if($menuscartaPermisoLeer==1)
                                    <li class="{{activarRutaMenu('metodospago.index')}}">                                    
                                        <a href="{{ route('metodospago.index') }}">Métodos de pago</a>
                                    </li>
                                @endif 
                                @if($modosPermisoLeer==1)
                                    <li class="{{activarRutaMenu('modos.index')}}">                                    
                                        <a href="{{ route('modos.index') }}">Modos</a>
                                    </li>
                                @endif
                                @if($alergenosPermisoLeer==1)
                                    <li class="{{activarRutaMenu('alergenos.index')}}">                                    
                                        <a href="{{ route('alergenos.index') }}">Alergénos</a>
                                    </li>
                                @endif                                                               
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
    {{-- <script src="{{asset('sweetalert/dist/sweetalert.min.js')}}" type="text/javascript"></script>
    @include('sweet::alert') --}}
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
<script src="{{asset('js/selectize.min.js')}}"></script>
<!-- Material Dashboard DEMO methods, don't include it in your project! -->
 <script src="{{asset('js/demo.js')}}"></script> 
<!-- <script src="{{asset('js/init.js')}}"></script> -->
@if(request()->is('hoteles') || request()->is('rolesapi') || request()->is('users') || request()->is('restaurantes') || request()->is('impresoras') || request()->is('centrospreparacion') || request()->is('turnos') || request()->is('zonas') || request()->is('mesas') || request()->is('cartas') || request()->is('categorias') || request()->is('productos') || request()->is('menuscartas') || request()->is('metodospago') || request()->is('modos') || request()->is('alergenos')) 
<script src="{{asset('js/datatables.js')}}"></script>   
@endif

<script src="{{asset('js/owl.carousel.min.js')}}"></script>

<!-- Mirrored from demos.creative-tim.com/material-dashboard-pro/examples/dashboard.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 20 Mar 2017 21:32:16 GMT -->
@include('scriptjs/ticketRecibo')
@if(request()->is('ordenar'))
    @include('scriptjs/orden')        
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

