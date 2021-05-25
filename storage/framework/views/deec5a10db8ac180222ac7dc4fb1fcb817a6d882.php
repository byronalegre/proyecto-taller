<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title><?php echo $__env->yieldContent('title'); ?></title>
		
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

		<link rel="stylesheet" href="<?php echo e(url('/static/css/connect.css?v='.time())); ?>">
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

		<script src="https://kit.fontawesome.com/e86cf146da.js" crossorigin="anonymous"></script>

	</head>
	<body>
				<!--<?php if(Session::has('message')): ?>
					<div class="container">
						<div class="alert alert-<?php echo e(Session::get('typealert')); ?> mtop16" style="display:none; margin-bottom: 16px;">
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
				<?php endif; ?>-->

				<?php $__env->startSection('content'); ?>	
				<?php echo $__env->yieldSection(); ?>
	</body>
</html><?php /**PATH G:\www\cms\resources\views/connect/master.blade.php ENDPATH**/ ?>