<?php

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

//Hago que mis rutas sean validados con el middleware (auth) para el login
Route::middleware(['auth'])->group(function(){
    Route::get('/home', 'HomeController@index','HomeController@index')->name('home.index');
    Route::get('/ordenar', 'OrdenController@index')->name('ordenar.index');
    Route::get('/historico', 'HistoricoController@index')->name('historico.index');
    // Route::get('/roles', 'RolesController@index')->name('roles.index');
    // Route::resource('usuarios', 'UsuariosController');
    // Route::get('/usuarios', 'UsuariosController@index')->name('usuarios.index');
    Route::get('all/usuarios', 'UsuariosController@AllUser')->name('all.usuarios');
    // Route::post('/usuarios', 'UsuariosController@store')->name('usuarios');
    Route::get('/hoteles', 'HotelesController@index')->name('hoteles.index');
    Route::get('/restaurantes', 'RestaurantesController@index')->name('restaurantes.index');
    Route::get('/zonas', 'ZonasController@index')->name('zonas.index');
    Route::get('/mesas', 'MesasController@index')->name('mesas.index');
    Route::get('/impresoras', 'ImpresorasController@index')->name('impresoras.index');
    Route::get('/categorias', 'CategoriasController@index')->name('categorias.index');
    // Route::get('/productos', 'ProductosController@index')->name('productos.index');
    Route::get('/formaspago', 'FormaspagoController@index')->name('formaspago.index');

    //roles
    // Route::post('roles/store','RolesController@store')->name('roles.store')
    //     ->middleware('permission:roles.create');

    Route::get('/roles','RolesController@index')->name('roles.index')
    ->middleware('permission:roles.index');

    // Route::post('roles/create','RolesController@create')->name('roles.create')
    //     ->middleware('permission:roles.create');

    // Route::put('roles/{role}','RolesController@update')->name('roles.update')
    //     ->middleware('permission:roles.edit');

    // Route::get('roles/{role}','RolesController@show')->name('roles.show')
    //     ->middleware('permission:roles.show');

    // Route::delete('roles/{role}','RolesController@destroy')->name('roles.destroy')
    //     ->middleware('permission:roles.destroy');

    // Route::get('roles/{role}/edit','RolesController@edit')->name('roles.edit')
    //     ->middleware('permission:roles.edit');

    //Productos
    // Route::post('productos/store','ProductosController@store')->name('productos.store')
    //     ->middleware('permission:productos.create');

    Route::get('productos','ProductosController@index')->name('productos.index')
    ->middleware('permission:productos.index');

    // Route::post('productos/create','ProductosController@create')->name('productos.create')
    //     ->middleware('permission:productos.create');

    // Route::put('productos/{producto}','ProductosController@update')->name('productos.update')
    //     ->middleware('permission:productos.edit');

    // Route::get('productos/{producto}','ProductosController@show')->name('productos.show')
    //     ->middleware('permission:productos.show');

    // Route::delete('productos/{producto}','ProductosController@destroy')->name('productos.destroy')
    //     ->middleware('permission:productos.destroy');

    // Route::get('productos/{producto}/edit','ProductosController@edit')->name('productos.edit')
    //     ->middleware('permission:productos.edit');
 
    //usuarios    
    // Route::post('usuarios/store','UsuariosController@store')->name('usuarios.store')
    //     ->middleware('permission:usuarios.create');
    
    Route::get('usuarios','UsuariosController@index')->name('usuarios.index')
    ->middleware('permission:usuarios.index');

    // Route::post('usuarios/create','UsuariosController@create')->name('usuarios.create')
    //     ->middleware('permission:usuarios.create');

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