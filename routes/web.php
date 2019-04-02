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
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/ordenar', 'OrdenController@index')->name('ordenar');
    Route::get('/historico', 'HistoricoController@index')->name('historico');
    Route::get('/roles', 'RolesController@index')->name('roles');
    // Route::resource('usuarios', 'UsuariosController');
    Route::get('/usuarios', 'UsuariosController@index')->name('usuarios');
    Route::get('all/usuarios', 'UsuariosController@AllUser')->name('all.usuarios');
    Route::post('/usuarios', 'UsuariosController@store')->name('usuarios');
    Route::get('/hoteles', 'HotelesController@index')->name('hoteles');
    Route::get('/restaurantes', 'RestaurantesController@index')->name('restaurantes');
    Route::get('/zonas', 'ZonasController@index')->name('zonas');
    Route::get('/mesas', 'MesasController@index')->name('mesas');
    Route::get('/impresoras', 'ImpresorasController@index')->name('impresoras');
    Route::get('/categorias', 'CategoriasController@index')->name('categorias');
    Route::get('/productos', 'ProductosController@index')->name('productos');
    Route::get('/formaspago', 'FormaspagoController@index')->name('formaspago');

    //roles
    Route::post('roles/store')->name('roles.store')
        ->middleware('permission:roles.create');

    Route::get('roles')->name('roles.index')
        ->middleware('permission:roles.index');

    Route::post('roles/create')->name('roles.create')
        ->middleware('permission:roles.create');

    Route::put('roles/{role}')->name('roles.update')
        ->middleware('permission:roles.edit');

    Route::get('roles/{role}')->name('roles.show')
        ->middleware('permission:roles.show');

    Route::delete('roles/{role}')->name('roles.destroy')
        ->middleware('permission:roles.destroy');

    Route::get('roles/{role}/edit')->name('roles.edit')
        ->middleware('permission:roles.edit');
});

// Route::resource('usuarios', 'UsuariosController');
// Route::get('all/usuarios', 'UsuariosController@AllUser')->name('all/usuarios');