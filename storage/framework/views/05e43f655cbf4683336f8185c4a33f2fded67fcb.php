

<?php $__env->startSection('title','Registrar usuario'); ?>


<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item">
	<a href="<?php echo e(url('/admin/usuarios/all')); ?>"><i class="fas fa-users"></i> Usuarios</a>
</li>
<li class="breadcrumb-item">
	<a href="<?php echo e(url('/admin/usuarios/register')); ?>"><i class="fas fa-plus-circle"></i> Registrar usuario</a>
</li>
<?php $__env->stopSection(); ?>
 

 <?php $__env->startSection('content'); ?>

<div class="container-fluid">
	<div class="panel shadow">

		<div class="header">
			<h2 class="title"><i class="fas fa-plus-circle"></i> Registrar usuario</h2>
		</div>

		<div class="inside">
			<?php echo Form::open(['url' => '/admin/usuarios/register']); ?>

			<div class="row">

					<div class="col-md-6">
						<label for="title">Nombre:</label>
						<div class="input-group">
						   		<span class="input-group-text" id="basic-addon1">
						   			<i class="fas fa-keyboard"></i>
						   		</span>
					    	<?php echo Form::text('name', null, ['class' => 'form-control']); ?>

					    </div>
					</div>

					<div class="col-md-6">
							<label for="cuit">Apellido:</label>
								<div class="input-group">
								   		<span class="input-group-text" id="basic-addon1">
								   			<i class="fas fa-keyboard"></i>
								   		</span>
						    	<?php echo Form::text('lastname', null, ['class' => 'form-control']); ?>

						    	</div>
					</div>					
				</div>

				<div class="row mtop16">

					<div class="col-md-6">
						<label for="email">Correo Eléctronico:</label>
						<div class="input-group">
						   		<span class="input-group-text" id="basic-addon1">
						   			<i class="fas fa-at"></i>
						   		</span>
					    	<?php echo Form::text('email', null, ['class' => 'form-control']); ?>

					    </div>
					</div>	

					<div class="col-md-6">
						<label for="password">Contraseña:</label>
						<div class="input-group">
						   		<span class="input-group-text" id="basic-addon1">
						   			<i class="fas fa-key"></i>
						   		</span>
					    	<?php echo Form::password('password', ['class' => 'form-control']); ?>

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
<?php echo $__env->make('admin.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH G:\www\cms\resources\views/admin/usuarios/register.blade.php ENDPATH**/ ?>