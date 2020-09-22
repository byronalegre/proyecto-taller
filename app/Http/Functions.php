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
/*
function getLocalArray($id){
	switch($id){
		case '0':
		return 'Indeterminado';
		break;

		case '1':
		return 'Depósito 1';
		break;

		case '2':
		return 'Depósito 2';
		break;
	}
}
*/
function getRoleUsuarioArray($mode, $id){

	$roles = [
	'0'=>'Usuario común',	
	'1'=>'Administrador',
	'2'=>'Encargado del depósito',
	'3'=>'Encargado de compras'
	];

if(!is_null($mode)):
	return $roles;
else:
	return $roles[$id];
endif;
}


function getStatusUsuarioArray($mode, $id){	

	$estado = [
//	'0'=>'Registrado',
	'1'=>'Activo',
	'100'=>'Suspendido'
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
				'inicio'=>'Ver módulo de inicio. (¡No destildar! No le permitirá acceso a la pantalla de administración).',
				'estadisticas_rapidas'=>'Ver estadísticas.',
				'e_admin'=>'Ver estadísticas de administración.',
				'e_tareas'=>'Ver estadísticas de tareas.',	
				'e_compras'=>'Ver estadísticas de facturación.',
				'graficos'=>'Ver gráficos estadísticos.'
			]
		],

		'piezas'=>[
			'icon'=> '<i class="fas fa-cogs"></i>',
			'title'=> 'Módulo - Piezas',
			'keys'=>[
				'piezas'=>'Ver módulo piezas.',
				'piezas_agregar'=>'Agregar piezas.',
				'piezas_editar'=>'Editar piezas.',
				'piezas_eliminar'=>'Eliminar piezas.',
				'piezas_buscar'=>'Buscar piezas.',
				'piezas_pdf'=>'Generar PDFs.'
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

		'usuarios'=>[
			'icon'=> '<i class="fas fa-users"></i>',
			'title'=> 'Módulo - Usuarios',
			'keys'=>[
				'usuarios_list'=>'Ver módulo usuarios.',				
				'usuarios_editar'=>'Editar usuarios.',
				'usuarios_suspend'=>'Suspender usuarios.',
				'usuarios_permisos'=>'Permisos usuarios.',
				'usuarios_buscar'=>'Buscar usuarios.'
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

		'proveedores'=>[
			'icon'=> '<i class="fas fa-truck"></i>',
			'title'=> 'Módulo - Proveedores',
			'keys'=>[
				'proveedores'=>'Ver módulo proveedores.',
				'proveedores_agregar'=>'Agregar proveedores.',
				'proveedores_editar'=>'Editar proveedores.',
				'proveedores_eliminar'=>'Eliminar proveedores.',
				'proveedores_buscar'=>'Buscar proveedores.',
				'proveedores_pdf'=>'Generar PDFs.'
			]
		],
		
		'compras'=>[
			'icon'=>'<i class="fas fa-cart-plus"></i>',
			'title'=>'Módulo - Compras',
			'keys'=>[
				'compras'=>'Ver módulo compras.',
				'compras_agregar'=>'Agregar compra.',
				'compras_eliminar'=>'Anular compra.',
				'compra_detalle'=>'Ver detalle de compra.',
				'detalle_compra_pdf'=>'Generar PDFs.'
			]
		],

		'tareas'=>[
			'icon'=>'<i class="fas fa-tasks"></i>',
			'title'=>'Módulo - Tareas',
			'keys'=>[
				'tareas'=>'Ver módulo tareas.',
				'tareas_agregar'=>'Agregar tarea.',
				'tareas_editar'=>'Editar tarea.',
				'tareas_eliminar'=>'Anular tarea.',
				'tarea_detalle'=>'Ver detalle de tarea.',
				'detalle_tarea_pdf'=>'Generar PDFs.'
			]
		],

		'backup'=>[
			'icon'=>'<i class="fas fa-database"></i>',
			'title'=>'Módulo - Backup',
			'keys'=>[
				'backup'=>'Ver módulo backup.',
				'backup_create'=>'Crear backup.'
			]
		]
		
	];

	return $p;
}


