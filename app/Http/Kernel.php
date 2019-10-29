<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \App\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        \App\Http\Middleware\TrustProxies::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            'throttle:60,1',
            'bindings',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'filtroAcceso' => \App\Http\Middleware\IngresoUser::class,
        'userLogueado' => \App\Http\Middleware\usuarioLogueado::class, //para verificar si ya existe sesion de usuario

        // 'accesoSinPermisosFiltro' => \App\Http\Middleware\SinPermisos::class,
        'accesoTomarOrdenFiltro' => \App\Http\Middleware\TomarOrden::class,
        'accesoHistoricoFiltro' => \App\Http\Middleware\Historico::class,
        'accesoAlergenosFiltro' => \App\Http\Middleware\Alergenos::class,
        'accesoCartasFiltro' => \App\Http\Middleware\Cartas::class,
        'accesoCategoriasFiltro' => \App\Http\Middleware\Categorias::class,
        'accesoCPFiltro' => \App\Http\Middleware\CentrosPreparacion::class,
        'accesoHotelesFiltro' => \App\Http\Middleware\Hoteles::class,
        'accesoImpresorasFiltro' => \App\Http\Middleware\Impresoras::class,
        'accesoMenusCartaFiltro' => \App\Http\Middleware\MenusCarta::class,
        'accesoMesasFiltro' => \App\Http\Middleware\Mesas::class,
        'accesoMPFiltro' => \App\Http\Middleware\MetodosPago::class,
        'accesoModosFiltro' => \App\Http\Middleware\Modos::class,
        'accesoProductosFiltro' => \App\Http\Middleware\Productos::class,
        'accesoPVentaFiltro' => \App\Http\Middleware\PuntosVenta::class,
        'accesoRolesFiltro' => \App\Http\Middleware\Roles::class,
        'accesoTurnosFiltro' => \App\Http\Middleware\Turnos::class,
        'accesoUsuariosFiltro' => \App\Http\Middleware\Usuarios::class,
        'accesoZonasFiltro' => \App\Http\Middleware\Zonas::class,
        
    ];

    /**
     * The priority-sorted list of middleware.
     *
     * This forces non-global middleware to always be in the given order.
     *
     * @var array
     */
    protected $middlewarePriority = [
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\Authenticate::class,
        \Illuminate\Session\Middleware\AuthenticateSession::class,
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
        \Illuminate\Auth\Middleware\Authorize::class,
    ];
}
