<?php 

Route::prefix('/admin')->group(function(){
	//Panel de inicio
	Route::get('/','Admin\PanelController@getPanel')->name('inicio');

	//Configuración
	Route::get('/config','Admin\ConfigController@getHome')->name('config');
	Route::post('/config','Admin\ConfigController@postHome')->name('config');

	//Usuarios
	Route::get('/usuarios/register','Admin\UsuariosController@getRegister')->name('usuarios_register');
	Route::post('/usuarios/register','Admin\UsuariosController@postRegister')->name('usuarios_register');
	Route::get('/usuarios/{status}','Admin\UsuariosController@getUsuarios')->name('usuarios_list') ;
	Route::get('/usuarios/{status}/{campo}'.'='.'{direc}','Admin\UsuariosController@order')->name('usuarios_ordenar') ;
	Route::get('/usuarios/{id}/edit','Admin\UsuariosController@getUsuarioEdit')->name('usuarios_editar');
	Route::post('/usuarios/{id}/edit','Admin\UsuariosController@postUsuarioEdit')->name('usuarios_editar');
	Route::get('/usuarios/{id}/suspend','Admin\UsuariosController@getUsuarioSuspend')->name('usuarios_suspend');
	Route::get('/usuarios/{id}/permisos','Admin\UsuariosController@getUsuarioPermisos')->name('usuarios_permisos');
	Route::post('/usuarios/{id}/permisos','Admin\UsuariosController@postUsuarioPermisos')->name('usuarios_permisos');

	//Piezas	
	Route::get('/piezas/agregar','Admin\PiezaController@getPiezaAgregar')->name('piezas_agregar');
	Route::get('/piezas/{id}/edit','Admin\PiezaController@getPiezaEdit')->name('piezas_editar');
	Route::get('/piezas/{id}/delete','Admin\PiezaController@getPiezaDelete')->name('piezas_eliminar');
	Route::get('/piezas/{id}/restore','Admin\PiezaController@getPiezaRestore')->name('piezas_eliminar');
	Route::post('/piezas/agregar','Admin\PiezaController@postPiezaAgregar')->name('piezas_agregar');
	Route::get('/piezas/{id}/detalle/historia_cambio', 'Admin\HistoriaPiezasController@getHome')->name('historia');//HISTORIA
	Route::get('/piezas/{id_p}/detalle/historia_cambio/{id_d}/detalle', 'Admin\HistoriaPiezasController@getHistoriaDetalle')->name('historia_detalle');//HISTORIA
	Route::get('/piezas/{id}/detalle/historia_precio', 'Admin\HistoriaPiezasController@getHistoriaPrecio')->name('historia_precio');
	Route::get('/piezas/{status}','Admin\PiezaController@getHome')->name('piezas');
	Route::get('/piezas/{status}/{campo}'.'='.'{direc}','Admin\PiezaController@order')->name('piezas_ordenar');
	Route::get('/piezas/{id}/detalle','Admin\PiezaController@getPiezaDetalle')->name('pieza_detalle');
	Route::post('/piezas/{id}/edit','Admin\PiezaController@postPiezaEdit')->name('piezas_editar') ;
	Route::get('pdf-piezas', 'Admin\PiezaController@pdf')->name('piezas_pdf');//pdf
	Route::get('pdf-stock-piezas', 'Admin\PiezaController@pdfStock')->name('piezas_pdf_stock');//pdf-stock

	//Categorias
	Route::get('/categorias/{seccion}','Admin\CategoriasController@getHome')->name('categorias') ; 
	Route::post('/categorias/agregar','Admin\CategoriasController@postCategoriaAgregar')->name('categorias_agregar') ;
	Route::get('/categorias/{id}/edit','Admin\CategoriasController@getCategoriaEdit')->name('categorias_editar') ;
	Route::post('/categorias/{id}/edit','Admin\CategoriasController@postCategoriaEdit')->name('categorias_editar') ;
	Route::get('/categorias/{id}/delete','Admin\CategoriasController@getCategoriaDelete')->name('categorias_eliminar') ;

	//Proveedores
	Route::get('/proveedores/agregar','Admin\ProveedoresController@getProveedorAgregar')->name('proveedores_agregar');
	Route::get('/proveedores/{status}','Admin\ProveedoresController@getHome')->name('proveedores');
	Route::get('/proveedores/{status}/{campo}'.'='.'{direc}','Admin\ProveedoresController@order')->name('proveedores_ordenar');
	Route::post('/proveedores/agregar','Admin\ProveedoresController@postProveedorAgregar')->name('proveedores_agregar');
	Route::get('/proveedores/{id}/edit','Admin\ProveedoresController@getProveedorEdit')->name('proveedores_editar');
	Route::post('/proveedores/{id}/edit','Admin\ProveedoresController@postProveedorEdit')->name('proveedores_editar');
	Route::get('/proveedores/{id}/delete','Admin\ProveedoresController@getProveedorDelete')->name('proveedores_eliminar');
	Route::get('/proveedores/{id}/restore','Admin\ProveedoresController@getProveedorRestore')->name('proveedores_eliminar');
	Route::get('pdf-proveedores', 'Admin\ProveedoresController@pdf')->name('proveedores_pdf');//pdf

	//Mi cuenta
	Route::get('/micuenta/edit','Admin\UsuariosController@getMiCuentaEdit')->name('micuenta_editar');
	Route::post('/micuenta/edit/password','Admin\UsuariosController@postMiCuentaPassword')->name('micuenta_password');
	Route::post('/micuenta/edit/info','Admin\UsuariosController@postMiCuentaInfo')->name('micuenta_info');	

	//Ordenes de compra
	Route::get('/ordenescompra/agregar/{id}','Admin\OrdenesCompraController@getOrdenCompraAgregarDirecto')->name('compras_agregar_directo');		
	Route::post('/ordenescompra/agregar/{id}','Admin\OrdenesCompraController@postOrdenCompraAgregarDirecto')->name('compras_agregar_directo');
	Route::get('/ordenescompra/agregar','Admin\OrdenesCompraController@getOrdenCompraAgregar')->name('compras_agregar');		
	Route::post('/ordenescompra/agregar','Admin\OrdenesCompraController@postOrdenCompraAgregar')->name('compras_agregar');	
	Route::get('/ordenescompra/{id}/edit','Admin\OrdenesCompraController@getOrdenCompraEdit')->name('compras_editar');
	Route::post('/ordenescompra/{id}/edit','Admin\OrdenesCompraController@postOrdenCompraEdit')->name('compras_editar');
	Route::get('/ordenescompra/reporte_ordenescompra_pdf', 'Admin\OrdenesCompraController@OrdenComprapdf')->name('reporte_compras_pdf');//pdf
	Route::get('/ordenescompra/reporte_ordenescompra_mes_pdf', 'Admin\OrdenesCompraController@OrdenCompraMespdf')->name('reporte_compras_mes_pdf');//pdf
	Route::get('/ordenescompra/reporte_ordenescompra_ano_pdf', 'Admin\OrdenesCompraController@OrdenCompraAnopdf')->name('reporte_compras_ano_pdf');//pdf
	Route::get('/ordenescompra/{status}','Admin\OrdenesCompraController@getHome')->name('compras');	
	Route::get('/ordenescompra/{status}/{campo}'.'='.'{direc}','Admin\OrdenesCompraController@order')->name('compras_ordenar');	
	Route::get('/ordenescompra/{id}/detalle', 'Admin\OrdenesCompraController@getOrdenCompraDetalle')->name('compra_detalle');
	Route::get('/ordenescompra/{id}/detalle/ordencompra_pdf', 'Admin\OrdenesCompraController@pdf')->name('detalle_compra_pdf');//pdf
	Route::get('/ordenescompra/{id}/delete','Admin\OrdenesCompraController@getOrdenCompraDelete')->name('compras_eliminar');
	Route::get('/ordenescompra/{id}/restore','Admin\OrdenesCompraController@getOrdenCompraRestore')->name('compras_eliminar');

	//Remitos
	Route::get('/remitos/agregar/{id}','Admin\RemitosController@getRemitoAgregarDirecto')->name('remitos_agregar_directo');		
	Route::post('/remitos/agregar/{id}','Admin\RemitosController@postRemitoAgregarDirecto')->name('remitos_agregar_directo');
	Route::get('/remitos/agregar','Admin\RemitosController@getRemitoAgregar')->name('remitos_agregar');		
	Route::post('/remitos/agregar','Admin\RemitosController@postRemitoAgregar')->name('remitos_agregar');
	Route::get('/remitos/reporte_remitos_pdf', 'Admin\RemitosController@RemitosPdf')->name('reporte_remitos_pdf');//pdf
	Route::get('/remitos/reporte_remitos_mes_pdf', 'Admin\RemitosController@RemitosMesPdf')->name('reporte_remitos_mes_pdf');//pdf
	Route::get('/remitos/reporte_remitos_ano_pdf', 'Admin\RemitosController@RemitosAnoPdf')->name('reporte_remitos_ano_pdf');//pdf
	Route::get('/remitos/{status}','Admin\RemitosController@getHome')->name('remitos');	
	Route::get('/remitos/{status}/{campo}'.'='.'{direc}','Admin\RemitosController@order')->name('remitos_ordenar');	
	Route::get('/remitos/{id}/detalle', 'Admin\RemitosController@getRemitoDetalle')->name('remito_detalle');
	Route::get('/remitos/{id}/detalle/remito_pdf', 'Admin\RemitosController@pdf')->name('detalle_remito_pdf');//pdf	
	Route::get('/remitos/{id}/delete','Admin\RemitosController@getRemitosDelete')->name('remitos_eliminar');
	Route::get('/remitos/{id}/restore','Admin\RemitosController@getRemitosRestore')->name('remitos_eliminar');

	//Ordenes de pedido
	Route::get('/ordenespedido/agregar','Admin\OrdenesPedidoController@getOrdenPedidoAgregar')->name('pedidos_agregar');		
	Route::post('/ordenespedido/agregar','Admin\OrdenesPedidoController@postOrdenPedidoAgregar')->name('pedidos_agregar');	
	Route::get('/ordenespedido/{id}/edit','Admin\OrdenesPedidoController@getOrdenPedidoEdit')->name('pedidos_editar');
	Route::post('/ordenespedido/{id}/edit','Admin\OrdenesPedidoController@postOrdenPedidoEdit')->name('pedidos_editar');
	Route::get('/ordenespedido/reporte_ordenespedido_pdf', 'Admin\OrdenesPedidoController@OrdenPedidopdf')->name('reporte_pedidos_pdf');//pdf
	Route::get('/ordenespedido/reporte_ordenespedido_mes_pdf', 'Admin\OrdenesPedidoController@OrdenPedidoMespdf')->name('reporte_pedidos_mes_pdf');//pdf
	Route::get('/ordenespedido/reporte_ordenespedido_ano_pdf', 'Admin\OrdenesPedidoController@OrdenPedidoAnopdf')->name('reporte_pedidos_ano_pdf');//pdf
	Route::get('/ordenespedido/{status}','Admin\OrdenesPedidoController@getHome')->name('pedidos');
	Route::get('/ordenespedido/{status}/{campo}'.'='.'{direc}','Admin\OrdenesPedidoController@order')->name('pedidos_ordenar');	
	Route::get('/ordenespedido/{id}/detalle', 'Admin\OrdenesPedidoController@getOrdenPedidoDetalle')->name('pedido_detalle');
	Route::get('/ordenespedido/{id}/detalle/ordenpedido_pdf', 'Admin\OrdenesPedidoController@pdf')->name('detalle_pedido_pdf');//pdf
	Route::get('/ordenespedido/{id}/delete','Admin\OrdenesPedidoController@getOrdenPedidoDelete')->name('pedidos_eliminar');
	Route::get('/ordenespedido/{id}/restore','Admin\OrdenesPedidoController@getOrdenPedidoRestore')->name('pedidos_eliminar');

	//Tareas
	Route::get('/tareas/agregar','Admin\TareasController@getTareaAgregar')->name('tareas_agregar');		
	Route::post('/tareas/agregar','Admin\TareasController@postTareaAgregar')->name('tareas_agregar');
	Route::get('/tareas/{id}/edit','Admin\TareasController@getTareaEdit')->name('tareas_editar');
	Route::post('/tareas/{id}/edit','Admin\TareasController@postTareaEdit')->name('tareas_editar');
	Route::get('/tareas/{id}/complete','Admin\TareasController@getTareaComplete')->name('tareas_completar');
	Route::post('/tareas/{id}/complete','Admin\TareasController@postTareaComplete')->name('tareas_completar');
	Route::get('/tareas/reporte_tareas_pdf', 'Admin\TareasController@Tareaspdf')->name('reporte_tareas_pdf');//pdf
	Route::get('/tareas/reporte_tareas_mes_pdf', 'Admin\TareasController@TareasMespdf')->name('reporte_tareas_mes_pdf');//pdf
	Route::get('/tareas/reporte_tareas_ano_pdf', 'Admin\TareasController@TareasAnopdf')->name('reporte_tareas_ano_pdf');//pdf
	Route::get('/tareas/{status}','Admin\TareasController@getHome')->name('tareas');
	Route::get('/tareas/{status}/{campo}'.'='.'{direc}','Admin\TareasController@order')->name('tareas_ordenar');	
	Route::get('/tareas/{id}/detalle', 'Admin\TareasController@getTareaDetalle')->name('tarea_detalle');
	Route::get('/tareas/{id}/detalle/tarea_pdf', 'Admin\TareasController@pdf')->name('detalle_tarea_pdf');//pdf
	Route::get('/tareas/{id}/delete','Admin\TareasController@getTareasDelete')->name('tareas_eliminar');
	Route::get('/tareas/{id}/restore','Admin\TareasController@getTareasRestore')->name('tareas_eliminar');

	//BackUp
	Route::get('/backup', 'Admin\BackUpController@index')->name('backup');
	Route::get('/backup/create', 'Admin\BackUpController@create')->name('backup_create');
	Route::get('/backup/dowload/{name}', 'Admin\BackUpController@dowload')->name('backup_dowload');
	Route::get('/backup/delete/{name}', 'Admin\BackUpController@delete')->name('backup_delete');

	//API JSON
	Route::get('/md/api/load/piezas-OP-T', 'Admin\ApiJsController@getItems');
	Route::get('/md/api/load/piezas-R-OC', 'Admin\ApiJsController@getAll');
	Route::get('/md/api/load/{id}/precios', 'Admin\ApiJsController@getPrecios');

	//DataTable
	// Route::get('datatable/piezas/{status}', 'Admin\DataTableController@piezas')->name('piezas');


}); 
	