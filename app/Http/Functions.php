<?php  
//Valor de Clave de Json (Key Value Fromm Json)
function kvfj($json, $key){
	if($json == null):
		return null;
	else:
		$json= $json;
		$json=json_decode($json, true);
		if(array_key_exists($key, $json)):
			return $json[$key];

		else:
			return null;
			
		endif;
	endif;

}

function getSeccionArray(){
	$a = [
		'0' => 'Piezas',
		'1' => 'Marcas',
		'2' => 'Tareas'
	];

	return $a;
}

function getRoleUsuarioArray($mode, $id){

	$roles = [
		'0'=>'Usuario común',	
		'1'=>'Administrador',
		'2'=>'Encargado del depósito',
		'3'=>'Encargado de compras',
		'4'=>'Encargado de tareas'
	];

if(!is_null($mode)):
	return $roles;
else:
	return $roles[$id];
endif;
}


function getStatusUsuarioArray($mode, $id){	

	$estado = [
		'1'=>'Habilitado',
		'100'=>'Deshabilitado'
	];

if(!is_null($mode)):
	return $estado;
else:
	return $estado[$id];
endif;
}

function permisos_usuario(){
	$p = [
		'inicio'=>[
			'icon'=> '<i class="fas fa-home"></i>',
			'title'=> 'Módulo - Inicio',
			'keys'=>[
				'inicio'=>'Ver módulo de inicio. (Destildar SOLO cuando el sistema se encuentre en Mantenimiento).',
				'estadisticas_rapidas'=>'Ver estadísticas.',				
				'e_tareas'=>'Ver estadísticas de tareas.',	
				'e_compras'=>'Ver estadísticas de facturación.',
				'graficos'=>'Ver gráficos estadísticos.'
			]
		],

		'micuenta'=>[
			'icon'=> '<i class="fas fa-user-circle"></i>',
			'title'=> 'Módulo - Mi cuenta',
			'keys'=>[				
				'micuenta_editar'=>'Editar Mi cuenta.',
				'micuenta_password' => 'Cambiar contraseña.',
				'micuenta_info' => 'Cambiar datos personales.'
			]
		],

		'piezas'=>[
			'icon'=> '<i class="fas fa-cog"></i>',
			'title'=> 'Módulo - Piezas',
			'keys'=>[
				'piezas'=>'Ver módulo piezas.',
				'piezas_agregar'=>'Agregar piezas.',
				'piezas_eliminar'=>'Eliminar piezas.',
				'pieza_detalle'=>'Detalle piezas.',
				'piezas_editar'=>'Editar piezas.',		
				'piezas_pdf'=>'Generar PDFs.',
				'historia'=>'Historial de cambios.',
				'historia_precio'=>'Historial de precios.',
				'historia_detalle'=>'Detalle historial de cambios.'
			]
		],

		'categorias'=>[
			'icon'=> '<i class="fas fa-tags"></i>',
			'title'=> 'Módulo - Categorías',
			'keys'=>[
				'categorias'=>'Ver módulo categorías.',
				'categorias_agregar'=>'Agregar categorías.',
				'categorias_editar'=>'Editar categorías.',
				'categorias_eliminar'=>'Eliminar categorías.',
			]
		],

		'proveedores'=>[
			'icon'=> '<i class="fas fa-truck"></i>',
			'title'=> 'Módulo - Proveedores',
			'keys'=>[
				'proveedores'=>'Ver módulo proveedores.',
				'proveedores_agregar'=>'Agregar proveedores.',
				'proveedores_editar'=>'Editar proveedores.',
				'proveedores_eliminar'=>'Eliminar proveedores.',
				'proveedores_pdf'=>'Generar PDFs.'
			]
		],

		'pedidos'=>[
			'icon'=>'<i class="fas fa-file-invoice"></i>',
			'title'=>'Módulo - Ordenes de Pedido',
			'keys'=>[
				'pedidos'=>'Ver módulo ordenes de pedido.',
				'pedidos_agregar'=>'Agregar orden de pedido.',				
				'pedidos_eliminar'=>'Anular orden de pedido.',
				'pedido_detalle'=>'Ver detalle de orden de pedido.',
				'pedidos_editar'=>'Editar orden de pedido.',
				'detalle_pedido_pdf'=>'Generar PDFs.'
			]
		],

		'compras'=>[
			'icon'=>'<i class="fas fa-cart-plus"></i>',
			'title'=>'Módulo - Ordenes de Compra',
			'keys'=>[
				'compras'=>'Ver módulo ordenes de compra.',
				'compras_agregar'=>'Agregar orden de compra.',				
				'compras_eliminar'=>'Anular orden de compra.',
				'compra_detalle'=>'Ver detalle de orden de compra.',
				'compras_editar'=>'Editar orden de compra.',
				'detalle_compra_pdf'=>'Generar PDFs.'
			]
		],

		'remitos'=>[
			'icon'=>'<i class="fas fa-file-invoice-dollar"></i>',
			'title'=>'Módulo - Remitos',
			'keys'=>[
				'remitos'=>'Ver módulo remitos.',
				'remitos_agregar'=>'Agregar remito.',
				'remitos_eliminar'=>'Anular remito.',
				'remito_detalle'=>'Ver detalle de remito.',
				'detalle_remito_pdf'=>'Generar PDFs.'
			]
		],

		'tareas'=>[
			'icon'=>'<i class="fas fa-tasks"></i>',
			'title'=>'Módulo - Tareas',
			'keys'=>[
				'tareas'=>'Ver módulo tareas.',
				'tareas_agregar'=>'Agregar tarea.',				
				'tareas_eliminar'=>'Anular tarea.',
				'tarea_detalle'=>'Ver detalle de tarea.',
				'tareas_editar'=>'Editar tarea.',
				'detalle_tarea_pdf'=>'Generar PDFs.'
			]
		],

		'usuarios'=>[
			'icon'=> '<i class="fas fa-users"></i>',
			'title'=> 'Módulo - Usuarios',
			'keys'=>[
				'usuarios_list'=>'Ver módulo usuarios.',					
				'usuarios_register'=>'Registrar usuarios.',			
				'usuarios_editar'=>'Editar usuarios.',
				'usuarios_suspend'=>'Suspender usuarios.',
				'usuarios_permisos'=>'Permisos usuarios.',
			]
		],

		'backup'=>[
			'icon'=>'<i class="fas fa-database"></i>',
			'title'=>'Módulo - Backup',
			'keys'=>[
				'backup'=>'Ver módulo backup.',
				'backup_create'=>'Crear backups.',
				'backup_dowload'=>'Descargar backups.',
				'backup_delete'=>'Eliminar backups.',
			]
		],

		'config'=>[
			'icon'=>'<i class="fas fa-wrench"></i>',
			'title'=>'Módulo - Configuración',
			'keys'=>[
				'config'=>'Ver módulo configuración.'
			]
		]
		
	];

	return $p;
}


