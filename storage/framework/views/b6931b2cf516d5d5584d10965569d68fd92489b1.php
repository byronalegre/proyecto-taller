

<?php $__env->startSection('title','Registrarse'); ?>

<?php $__env->startSection('content'); ?>

<div class="box shadow">
<div class="header shadow">
	<a href="<?php echo e(url('/')); ?> ">
		<img style="width:250px; height:80px;" src="<?php echo e(url('static/images/logo.png')); ?>">
	</a>
</div>		
<div class="inside"> 

	<?php echo Form::open(['url' => '/register']); ?>

	<!--NOMBRE-->
	<label for="email"> Nombre</label>
	<div class="input-group">
		<div class="input-group-prepend">
			 <div class="input-group-text"><i class="fas fa-keyboard"></i></div>
		</div>
	<?php echo Form::text('name', null, ['class' => 'form-control', 'required']); ?>

	</div>
	<!--APELLIDO-->
	<label for="email" class="mtop16"> Apellido</label>
	<div class="input-group">
		<div class="input-group-prepend">
			 <div class="input-group-text"><i class="fas fa-keyboard"></i></div>
		</div>
	<?php echo Form::text('lastname', null, ['class' => 'form-control', 'required']); ?>

	</div>
	<!--CORREO-->
	<label for="email" class="mtop16"> Correo Electrónico</label>
	<div class="input-group">
		<div class="input-group-prepend">
			 <div class="input-group-text"><i class="fas fa-at"></i></div>
		</div>
	<?php echo Form::email('email', null, ['class' => 'form-control', 'required']); ?>

	</div>
	<!--CONTRA-->
	<label for="password" class="mtop16"> Contraseña</label>
	<div class="input-group">
		<div class="input-group-prepend">
			 <div class="input-group-text"><i class="fas fa-key"></i></div>
		</div>
	<?php echo Form::password('password', ['class' => 'form-control', 'required']); ?>

	</div>
	<!--REPETIR CONTRA-->
	<label for="cpassword" class="mtop16"> Confirmar contraseña</label>
	<div class="input-group">
		<div class="input-group-prepend">
			 <div class="input-group-text"><i class="fas fa-key"></i></div>
		</div>
	<?php echo Form::password('cpassword', ['class' => 'form-control', 'required']); ?>

	</div>

	<?php echo Form::submit('Registrarse', ['class' => 'btn btn-success mtop16']); ?>


	<?php echo Form::close(); ?>

	
	

		<?php if(Session::has('message')): ?>
				<div class="container">
					<div class=" mtop16 alert alert-<?php echo e(Session::get('typealert')); ?>" style="display:none;">
						<?php echo e(Session::get('message')); ?>

						<?php if($errors->any()): ?>
							<ul>
								<?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<li>
									<?php echo e($error); ?>

								</li>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</ul>
						<?php endif; ?>
							<script>
								$('.alert').slideDown();
								setTimeout(function(){ $('.alert').slideUp(); }, 10000);
							</script>
					</div>
				</div>
		<?php endif; ?>
				
		<div class="footer mtop16">
			<font size="4px"><a href="<?php echo e(url('/login')); ?>">Ingresar</a></font>
		</div>
	</div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('connect.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH G:\www\cms\resources\views/connect/register.blade.php ENDPATH**/ ?>