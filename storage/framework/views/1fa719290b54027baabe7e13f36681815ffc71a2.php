<div class="col-md-4 d-flex">
	<div class="panel shadow">
		<div class="header">
			<h2 class="title"><i class="fas fa-cogs"></i> Módulo de Piezas</h2>
		</div>
		<div class="inside">

			<div class="form-check">
				<input type="checkbox" value="true" name="piezas" <?php if(kvfj($u->permisos,'piezas')): ?> checked <?php endif; ?>>
				<label for="piezas">Ver lista de piezas.</label>
			</div>

			<div class="form-check">
				<input type="checkbox" value="true" name="piezas_agregar" <?php if(kvfj($u->permisos,'piezas_agregar')): ?> checked <?php endif; ?>>
				<label for="piezas_agregar">Agregar piezas.</label>
			</div>

			<div class="form-check">
				<input type="checkbox" value="true" name="piezas_editar" <?php if(kvfj($u->permisos,'piezas_editar')): ?> checked <?php endif; ?>>
				<label for="piezas_editar">Editar piezas.</label>
			</div>

			<div class="form-check">
				<input type="checkbox" value="true" name="piezas_buscar" <?php if(kvfj($u->permisos,'piezas_buscar')): ?> checked <?php endif; ?>>
				<label for="piezas_buscar">Buscar piezas.</label>
			</div>	

			<div class="form-check">
				<input type="checkbox" value="true" name="piezas_eliminar" <?php if(kvfj($u->permisos,'piezas_eliminar')): ?> checked <?php endif; ?>>
				<label for="piezas_eliminar">Eliminar piezas.</label>
			</div>	
			
		</div>
	</div> 
</div><?php /**PATH G:\www\cms\resources\views/admin/usuarios/permisos/modulo_piezas.blade.php ENDPATH**/ ?>