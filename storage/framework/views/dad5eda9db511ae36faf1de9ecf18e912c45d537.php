<div class="col-md-4 d-flex">
	<div class="panel shadow">
		<div class="header">
			<h2 class="title"><i class="fas fa-truck"></i> Módulo de Proveedores</h2>
		</div>
		<div class="inside">
				<div class="form-check">
					<input type="checkbox" value="true" name="proveedores" <?php if(kvfj($u->permisos,'proveedores')): ?> checked <?php endif; ?>>
					<label for="proveedores">Ver lista de proveedores.</label>
				</div>
				<div class="form-check">
					<input type="checkbox" value="true" name="proveedores_agregar" <?php if(kvfj($u->permisos,'proveedores_agregar')): ?> checked <?php endif; ?>>
					<label for="proveedores_agregar">Agregar proveedores.</label>
				</div>
				<div class="form-check">
					<input type="checkbox" value="true" name="proveedores_editar" <?php if(kvfj($u->permisos,'proveedores_editar')): ?> checked <?php endif; ?>>
					<label for="proveedores_editar">Editar proveedores.</label>
				</div>
				<div class="form-check">
					<input type="checkbox" value="true" name="proveedores_eliminar" <?php if(kvfj($u->permisos,'proveedores_eliminar')): ?> checked <?php endif; ?>>
					<label for="proveedores_eliminar">Eliminar proveedores.</label>
				</div>
				<div class="form-check">
					<input type="checkbox" value="true" name="proveedores_buscar" <?php if(kvfj($u->permisos,'proveedores_buscar')): ?> checked <?php endif; ?>>
					<label for="proveedores_buscar">Buscar proveedores.</label>
				</div>
		</div>
	</div> 
</div><?php /**PATH G:\www\cms\resources\views/admin/usuarios/permisos/modulo_proveedores.blade.php ENDPATH**/ ?>