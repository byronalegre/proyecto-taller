<div class="col-md-4 d-flex">
	<div class="panel shadow">
		<div class="header">
			<h2 class="title"><i class="fas fa-users"></i> Módulo de Usuarios</h2>
		</div>
		<div class="inside">
				<div class="form-check">
					<input type="checkbox" value="true" name="usuarios_list" <?php if(kvfj($u->permisos,'usuarios_list')): ?> checked <?php endif; ?>>
					<label for="usuarios_list">Ver lista de usuarios.</label>
				</div>
				<div class="form-check">
					<input type="checkbox" value="true" name="usuarios_editar" <?php if(kvfj($u->permisos,'usuarios_editar')): ?> checked <?php endif; ?>>
					<label for="usuarios_editar">Ver información de usuarios.</label>
				</div>
				<div class="form-check">
					<input type="checkbox" value="true" name="usuarios_suspend" <?php if(kvfj($u->permisos,'usuarios_suspend')): ?> checked <?php endif; ?>>
					<label for="usuarios_suspend">Suspender usuarios.</label>
				</div>
				<div class="form-check">
					<input type="checkbox" value="true" name="usuarios_permisos" <?php if(kvfj($u->permisos,'usuarios_permisos')): ?> checked <?php endif; ?>>
					<label for="usuarios_permisos">Permisos de usuarios.</label>
				</div>
				
		</div>
	</div> 
</div><?php /**PATH G:\www\cms\resources\views/admin/usuarios/permisos/modulo_usuarios.blade.php ENDPATH**/ ?>