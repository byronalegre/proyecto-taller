<div class="col-md-4 d-flex">
	<div class="panel shadow">
		<div class="header">
			<h2 class="title"><i class="fas fa-home"></i> Módulo Panel de inicio</h2>
		</div>
		<div class="inside">
			<div class="form-check">
				<input type="checkbox" value="true" name="Panel_controller" <?php if(kvfj($u->permisos,'Panel_controller')): ?> checked <?php endif; ?>>
				<label for="Panel_controller">Ver panel de inicio.</label>
			</div>
		
			<div class="form-check">
				<input type="checkbox" value="true" name="estadisticas_rapidas" <?php if(kvfj($u->permisos,'estadisticas_rapidas')): ?> checked <?php endif; ?>>
				<label for="estadisticas_rapidas">Ver estadísticas globales.</label>
			</div>

			<div class="form-check">
				<input type="checkbox" value="true" name="facturado" <?php if(kvfj($u->permisos,'facturado')): ?> checked <?php endif; ?>>
				<label for="facturado">Ver estadísticas de facturación.</label>
			</div>

		</div>
	</div> 
</div><?php /**PATH G:\www\cms\resources\views/admin/usuarios/permisos/modulo_panel.blade.php ENDPATH**/ ?>