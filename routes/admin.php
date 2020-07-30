<?php 

Route::prefix('/admin')->group(function(){
	//Panel
	Route::get('/','Admin\PanelController@getPanel')->name('Panel_controller');

	//Usuarios
	Route::get('/usuarios/{status}','Admin\UsuariosController@getUsuarios')->name('usuarios_list') ;
	Route::get('/usuarios/{id}/edit','Admin\UsuariosController@getUsuarioEdit')->name('usuarios_editar');
	Route::post('/usuarios/{id}/edit','Admin\UsuariosController@postUsuarioEdit')->name('usuarios_editar');
	Route::post('/usuarios/buscar','Admin\UsuariosController@postUsuarioBuscar')->name('usuarios_buscar');
	Route::get('/usuarios/{id}/suspend','Admin\UsuariosController@getUsuarioSuspend')->name('usuarios_suspend');
	Route::get('/usuarios/{id}/permisos','Admin\UsuariosController@getUsuarioPermisos')->name('usuarios_permisos');
	Route::post('/usuarios/{id}/permisos','Admin\UsuariosController@postUsuarioPermisos')->name('usuarios_permisos');

	//Piezas
	Route::get('/piezas/agregar','Admin\PiezaController@getPiezaAgregar')->name('piezas_agregar');
	Route::get('/piezas/{id}/edit','Admin\PiezaController@getPiezaEdit')->name('piezas_editar');
	Route::get('/piezas/{id}/delete','Admin\PiezaController@getPiezaDelete')->name('piezas_eliminar');
	Route::get('/piezas/{id}/restore','Admin\PiezaController@getPiezaRestore')->name('piezas_eliminar');
	Route::post('/piezas/agregar','Admin\PiezaController@postPiezaAgregar')->name('piezas_agregar');
	Route::post('/piezas/buscar','Admin\PiezaController@postPiezaBuscar')->name('piezas_buscar');
	Route::get('/piezas/{status}','Admin\PiezaController@getHome')->name('piezas');
	Route::post('/piezas/{id}/edit','Admin\PiezaController@postPiezaEdit')->name('piezas_editar') ;
	

	//Categorias
	Route::get('/categorias/{seccion}','Admin\CategoriasController@getHome')->name('categorias') ; 
	Route::post('/categorias/agregar','Admin\CategoriasController@postCategoriaAgregar')->name('categorias_agregar') ;
	Route::get('/categorias/{id}/edit','Admin\CategoriasController@getCategoriaEdit')->name('categorias_editar') ;
	Route::post('/categorias/{id}/edit','Admin\CategoriasController@postCategoriaEdit')->name('categorias_editar') ;
	Route::get('/categorias/{id}/delete','Admin\CategoriasController@getCategoriaDelete')->name('categorias_eliminar') ;

	//Proveedores
	Route::get('/proveedores/agregar','Admin\ProveedoresController@getProveedorAgregar')->name('proveedores_agregar');
	Route::post('/proveedores/buscar','Admin\ProveedoresController@postProveedorBuscar')->name('proveedores_buscar');
	Route::get('/proveedores/{status}','Admin\ProveedoresController@getHome')->name('proveedores');
	Route::post('/proveedores/agregar','Admin\ProveedoresController@postProveedorAgregar')->name('proveedores_agregar');
	Route::get('/proveedores/{id}/edit','Admin\ProveedoresController@getProveedorEdit')->name('proveedores_editar');
	Route::post('/proveedores/{id}/edit','Admin\ProveedoresController@postProveedorEdit')->name('proveedores_editar');
	Route::get('/proveedores/{id}/delete','Admin\ProveedoresController@getProveedorDelete')->name('proveedores_eliminar');
	Route::get('/proveedores/{id}/restore','Admin\ProveedoresController@getProveedorRestore')->name('proveedores_eliminar');
	
	

}); 