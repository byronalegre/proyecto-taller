<div class="col-md-4 d-flex">
	<div class="panel shadow">
		<div class="header">
			<h2 class="title"><i class="fas fa-tags"></i> Módulo de Categorías</h2>
		</div>
		<div class="inside">
				<div class="form-check">
					<input type="checkbox" value="true" name="categorias" <?php if(kvfj($u->permisos,'categorias')): ?> checked <?php endif; ?>>
					<label for="categorias">Ver lista de categorias.</label>
				</div>
				<div class="form-check">
					<input type="checkbox" value="true" name="categorias_agregar" <?php if(kvfj($u->permisos,'categorias_agregar')): ?> checked <?php endif; ?>>
					<label for="categorias_agregar">Agregar categorias.</label>
				</div>
				<div class="form-check">
					<input type="checkbox" value="true" name="categorias_editar" <?php if(kvfj($u->permisos,'categorias_editar')): ?> checked <?php endif; ?>>
					<label for="categorias_editar">Editar categorias.</label>
				</div>
				<div class="form-check">
					<input type="checkbox" value="true" name="categorias_eliminar" <?php if(kvfj($u->permisos,'categorias_eliminar')): ?> checked <?php endif; ?>>
					<label for="categorias_eliminar">Eliminar categorias.</label>
				</div>
		</div>
	</div> 
</div><?php /**PATH G:\www\cms\resources\views/admin/usuarios/permisos/modulo_categorias.blade.php ENDPATH**/ ?>