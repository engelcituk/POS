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
    Route::get('hoteles/store', 'HotelesController@store')->name('hoteles.store');
    Route::get('hoteles/{hotel}', 'hotelesController@show')->name('hoteles.show');
    Route::get('hoteles/{hotel}/edit' ,'hotelesController@edit')->name('hoteles.edit');
    
    //rutas de menu configuracion-->restaurantes 
    Route::get('all/restaurantes', 'RestaurantesController@AllRestaurantes')->name('all.restaurantes');
    Route::get('/restaurantes', 'RestaurantesController@index')->name('restaurantes.index');
    Route::get('restaurantes/create', 'RestaurantesController@create')->name('restaurantes.create');
    Route::get('restaurantes/store', 'RestaurantesController@store')->name('restaurantes.store');
    Route::get('restaurantes/{restaurante}', 'RestaurantesController@show')->name('restaurantes.show');
    Route::get('restaurantes/{restaurante}/edit', 'RestaurantesController@edit')->name('restaurantes.edit');

    //rutas de menu configuracion-->zonas 
    Route::get('all/zonas', 'ZonasController@AllZonas')->name('all.zonas');
    Route::get('/zonas', 'ZonasController@index')->name('zonas.index');
    Route::get('zonas/create', 'ZonasController@create')->name('zonas.create');
    Route::get('zonas/store', 'ZonasController@store')->name('zonas.store');
    Route::get('zonas/{zona}', 'ZonasController@show')->name('zonas.show');
    Route::get('zonas/{zona}/edit', 'ZonasController@edit')->name('zonas.edit');

    //rutas de menu configuracion-->mesas 
    Route::get('all/mesas', 'MesasController@AllMesas')->name('all.mesas');
    Route::get('/mesas', 'MesasController@index')->name('mesas.index');
    Route::get('mesas/create', 'MesasController@create')->name('mesas.create');
    Route::get('mesas/store', 'MesasController@store')->name('mesas.store');
    Route::get('mesas/{mesa}', 'MesasController@show')->name('mesas.show');
    Route::get('mesas/{mesa}/edit', 'MesasController@edit')->name('mesas.edit');

    //rutas de menu configuracion-->impmresoras 
    Route::get('all/impresoras', 'ImpresorasController@AllImpresoras')->name('all.impresoras');
    Route::get('/impresoras', 'ImpresorasController@index')->name('impresoras.index');
    Route::get('impresoras/create', 'ImpresorasController@create')->name('impresoras.create');
    Route::get('impresoras/store', 'ImpresorasController@store')->name('impresoras.store');
    Route::get('impresoras/{impresora}', 'ImpresorasController@show')->name('impresoras.show');
    Route::get('impresoras/{impresora}/edit', 'ImpresorasController@edit')->name('impresoras.edit');

    //rutas de menu configuracion-->metodos de pago 
    Route::get('all/metodospago', 'MetodosPagoController@AllMetodosPago')->name('all.metodospago');
    Route::get('/metodospago', 'MetodosPagoController@index')->name('metodospago.index');    
    Route::get('metodospago/create', 'MetodosPagoController@create')->name('metodospago.create');
    Route::get('metodospago/store', 'MetodosPagoController@store')->name('metodospago.store');
    Route::get('metodospago/{metodopago}', 'MetodosPagoController@show')->name('metodospago.show');
    Route::get('metodospago/{metodopago}/edit', 'MetodosPagoController@edit')->name('metodospago.edit');

    //rutas de menu configuracion-->productos
    Route::get('all/metodospago', 'MetodosPagoController@AllMetodosPago')->name('all.metodospago');
    Route::get('/metodospago', 'MetodosPagoController@index')->name('metodospago.index');
    Route::get('metodospago/create', 'MetodosPagoController@create')->name('metodospago.create');
    Route::get('metodospago/store', 'MetodosPagoController@store')->name('metodospago.store');
    Route::get('metodospago/{metodopago}', 'MetodosPagoController@show')->name('metodospago.show');
    Route::get('metodospago/{metodopago}/edit', 'MetodosPagoController@edit')->name('metodospago.edit');

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