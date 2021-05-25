

<?php $__env->startSection('title','Editar proveedor'); ?>


<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item">
	<a href="<?php echo e(url('/admin/proveedores/all')); ?>"><i class="fas fa-truck"></i> Proveedores</a>
</li>
<li class="breadcrumb-item">
	<a href="<?php echo e(url('/admin/proveedores/'.$prov->id).'/edit'); ?>"><i class="fas fa-edit"></i> Editar proveedor</a>
</li>
<?php $__env->stopSection(); ?>
 

 <?php $__env->startSection('content'); ?>

<div class="container-fluid">
	<div class="panel shadow">
		<div class="header">
			<h2 class="title"><i class="fas fa-edit"></i> Editar proveedor</h2>
		</div>
			<div class="inside">
							
				<?php echo Form::open(['url' => '/admin/proveedores/'.$prov->id.'/edit','files'=>true]); ?> 
							
					<div class="row">

						<div class="col-md-6">
							<label for="title">Nombre de proveedor:</label>
							<div class="input-group">
							   		<span class="input-group-text" id="basic-addon1">
							   			<i class="fas fa-keyboard"></i>
							   		</span>
						    	<?php echo Form::text('name', $prov->name, ['class' => 'form-control']); ?>

						    </div>
						</div>

						<div class="col-md-3">
								<label for="cuit">CUIT:</label>
									<div class="input-group">
									   		<span class="input-group-text" id="basic-addon1">
									   			<i class="far fa-id-card"></i>
									   		</span>
							    	<?php echo Form::number('cuit', $prov->cuit, ['class' => 'form-control'] ); ?>

							    	</div>
						</div>

						<div class="col-md-3">
							<label for="telefono">Teléfono:</label>
								<div class="input-group">
								   		<span class="input-group-text" id="basic-addon1">
								   			<i class="fas fa-phone-alt"></i>
								   		</span>
						    	<?php echo Form::number('telefono', $prov->telefono, ['class' => 'form-control'] ); ?>

						    	</div>
						</div>
					</div>

					<div class="row mtop16">
						<div class="col-md-6">
							<label for="direccion">Dirección:</label>
							<div class="input-group">
							   		<span class="input-group-text" id="basic-addon1">
							   			<i class="fas fa-map-marked-alt"></i>
							   		</span>
						    	<?php echo Form::text('direccion', $prov->direccion, ['class' => 'form-control']); ?>

						    </div>
						</div>

						<div class="col-md-6">
							<label for="correo">Correo Eléctronico:</label>
							<div class="input-group">
							   		<span class="input-group-text" id="basic-addon1">
							   			<i class="fas fa-at"></i>
							   		</span>
						    	<?php echo Form::text('correo', $prov->correo, ['class' => 'form-control']); ?>

						    </div>
						</div>	
					</div>

					<div class="row mtop16" >
						<div class="col-md-12">
							<?php echo Form::submit('Guardar', ['class' => 'btn btn-success']); ?>

						</div>
					</div>
		
			<?php echo Form::close(); ?>

				
		</div>
	</div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH G:\www\cms\resources\views/admin/proveedores/edit.blade.php ENDPATH**/ ?>