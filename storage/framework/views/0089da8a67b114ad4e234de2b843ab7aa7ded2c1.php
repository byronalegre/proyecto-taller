<div class="sidebar shadow-lg">
	<div class="section-top">
		
			<button type="button" class="btn-close btn-close-white" onclick="cerrar()" aria-label="Close"></button>

			<div class="logo">
				<a href="/admin"><img src="<?php echo e(url('static/images/logo1.png')); ?>" alt="img-fluid" width="50">
				</a>								
			</div>	
			
	
			<div class="user">
				
				<h6>
					<span class="badge bg-secondary shadow" style="width: 100%">
					<?php echo e(getRoleUsuarioArray(null, Auth::user()->role)); ?>

					</span>
				</h6>
			
			</div>
	</div>
	
	<div class="main">
		<ul>
			<?php if(kvfj(Auth::user()->permisos, 'inicio')): ?>
			<li>
				<a href="<?php echo e(url('/admin')); ?> " class="lk-inicio"><i class="fas fa-home"></i> Inicio</a>
			</li>
			<?php endif; ?>
			
			<?php if(kvfj(Auth::user()->permisos, 'piezas')): ?>
			<li>
				<a href="<?php echo e(url('/admin/piezas/1')); ?> " class="lk-piezas lk-piezas_agregar lk-piezas_editar lk-piezas_buscar lk-piezas_eliminar lk-pieza_detalle lk-historia lk-historia_detalle lk-historia_precio"><i class="fas fa-cog"></i> Piezas</a>
			</li>
			<?php endif; ?>

			<?php if(kvfj(Auth::user()->permisos, 'categorias')): ?>
			<li>
				<a href="<?php echo e(url('/admin/categorias/0')); ?> " class="lk-categorias lk-categorias_agregar lk-categorias_editar lk-categorias_eliminar"><i class="fas fa-tags"></i> Categorías</a>
			</li>
			<?php endif; ?>			

			<?php if(kvfj(Auth::user()->permisos, 'proveedores')): ?>
			<li>
				<a href="<?php echo e(url('/admin/proveedores/all')); ?>" class="lk-proveedores lk-proveedores_agregar lk-proveedores_editar lk-proveedores_eliminar lk-proveedores_buscar"><i class="fas fa-truck"></i> Proveedores</a>
			</li>
			<?php endif; ?>				

			<?php if(kvfj(Auth::user()->permisos, 'pedidos')): ?>
			<li>
				<a href="<?php echo e(url('/admin/ordenespedido/all')); ?>" class="lk-pedidos lk-pedidos_agregar lk-pedidos_editar lk-pedido_detalle lk-pedidos_eliminar"><i class="fas fa-file-invoice"></i> Ordenes de Pedido</a>
			</li>
			<?php endif; ?>

			<?php if(kvfj(Auth::user()->permisos, 'compras')): ?>
			<li>
				<a href="<?php echo e(url('/admin/ordenescompra/all')); ?>" class="lk-compras lk-compras_agregar lk-compras_agregar_directo lk-compras_editar lk-compra_detalle lk-compras_eliminar"><i class="fas fa-cart-plus"></i> Ordenes de Compra</a>
			</li>
			<?php endif; ?>	
			
			<?php if(kvfj(Auth::user()->permisos, 'remitos')): ?>
			<li>
				<a href="<?php echo e(url('/admin/remitos/all')); ?>" class="lk-remitos lk-remitos_agregar lk-remito_detalle lk-remitos_eliminar lk-remitos_agregar_directo"><i class="fas fa-file-invoice-dollar"></i> Remitos</a>
			</li>
			<?php endif; ?>

			<?php if(kvfj(Auth::user()->permisos, 'tareas')): ?>
			<li>
				<a href="<?php echo e(url('/admin/tareas/all')); ?>" class="lk-tareas lk-tareas_agregar lk-tareas_eliminar lk-tarea_detalle lk-tareas_editar lk-tareas_completar"><i class="fas fa-tasks"></i> Tareas</a>
			</li>
			<?php endif; ?>

			<?php if(kvfj(Auth::user()->permisos, 'usuarios_list')): ?>
			<li>
				<a href="<?php echo e(url('/admin/usuarios/all')); ?> " class="lk-usuarios_list lk-usuarios_editar lk-usuarios_suspend lk-usuarios_permisos lk-usuarios_buscar lk-usuarios_register"><i class="fas fa-users"></i> Usuarios</a>			
			</li>
			<?php endif; ?>

			<?php if(kvfj(Auth::user()->permisos, 'backup')): ?>
			<li>
				<a href="<?php echo e(url('/admin/backup')); ?>" class="lk-backup"><i class="fas fa-database"></i> Copias de seguridad</a>
			</li>
			<?php endif; ?>
			
			<?php if(kvfj(Auth::user()->permisos, 'config')): ?>
			<li>
				<a href="<?php echo e(url('/admin/config')); ?>" class="lk-config"><i class="fas fa-wrench"></i> Configuración</a>
			</li>
			<?php endif; ?>

			<li>
				<a href= "<?php echo e(url('https://github.com/byronalegre/proyecto-taller')); ?>" target="_blank"><i class="far fa-question-circle"></i> Ayuda</a>
			</li>
			<li></li>
		</ul>
	</div>
</div><?php /**PATH G:\www\cms\resources\views/admin/sidebar.blade.php ENDPATH**/ ?>