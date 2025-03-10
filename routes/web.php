<?php 

Route::get('/', ['middleware'=> 'userLogueado', function () {
    $hoteles = \App::call('App\Http\Controllers\HotelesController@obtenerTodosLosHoteles');
    return view('auth.login', compact('hoteles'));
}]);
Route::get('/admin', function () {    
    return view('authAdmin.login');
});
// Auth::routes();
Route::get('login/getpuntosventa/{hotel}', 'Auth\LoginController@obtenerPuntosVenta')->name('login.puntosventa');
Route::get('login/getcartas/{idpv}', 'Auth\LoginController@obtenerCartasPuntosVenta')->name('login.cartas');
Route::post('login', 'Auth\LoginController@login')->name('login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
//endpoint para obtener los datos de un usuario que autorizar cobros
Route::post('autoriza/{usuario}/{password}', 'Auth\LoginController@autorizaCobroUsuario')->name('login.autorizaCobroUsuario');


Route::middleware(['filtroAcceso'])->group(function () {
//ruta y controller que se usa cuando middleware verifica que user no tiene ningun permiso
Route::get('sinpermisos', 'SinPermisosController@index')->name('permisos.index');

//rutas a todo la parte de ordenar
Route::get('ordenar', 'OrdenController@index')->name('ordenar.index');
Route::get('ordenar/obtenerzonas', 'OrdenController@obtenerTodasLasZonasPV')->name('ordenar.getzonas');
Route::get('ordenar/obtenermesaszona/{idZona}', 'OrdenController@getMesasPorZona')->name('ordenar.obtenermesaszona');
Route::get('ordenar/getmesasactivas/{idZona}', 'OrdenController@getMesasActivas')->name('ordenar.obtenermesasactivas');
Route::get('ordenar/{codhotel}/{room}', 'OrdenController@obtenerDatosHuesped')->name('ordenar.obtenerhuesped');
Route::post('ordenar/addcuenta', 'OrdenController@guardarCuenta')->name('ordenar.addcuenta');
Route::post('ordenar/updatecuenta/{cuenta}', 'OrdenController@updateCuentaRoom')->name('ordenar.updatecuentaroom');
Route::post('ordenar/updatemesa', 'OrdenController@updateCuentaMesa')->name('ordenar.updatecuentamesa');
Route::post('ordenar/enviarcuenta', 'OrdenController@enviarACentrosPrep')->name('ordenar.enviarcuenta');
Route::post('ordenar/cerrarcuenta/{cuenta}', 'OrdenController@cerraCuenta')->name('ordenar.cerrarcuenta');
Route::post('ordenar/cuentapreticket/{cuenta}', 'OrdenController@imprimirPreticket')->name('ordenar.cuentapreticket');

Route::post('ordenar/addcuentaalergia', 'OrdenController@addCuentaAlergiaPax')->name('ordenar.cuentaalergia');
Route::post('ordenar/cerrardia/{idpv}', 'OrdenController@cerrarDia')->name('ordenar.cerrardia');
Route::get('obtener/productos', 'OrdenController@getProductosByCat')->name('obtener.productos');
Route::get('ordenar/getfavoritos', 'OrdenController@getProductosFavoritos')->name('obtener.productosfavoritos');
Route::get('buscar/alergenos/{idproducto}', 'OrdenController@obtenerAlergenosProducto')->name('buscar.getalergenos');
Route::get('obtenercuenta/{idcuenta}', 'OrdenController@obtenerCuentaApi')->name('obtenercuenta.api');
Route::get('getcuenta/{idcuenta}', 'OrdenController@getCuenta')->name('getcuenta.api');
Route::delete('cancelarproducto/{idDetalleCuenta}', 'OrdenController@cancelarProductoCuenta')->name('cancelardetalle.api');

//rutas historicos
Route::get('historico', 'HistoricoController@index')->name('historico.index');
Route::post('all/historico', 'HistoricoController@AllHistorico')->name('all.historico');
Route::post('historico/cierredia', 'HistoricoController@cierreDiaDetalle')->name('historico.cierredia');
Route::post('historico/pdf', 'HistoricoController@generaPdf')->name('historico.pdf');
Route::get('historico/datosexcel/{fecha}', 'HistoricoController@generaExcel')->name('historico.excel');
Route::post('historico/cancelar/{cuenta}', 'HistoricoController@cancelarCuenta')->name('historico.cancelar');
Route::post('historico/imprimir/{cuenta}', 'HistoricoController@imprimirCuenta')->name('historico.imprimir');
Route::post('historico/imprimirCuentaHist/{cuenta}', 'HistoricoController@imprimirCuentaHistorico')->name('historico.imprimirCuentaHistorico');

Route::post('historico/imprimircerrardia', 'HistoricoController@imprimirDesgloseHistorico')->name('historico.imprimircerrardia');
Route::get('historico/{cuenta}', 'HistoricoController@obtenerCuenta')->name('historico.cuenta');
Route::get('historico/detalle/{cuenta}', 'HistoricoController@obtenerDetalleCuenta')->name('historico.detalle');


//rutas de menu configuracion -->hoteles
Route::get('all/hoteles', 'HotelesController@AllHoteles')->name('all.hoteles');
Route::get('hoteles', 'HotelesController@index')->name('hoteles.index');
Route::get('hoteles/create', 'HotelesController@create')->name('hoteles.create');
Route::post('hoteles/store', 'HotelesController@store')->name('hoteles.store');
Route::get('hoteles/{hotel}', 'HotelesController@show')->name('hoteles.show');
Route::get('hoteles/{hotel}/edit', 'HotelesController@edit')->name('hoteles.edit');
Route::post('hoteles/actualizar', 'HotelesController@actualizar')->name('hoteles.actualizar');
Route::post('hoteles/{hotel}', 'HotelesController@destroy')->name('hoteles.destroy');
 
//rutas de menu configuracion-->apiRoles
Route::get('all/rolesapi', 'ApiRolController@AllApiRol')->name('all.rolesapi');
Route::get('rolesapi', 'ApiRolController@index')->name('rolesapi.index');
Route::get('rolesapi/create', 'ApiRolController@create')->name('rolesapi.create');
Route::post('rolesapi/store', 'ApiRolController@store')->name('rolesapi.store');
Route::post('rolesapi/{idRol}/{idpermiso}', 'ApiRolController@guardarPermisosRol')->name('rolesapi.storepermiso');
Route::get('rolesapi/{rolapi}', 'ApiRolController@show')->name('rolesapi.show');
Route::get('rolesapi/{rolapi}/edit', 'ApiRolController@edit')->name('rolesapi.edit');
Route::post('rolesapi/actualizar', 'ApiRolController@actualizar')->name('rolesapi.actualizar');
Route::post('rolesapi/{rolapi}', 'ApiRolController@destroy')->name('rolesapi.destroy');
Route::post('rolapiborrar/{idRol}/{idPermiso}', 'ApiRolController@destroyPermiso')->name('rolesapi.destroypermiso');

//rutas de menu configuracion-->usuarios con la api
Route::get('all/users', 'ApiUsuarioController@AllApiUsuario')->name('all.users');
Route::get('users', 'ApiUsuarioController@index')->name('users.index');
Route::get('users/create', 'ApiUsuarioController@create')->name('users.create');
Route::post('users/store', 'ApiUsuarioController@store')->name('users.store');
Route::post('users/{idUsuario}/{idPermiso}', 'ApiUsuarioController@guardarPermisosUsuario')->name('users.storepermiso');
Route::get('users/{user}', 'ApiUsuarioController@show')->name('users.show');
Route::get('users/{user}/edit', 'ApiUsuarioController@edit')->name('users.edit');
Route::get('users/getpermisos/{user}', 'ApiUsuarioController@obtenerDatosPermisosUsuario')->name('users.getpermisos');
Route::post('users/actualizar', 'ApiUsuarioController@actualizar')->name('users.actualizar');
Route::post('users/update/{user}/{idpermiso}', 'ApiUsuarioController@guardarAccionPermisoUsuario')->name('users.storeaccionpermiso');
Route::post('users/{user}', 'ApiUsuarioController@destroy')->name('users.destroy');
Route::post('users/destroy/{idUsuario}/{idpermiso}', 'ApiUsuarioController@destroyPermisoUsuario')->name('users.destroypermisouser');
 

//rutas de menu configuracion-->restaurantes 
Route::get('all/restaurantes', 'RestaurantesController@AllRestaurantes')->name('all.restaurantes');
Route::get('restaurantes', 'RestaurantesController@index')->name('restaurantes.index');
Route::get('restaurantes/create', 'RestaurantesController@create')->name('restaurantes.create');
Route::post('restaurantes/store', 'RestaurantesController@store')->name('restaurantes.store');
Route::get('restaurantes/{restaurante}', 'RestaurantesController@show')->name('restaurantes.show');
Route::get('restaurantes/{restaurante}/edit', 'RestaurantesController@edit')->name('restaurantes.edit');
Route::post('restaurantes/actualizar', 'RestaurantesController@actualizar')->name('restaurantes.actualizar');
Route::post('restaurantes/{restaurante}', 'RestaurantesController@destroy')->name('restaurantes.destroy');

//rutas de menu configuracion-->Turnos de punto de venta 
Route::get('all/turnos', 'TurnosController@AllTurnos')->name('all.turnos');
Route::get('turnos', 'TurnosController@index')->name('turnos.index');
Route::get('turnos/create', 'TurnosController@create')->name('turnos.create');
Route::post('turnos/store', 'TurnosController@store')->name('turnos.store');
Route::get('turnos/{turno}', 'TurnosController@show')->name('turnos.show');
Route::get('turnos/{turno}/edit', 'TurnosController@edit')->name('turnos.edit');
Route::post('turnos/actualizar', 'TurnosController@actualizar')->name('turnos.actualizar');
Route::post('turnos/{turno}', 'TurnosController@destroy')->name('turnos.destroy');

//rutas de menu configuracion-->zonas 
Route::get('all/zonas', 'ZonasController@AllZonas')->name('all.zonas');
Route::get('zonas', 'ZonasController@index')->name('zonas.index');
Route::get('zonas/create', 'ZonasController@create')->name('zonas.create');
Route::post('zonas/store', 'ZonasController@store')->name('zonas.store');
Route::get('zonas/{zona}', 'ZonasController@show')->name('zonas.show');
Route::get('zonas/{zona}/edit', 'ZonasController@edit')->name('zonas.edit');
Route::post('zonas/actualizar', 'ZonasController@actualizar')->name('zonas.actualizar');
Route::post('zonas/{zona}', 'ZonasController@destroy')->name('zonas.destroy');

//rutas de menu configuracion-->mesas 
Route::get('all/mesas', 'MesasController@AllMesas')->name('all.mesas');
Route::get('mesas', 'MesasController@index')->name('mesas.index');
Route::get('mesas/create', 'MesasController@create')->name('mesas.create');
Route::post('mesas/store', 'MesasController@store')->name('mesas.store');
Route::get('mesas/{mesa}', 'MesasController@show')->name('mesas.show');
Route::get('mesas/{mesa}/edit', 'MesasController@edit')->name('mesas.edit');
Route::post('mesas/actualizar', 'MesasController@actualizar')->name('mesas.actualizar');
Route::post('mesas/{mesa}', 'MesasController@destroy')->name('mesas.destroy');

//rutas de menu configuracion-->impmresoras 
Route::get('all/impresoras', 'ImpresorasController@AllImpresoras')->name('all.impresoras');
Route::get('impresoras', 'ImpresorasController@index')->name('impresoras.index');
Route::get('impresoras/create', 'ImpresorasController@create')->name('impresoras.create');
Route::post('impresoras/store', 'ImpresorasController@store')->name('impresoras.store');
Route::get('impresoras/{impresora}', 'ImpresorasController@show')->name('impresoras.show');
Route::get('impresoras/{impresora}/edit', 'ImpresorasController@edit')->name('impresoras.edit');
Route::post('impresoras/actualizar', 'ImpresorasController@actualizar')->name('impresoras.actualizar');
Route::post('impresoras/{impresora}', 'ImpresorasController@destroy')->name('impresoras.destroy');

//rutas de menu configuracion-->centros de preparacion
Route::get('all/centrospreparacion', 'CentrosPreparacionController@AllCentrosPreparacion')->name('all.centrospreparacion');
Route::get('centrospreparacion', 'CentrosPreparacionController@index')->name('centrospreparacion.index');
Route::get('centrospreparacion/create', 'CentrosPreparacionController@create')->name('centrospreparacion.create');
Route::post('centrospreparacion/store', 'CentrosPreparacionController@store')->name('centrospreparacion.store');
Route::get('centrospreparacion/{cpreparacion}', 'CentrosPreparacionController@show')->name('centrospreparacion.show');
Route::get('centrospreparacion/{cpreparacion}/edit', 'CentrosPreparacionController@edit')->name('centrospreparacion.edit');
Route::post('centrospreparacion/actualizar', 'CentrosPreparacionController@actualizar')->name('centrospreparacion.actualizar');
Route::post('centrospreparacion/{cpreparacion}', 'CentrosPreparacionController@destroy')->name('centrospreparacion.destroy');

//rutas de menu configuracion-->metodos de pago 
Route::get('all/metodospago', 'MetodosPagoController@AllMetodosPago')->name('all.metodospago');
Route::get('metodospago', 'MetodosPagoController@index')->name('metodospago.index');
Route::get('metodospago/create', 'MetodosPagoController@create')->name('metodospago.create');
Route::post('metodospago/store', 'MetodosPagoController@store')->name('metodospago.store');
Route::get('metodospago/{metodopago}',  'MetodosPagoController@show')->name('metodospago.show');
Route::get('metodospago/{metodopago}/edit', 'MetodosPagoController@edit')->name('metodospago.edit');
Route::post('metodospago/actualizar', 'MetodosPagoController@actualizar')->name('metodospago.actualizar');
Route::post('metodospago/{metodopago}', 'MetodosPagoController@destroy')->name('metodospago.destroy');

//rutas de menu configuracion-->modos
Route::get('all/modos', 'ModosController@AllModos')->name('all.modos');
Route::get('modos', 'ModosController@index')->name('modos.index');
Route::get('modos/create', 'ModosController@create')->name('modos.create');
Route::post('modos/store', 'ModosController@store')->name('modos.store');
Route::get('modos/{modos}', 'ModosController@show')->name('modos.show');
Route::get('modos/{modos}/edit', 'ModosController@edit')->name('modos.edit');
Route::post('modos/actualizar', 'ModosController@actualizar')->name('modos.actualizar');
Route::post('modos/{modo}', 'ModosController@destroy')->name('modos.destroy');

//rutas de menu configuracion-->alergenos
Route::get('all/alergenos', 'AlergenoController@AllAlergenos')->name('all.alergenos');
Route::get('alergenos', 'AlergenoController@index')->name('alergenos.index');
Route::get('alergenos/create', 'AlergenoController@create')->name('alergenos.create');
Route::post('alergenos/store', 'AlergenoController@store')->name('alergenos.store');
Route::get('alergenos/{alergeno}', 'AlergenoController@show')->name('alergenos.show');
Route::get('showalergeno/{alergeno}', 'AlergenoController@obtenerUnAlergeno')->name('alergenos.getalergeno');
Route::get('alergenos/{alergeno}/edit', 'AlergenoController@edit')->name('alergenos.edit');
Route::post('alergenos/actualizar', 'AlergenoController@actualizar')->name('alergenos.actualizar');
Route::post('alergenos/{alergeno}', 'AlergenoController@destroy')->name('alergenos.destroy');

//rutas de menu configuracion-->carta
Route::get('all/cartas', 'CartaController@AllCartas')->name('all.cartas');
Route::get('cartas', 'CartaController@index')->name('cartas.index');
Route::get('cartas/create', 'CartaController@create')->name('cartas.create');
Route::post('cartas/store', 'CartaController@store')->name('cartas.store');
Route::get('cartas/{carta}', 'CartaController@show')->name('cartas.show');
Route::get('cartas/{carta}/edit', 'CartaController@edit')->name('cartas.edit');
Route::post('cartas/actualizar', 'CartaController@actualizar')->name('cartas.actualizar');
Route::post('cartas/{carta}', 'CartaController@destroy')->name('cartas.destroy');

//rutas de menu configuracion-->categorias
Route::get('all/categorias', 'CategoriaController@AllCategorias')->name('all.categorias');
Route::get('categorias', 'CategoriaController@index')->name('categorias.index');
Route::get('categorias/create', 'CategoriaController@create')->name('categorias.create');
Route::post('categorias/store', 'CategoriaController@store')->name('categorias.store');
Route::get('categorias/{categoria}', 'CategoriaController@show')->name('categorias.show');
Route::get('categorias/{categoria}/edit', 'CategoriaController@edit')->name('categorias.edit');
Route::post('categorias/actualizar', 'CategoriaController@actualizar')->name('categorias.actualizar');
Route::post('categorias/{categoria}', 'CategoriaController@destroy')->name('categorias.destroy');

//Productos    
Route::get('all/productos', 'ProductosController@AllProduct')->name('all.productos');
Route::get('productos', 'ProductosController@index')->name('productos.index');
Route::get('productos/create', 'ProductosController@create')->name('productos.create');
Route::get('productos/getmodos', 'ProductosController@getModosProducto')->name('productos.getmodoproducto');
Route::post('productos/store', 'ProductosController@store')->name('productos.store');
Route::post('productos/{idProducto}/{idAlergeno}', 'ProductosController@guardarProductoAlergeno')->name('productos.storealergeno');
Route::post('productos/actualizar', 'ProductosController@actualizar')->name('productos.actualizar');
Route::post('productos/addmodo', 'ProductosController@AddProductoModoEdit')->name('productos.AddProductoModoEdit');
Route::post('productos/deletemodo', 'ProductosController@deleteModoProducto')->name('productos.deletemodoproducto');
Route::get('productos/{producto}', 'ProductosController@show')->name('productos.show');
Route::get('productos/{producto}/edit', 'ProductosController@edit')->name('productos.edit');        
Route::post('productos/{producto}', 'ProductosController@destroy')->name('productos.destroy');
Route::post('borrar/{idProd}/{idAler}', 'ProductosController@destroyAlergeno')->name('producto.destroyalergeno');

//menu cartas   
Route::get('all/menuscartas', 'MenusCartasController@AllMenuCartas')->name('all.menuscartas');
Route::get('menuscartas', 'MenusCartasController@index')->name('menuscartas.index');
Route::get('menuscartas/create', 'MenusCartasController@create')->name('menuscartas.create');
Route::post('menuscartas/store', 'MenusCartasController@store')->name('menuscartas.store');
Route::get('menuscartas/{menuscarta}', 'MenusCartasController@show')->name('menuscartas.show');
Route::get('menuscartas/{menuscarta}/edit', 'MenusCartasController@edit')->name('menuscartas.edit');
Route::post('menuscartas/actualizar', 'MenusCartasController@actualizar')->name('menuscartas.actualizar');
Route::post('menuscartas/{menuscarta}', 'MenusCartasController@destroy')->name('menuscartas.destroy');


Route::post('printrecibo', 'ReciboTicketController@createRecibo')->name('imprimir.createrecibo');
Route::post('printrecibo/imprimir', 'ReciboTicketController@imprimirRecibo')->name('imprimir.imprimirrecibo');
Route::post('printrecibo/imprimir2', 'ReciboTicketController@imprimirRecibo2')->name('imprimir.imprimirrecibo2');


//rutas de menu configuracion -->centros
Route::get('all/centrosprod', 'CentrosProdController@AllHoteles')->name('all.centrosprod');
Route::get('centrosprod', 'CentrosProdController@index')->name('centrosprod.index');
Route::get('centrosprod/create', 'CentrosProdController@create')->name('centrosprod.create');
Route::post('centrosprod/store', 'CentrosProdController@store')->name('centrosprod.store');
Route::get('centrosprod/{hotel}', 'CentrosProdController@show')->name('centrosprod.show');
Route::get('centrosprod/{hotel}/edit', 'CentrosProdController@edit')->name('centrosprod.edit');
Route::post('centrosprod/actualizar', 'CentrosProdController@actualizar')->name('centrosprod.actualizar');
Route::post('centrosprod/{hotel}', 'CentrosProdController@destroy')->name('centrosprod.destroy');

});
