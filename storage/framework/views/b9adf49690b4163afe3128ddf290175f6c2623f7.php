

<?php $__env->startSection('title','Configuración'); ?>


<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item">
	<a href="<?php echo e(url('/admin/usuarios/all')); ?>"><i class="fas fa-wrench"></i> Configuración</a>
</li>
<?php $__env->stopSection(); ?>
 

 <?php $__env->startSection('content'); ?>

<div class="container-fluid">
	<div class="panel shadow">
		<div class="header">
			<h2 class="title"><i class="fas fa-wrench"></i> Configuración</h2>
		</div>

		<div class="inside">
			<?php echo Form::open(['url' => '/admin/config']); ?>

			<div class="row">
					<div class="col-md-3">
						<label for="title">Nombre de sistema:</label>
						<div class="input-group">
								<span class="input-group-text" id="basic-addon1">
									<i class="far fa-registered"></i>
								</span>
							<?php echo Form::text('name', config( 'settings.name' ), ['class' => 'form-control']); ?>

						</div>
					</div>				

					<div class="col-md-3">
						<label for="telefono">Teléfono de la entidad:</label>
						<div class="input-group">
								<span class="input-group-text" id="basic-addon1">
									<i class="fas fa-phone"></i>
								</span>
							<?php echo Form::number('telefono', config( 'settings.telefono' ), ['class' => 'form-control']); ?>

						</div>
					</div>	
			
					<div class="col-md-6">
						<label for="direccion">Dirección de la entidad:</label>
						<div class="input-group">
								<span class="input-group-text" id="basic-addon1">
									<i class="fas fa-map-marked-alt"></i>
								</span>
							<?php echo Form::text('direccion', config( 'settings.direccion' ), ['class' => 'form-control']); ?>

						</div>
					</div>
			</div>

			<div class="row mtop16" >
				<div class="col-md-12">
					<?php echo Form::submit('Guardar', ['class' => 'btn btn-success']); ?>

				</div>
			</div>
		</div>			
		<?php echo Form::close(); ?>		
	</div>	
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH G:\www\cms\resources\views/admin/config/config.blade.php ENDPATH**/ ?>