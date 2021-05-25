

<?php $__env->startSection('title','Recuperar Contraseña'); ?>

<?php $__env->startSection('content'); ?>
<div class="box shadow">
	<div class="header shadow">
		<a href="<?php echo e(url('/')); ?> ">
			<img src="<?php echo e(url('static/images/logo1.png')); ?>">
		</a>
	</div>		
	<div class="inside"> 
		<?php echo Form::open(['url' => '/reset']); ?>

		<label for="email"> Correo Electrónico</label>
		<div class="input-group">
			<div class="input-group-prepend">
				 <div class="input-group-text"><i class="fas fa-at"></i></div>
			</div>
		<?php echo Form::email('email', $email, ['class' => 'form-control', 'required']); ?>

		</div>
		
		<label for="code" class="mtop16"> Código</label>
		<div class="input-group">
			<div class="input-group-prepend">
				 <div class="input-group-text"><i class="fas fa-keyboard"></i></div>
			</div>
		<?php echo Form::number('code', null, ['class' => 'form-control', 'required']); ?>

		</div>

		<?php echo Form::submit('Enviar contraseña', ['class' => 'btn btn-success mtop16']); ?>


		<?php echo Form::close(); ?>

		
	
		<?php if(Session::has('message')): ?>
				<div class="container">
					<div class="mtop16 alert alert-<?php echo e(Session::get('typealert')); ?>" style="display:none;">
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

	</div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('connect.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH G:\www\cms\resources\views/connect/reset.blade.php ENDPATH**/ ?>