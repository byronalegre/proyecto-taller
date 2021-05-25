

<?php $__env->startSection('title','Mi cuenta'); ?>

<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item">
	<a href="<?php echo e(url('/admin/micuenta/edit')); ?>"><i class="fas fa-user-circle"></i> Mi cuenta</a>
</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">		
				<div class="row">					
					<div class="col-md-6 d-flex">						
						<div class="panel shadow">
							<div class="header">
							<h2 class="title"><i class="fas fa-list"></i> Información básica</h2>
							</div>
							<div class="inside">
								<?php echo Form::open(['url' => '/admin/micuenta/edit/info','files'=>true]); ?> 

								<label for="title">Nombre/s:</label>
								<div class="input-group">							
								   	<span class="input-group-text" id="basic-addon1">
								   		<i class="fas fa-keyboard"></i>
								   	</span>						    
							    	<?php echo Form::text('name', Auth::user()->name, ['class' => 'form-control']); ?>

							    </div>
							
								<label for="title" class="mtop16">Apellido/s:</label>
								<div class="input-group">							
								   	<span class="input-group-text" id="basic-addon1">
								   		<i class="fas fa-keyboard"></i>
								   	</span>						    
							    	<?php echo Form::text('lastname', Auth::user()->lastname, ['class' => 'form-control']); ?>

							    </div>
							
								<label for="email" class="mtop16"> Correo Electrónico:</label>
								<div class="input-group">
									<span class="input-group-text" id="basic-addon1">
										 <i class="fas fa-at"></i>
									</span>
								<?php echo Form::email('email', Auth::user()->email, ['class' => 'form-control', 'disabled']); ?>

								</div>

								<div class="col-md-2 mtop16">
								<?php echo Form::submit('Guardar', ['class' => 'btn btn-success']); ?>

								</div>

							</div>
							<?php echo Form::close(); ?>

						</div>				
					</div>

				<div class="col-md-6 d-flex">
					<div class="panel shadow">						 
						<div class="header">
						<h2 class="title"><i class="fas fa-lock"></i> Cambio de contraseña</h2>
						</div>

						<div class="inside">
							<?php echo Form::open(['url' => '/admin/micuenta/edit/password','files'=>true]); ?>


							<label for="old_password"> Contraseña actual:</label>
							<div class="input-group">
								<span class="input-group-text" id="basic-addon1">
									 <i class="fas fa-key"></i>
								</span>
							<?php echo Form::password('old_password', ['class' => 'form-control']); ?>

							</div>
							<label for="password" class="mtop16"> Contraseña nueva:</label>
							<div class="input-group">
								<span class="input-group-text" id="basic-addon1">
									 <i class="fas fa-key"></i>
								</span>
							<?php echo Form::password('password', ['class' => 'form-control']); ?>

							</div>
							<label for="cpassword" class="mtop16"> Confirmar contraseña:</label>
							<div class="input-group">
								<span class="input-group-text" id="basic-addon1">
									 <i class="fas fa-key"></i>
								</span>
							<?php echo Form::password('cpassword', ['class' => 'form-control']); ?>

							</div>

							<div class="col-md-2 mtop16">
							<?php echo Form::submit('Cambiar', ['class' => 'btn btn-success']); ?>

							</div>

						</div>
						<?php echo Form::close(); ?>

					</div>
				</div>
			</div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH G:\www\cms\resources\views/admin/cuenta/edit.blade.php ENDPATH**/ ?>