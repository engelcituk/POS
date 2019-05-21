<?php
use TCG\Voyager\Http\Controllers\Controller;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/prueba','Controller@obtenerAccessToken');

//Hago que mis rutas sean validados con el middleware (auth) para el login
Route::middleware(['auth'])->group(function(){
    Route::get('/home', 'HomeController@index','HomeController@index')->name('home.index');
    Route::get('/ordenar', 'OrdenController@index')->name('ordenar.index');
    Route::get('/historico', 'HistoricoController@index')->name('historico.index');
    // Route::get('/roles', 'RolesController@index')->name('roles.index');
    // Route::resource('usuarios', 'UsuariosController');
    // Route::get('/usuarios', 'UsuariosController@index')->name('usuarios.index');
    Route::get('all/usuarios', 'UsuariosController@AllUser')->name('all.usuarios');
    Route::get('all/roles', 'RolesController@AllRole')->name('all.roles');
    // Route::post('/usuarios', 'UsuariosController@store')->name('usuarios');
        
    Route::get('/categorias', 'CategoriasController@index')->name('categorias.index');
    // Route::get('/productos', 'ProductosController@index')->name('productos.index');
    
    
    //rutas de menu configuracion -->hoteles
    Route::get('all/hoteles', 'HotelesController@AllHoteles')->name('all.hoteles');
    Route::get('/hoteles', 'HotelesController@index')->name('hoteles.index');
    Route::get('hoteles/create', 'HotelesController@create')->name('hoteles.create');
    Route::post('hoteles/store', 'HotelesController@store')->name('hoteles.store');
    Route::get('hoteles/{hotel}', 'HotelesController@show')->name('hoteles.show');
    Route::get('hoteles/{hotel}/edit' ,'HotelesController@edit')->name('hoteles.edit');
    Route::put('hoteles/actualizar', 'HotelesController@actualizar')->name('hoteles.actualizar');
    Route::delete('hoteles/{hotel}', 'HotelesController@destroy')->name('hoteles.destroy');

    //rutas de menu configuracion-->usuarios
    Route::get('all/users', 'ApiUsuarioController@AllApiUsuario')->name('all.users');
    Route::get('/users', 'ApiUsuarioController@index')->name( 'users.index');
    Route::get('users/create', 'ApiUsuarioController@create')->name('users.create');
    Route::get('users/store', 'ApiUsuarioController@store')->name('users.store');
    Route::get('users/{user}', 'ApiUsuarioController@show')->name('users.show');
    Route::get('users/{user}/edit', 'ApiUsuarioController@edit')->name('users.edit');

    //rutas de menu configuracion-->apiRoles
    Route::get('all/rolesapi', 'ApiRolController@AllApiRoll')->name('all.rolesapi');
    Route::get('/rolesapi', 'ApiRolController@index')->name('rolesapi.index');
    Route::get('rolesapi/create', 'ApiRolController@create')->name('rolesapi.create');
    Route::get('rolesapi/store', 'ApiRolController@store')->name('rolesapi.store');
    Route::get('rolesapi/{rolapi}', 'ApiRolController@show')->name('rolesapi.show');
    Route::get('rolesapi/{rolapi}/edit', 'ApiRolController@edit')->name('rolesapi.edit');

    //rutas de menu configuracion-->restaurantes 
    Route::get('all/restaurantes', 'RestaurantesController@AllRestaurantes')->name('all.restaurantes');
    Route::get('/restaurantes', 'RestaurantesController@index')->name('restaurantes.index');
    Route::get('restaurantes/create', 'RestaurantesController@create')->name('restaurantes.create');
    Route::post('restaurantes/store', 'RestaurantesController@store')->name('restaurantes.store');
    Route::get('restaurantes/{restaurante}', 'RestaurantesController@show')->name('restaurantes.show');
    Route::get('restaurantes/{restaurante}/edit', 'RestaurantesController@edit')->name('restaurantes.edit');
    Route::put('restaurantes/actualizar', 'RestaurantesController@actualizar')->name('restaurantes.actualizar');
    Route::delete('restaurantes/{restaurante}', 'RestaurantesController@destroy')->name('restaurantes.destroy');

    //rutas de menu configuracion-->zonas 
    Route::get('all/zonas', 'ZonasController@AllZonas')->name('all.zonas');
    Route::get('/zonas', 'ZonasController@index')->name('zonas.index');
    Route::get('zonas/create', 'ZonasController@create')->name('zonas.create');
    Route::post('zonas/store', 'ZonasController@store')->name('zonas.store');
    Route::get('zonas/{zona}', 'ZonasController@show')->name('zonas.show');
    Route::get('zonas/{zona}/edit', 'ZonasController@edit')->name('zonas.edit');
    Route::put('zonas/actualizar', 'ZonasController@actualizar')->name('zonas.actualizar');
    Route::delete('zonas/{zona}', 'ZonasController@destroy')->name('zonas.destroy');

    //rutas de menu configuracion-->mesas 
    Route::get('all/mesas', 'MesasController@AllMesas')->name('all.mesas'); 
    Route::get('/mesas', 'MesasController@index')->name('mesas.index');
    Route::get('mesas/create', 'MesasController@create')->name('mesas.create');
    Route::post('mesas/store', 'MesasController@store')->name('mesas.store'); 
    Route::get('mesas/{mesa}', 'MesasController@show')->name('mesas.show');
    Route::get('mesas/{mesa}/edit', 'MesasController@edit')->name('mesas.edit');

    //rutas de menu configuracion-->impmresoras 
    Route::get('all/impresoras', 'ImpresorasController@AllImpresoras')->name('all.impresoras');
    Route::get('/impresoras', 'ImpresorasController@index')->name('impresoras.index');
    Route::get('impresoras/create', 'ImpresorasController@create')->name('impresoras.create');
    Route::post('impresoras/store', 'ImpresorasController@store')->name('impresoras.store');
    Route::get('impresoras/{impresora}', 'ImpresorasController@show')->name('impresoras.show');
    Route::get('impresoras/{impresora}/edit', 'ImpresorasController@edit')->name('impresoras.edit');

    //rutas de menu configuracion-->metodos de pago 
    Route::get('all/metodospago', 'MetodosPagoController@AllMetodosPago')->name('all.metodospago');
    Route::get('/metodospago', 'MetodosPagoController@index')->name('metodospago.index');    
    Route::get('metodospago/create', 'MetodosPagoController@create')->name('metodospago.create');
    Route::post('metodospago/store', 'MetodosPagoController@store')->name('metodospago.store');
    Route::get('metodospago/{metodopago}',  'MetodosPagoController@show')->name('metodospago.show'); 
    Route::get('metodospago/{metodopago}/edit', 'MetodosPagoController@edit')->name('metodospago.edit');
    Route::put('metodospago/actualizar','MetodosPagoController@actualizar')->name('metodospago.actualizar');
    Route::delete( 'metodospago/{metodopago}','MetodosPagoController@destroy')->name('metodospago.destroy');

    //rutas de menu configuracion-->modos
    Route::get('all/modos', 'ModosController@AllModos')->name('all.modos');
    Route::get('/modos', 'ModosController@index')->name('modos.index');
    Route::get('modos/create', 'ModosController@create')->name('modos.create');
    Route::post('modos/store', 'ModosController@store')->name('modos.store');
    Route::get('modos/{modos}', 'ModosController@show')->name('modos.show');
    Route::get('modos/{modos}/edit', 'ModosController@edit')->name('modos.edit');
   
    //rutas de menu configuracion-->alergenos
    Route::get('all/alergenos', 'AlergenoController@AllAlergenos')->name('all.alergenos');
    Route::get('/alergenos', 'AlergenoController@index')->name('alergenos.index');
    Route::get('alergenos/create', 'AlergenoController@create')->name('alergenos.create');
    Route::post('alergenos/store', 'AlergenoController@store')->name('alergenos.store');
    Route::get('alergenos/{alergeno}', 'AlergenoController@show')->name('alergenos.show');
    Route::get('alergenos/{alergeno}/edit', 'AlergenoController@edit')->name('alergenos.edit');

    //rutas de menu configuracion-->carta
    Route::get('all/cartas', 'CartaController@AllCartas')->name('all.cartas');
    Route::get('/cartas', 'CartaController@index')->name('cartas.index');
    Route::get('cartas/create', 'CartaController@create')->name('cartas.create');
    Route::post('cartas/store', 'CartaController@store')->name('cartas.store');
    Route::get('cartas/{carta}', 'CartaController@show')->name('cartas.show');
    Route::get('cartas/{carta}/edit', 'CartaController@edit')->name('cartas.edit');
    

    //roles

    Route::get('/roles','RolesController@index')->name('roles.index')
    ->middleware('permission:roles.index');
    
    Route::get('roles/create','RolesController@create')->name('roles.create')
        ->middleware('permission:roles.create');
    
    Route::post('roles/store', 'RolesController@store')->name('roles.store')
        ->middleware('permission:roles.create');

    Route::put('roles/{role}','RolesController@update')->name('roles.update')
        ->middleware('permission:roles.edit');

    Route::get('roles/{role}','RolesController@show')->name('roles.show')
        ->middleware('permission:roles.show');

    Route::delete('roles/{role}','RolesController@destroy')->name('roles.destroy')
        ->middleware('permission:roles.destroy');

    Route::get('roles/{role}/edit','RolesController@edit')->name('roles.edit')
        ->middleware('permission:roles.edit');
    

    //Productos
    // Route::post('productos/store','ProductosController@store')->name('productos.store')
    //     ->middleware('permission:productos.create');

    Route::get('productos','ProductosController@index')->name('productos.index')
    ->middleware('permission:productos.index');

    Route::get('all/productos', 'ProductosController@AllProduct')->name('all.productos');

    Route::get('productos/create','ProductosController@create')->name('productos.create')
        ->middleware('permission:productos.create');

    Route::post('productos/store', 'ProductosController@store')->name('productos.store')
        ->middleware('permission:productos.create');

    Route::put('productos/{producto}','ProductosController@update')->name('productos.update')
        ->middleware('permission:productos.edit');

    Route::get('productos/{producto}','ProductosController@show')->name('productos.show')
        ->middleware('permission:productos.show');

    Route::delete('productos/{producto}','ProductosController@destroy')->name('productos.destroy')
        ->middleware('permission:productos.destroy');

    Route::get('productos/{producto}/edit','ProductosController@edit')->name('productos.edit')
        ->middleware('permission:productos.edit');
 
    //usuarios    
    Route::post('usuarios/store','UsuariosController@store')->name('usuarios.store')
        ->middleware('permission:usuarios.create');
    
    Route::get('usuarios','UsuariosController@index')->name('usuarios.index')
    ->middleware('permission:usuarios.index');

    Route::get('usuarios/create','UsuariosController@create')->name('usuarios.create')
        ->middleware('permission:usuarios.create');

    Route::get('usuarios/{usuario}','UsuariosController@show')->name('usuarios.show')
        ->middleware('permission:usuarios.show');

    Route::get('usuarios/{usuario}/edit','UsuariosController@edit')->name('usuarios.edit')
        ->middleware('permission:roles.edit');

    Route::put('usuarios/{usuario}','UsuariosController@update')->name('usuarios.update')
        ->middleware('permission:usuarios.edit');

    Route::delete('usuarios/{usuario}','UsuariosController@destroy')->name('usuarios.destroy')
        ->middleware('permission:usuarios.destroy');

    
});

// Route::resource('usuarios', 'UsuariosController');
// Route::get('all/usuarios', 'UsuariosController@AllUser','RolesController@store')->name('all/usuarios');