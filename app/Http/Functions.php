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
		'1' => 'Marcas'
	];

	return $a;
}

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
	'0'=>'Registrado',
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
		'Panel_controller'=>[
			'icon'=> '<i class="fas fa-home"></i>',
			'title'=> 'Módulo - Panel de inicio',
			'keys'=>[
				'Panel_controller'=>'Ver panel de inicio.',
				'estadisticas_rapidas'=>'Ver estadísticas globales.',
				'facturado'=>'Ver estadísticas de facturación.'
			]
		],

		'piezas'=>[
			'icon'=> '<i class="fas fa-cogs"></i>',
			'title'=> 'Módulo - Piezas',
			'keys'=>[
				'piezas'=>'Ver piezas.',
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
				'categorias'=>'Ver categorías.',
				'categorias_agregar'=>'Agregar categorías.',
				'categorias_editar'=>'Editar categorías.',
				'categorias_eliminar'=>'Eliminar categorías.',
			]
		],

		'usuarios'=>[
			'icon'=> '<i class="fas fa-users"></i>',
			'title'=> 'Módulo - Usuarios',
			'keys'=>[
				'usuarios_list'=>'Ver usuarios.',				
				'usuarios_editar'=>'Editar usuarios.',
				'usuarios_suspend'=>'Suspender usuarios.',
				'usuarios_permisos'=>'Permisos usuarios.',
				'usuarios_buscar'=>'Buscar usuarios.',
				'micuenta_editar'=>'Editar Mi cuenta.',
				'micuenta_password' => 'Cambiar contraseña.',
				'micuenta_info' => 'Cambiar datos personales.'
			]
		],

		'proveedores'=>[
			'icon'=> '<i class="fas fa-truck"></i>',
			'title'=> 'Módulo - Proveedores',
			'keys'=>[
				'proveedores'=>'Ver proveedores.',
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
				'compras'=>'Ver compras.',
				'compras_agregar'=>'Agregar compra.',
				'compras_eliminar'=>'Anular compra.',
				'compra_detalle'=>'Ver detalle de compra.',
				'detalle_pdf'=>'Generar PDFs.'
			]
		]
	];

	return $p;
}


