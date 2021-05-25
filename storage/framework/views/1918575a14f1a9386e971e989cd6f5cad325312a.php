<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo e(config('settings.name')); ?> - <?php echo $__env->yieldContent('title'); ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
	<meta name="routeName" content="<?php echo e(Route::currentRouteName()); ?>">
	<link rel="icon" type="image/png" href="<?php echo e(url('/static/images/mini.ico')); ?>"/>

	
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
	
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
	<link rel="stylesheet" href="<?php echo e(url('/static/css/admin.css?v='.time())); ?>">	
	<script src="https://kit.fontawesome.com/3f442a97b6.js" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

	<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
	<script src="<?php echo e(url('/static/libs/ckeditor/ckeditor.js')); ?>" ></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<script src="<?php echo e(url('/static/js/admin.js?v='.time())); ?>"></script>

	
	
	
	
	
	<script>
		$(document).ready(function(){
			  $('[data-toggle="tooltip"]').tooltip();
		});
	</script>

</head>
<body>

	<div class="wrapper">
		<div class="col1" id="sidebar">					
			  <?php echo $__env->make('admin.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>							
		</div>
		<div class="col2" id="cuerpo"> 	
			<nav class="navbar navbar-expand-lg shadow-lg">	
				<div class="container-fluid justify-content-end" id="navCuenta">	
					<button class="navbar-toggler" onclick="abrir()">
					≡
					</button>							
					<ul class="navbar-nav ml-auto">					

						<div class="dropdown nav-item">
						  <button class="btn btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user-astronaut"></i> <?php echo e(Auth::user()->name." ".Auth::user()->lastname); ?> 
						  </button>

						  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
						    <?php if(kvfj(Auth::user()->permisos, 'micuenta_editar')): ?>
								<li>
									<a href="<?php echo e(url('/admin/micuenta/edit')); ?>">
									 <i class="far fa-user-circle"></i> Mi cuenta
									</a>
								</li>																
							<?php endif; ?>
							<li>
								<a href="#" data-bs-toggle="modal" data-bs-target="#salir"><i class="fas fa-sign-out-alt" style="color:red"></i> Cerrar sesión
								</a>								
							</li>
						  </div>
						</div>
					</ul>
				</div>
			</nav>
			<div class="page">
				<div class="container-fluid">
					<nav aria-label="breadcrumb" class="shadow-lg">	
						<ol class="breadcrumb">
							<li class="breadcrumb-item">
								<a href="<?php echo e(url('/admin')); ?>">
									<i class="fas fa-home"></i> Inicio
								</a>
							</li>
							<?php $__env->startSection('breadcrumb'); ?>
							<?php echo $__env->yieldSection(); ?>
						</ol>
					</nav>
					
					<div class="modal fade" id="salir" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
					  <div class="modal-dialog modal-dialog-centered">
					    <div class="modal-content">
					      <div class="modal-header">
					        <h5 class="modal-title" id="exampleModalLabel">¿Desea cerrar sesión?</h5>
					        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					      </div>
					      <div class="modal-footer">
					        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
					        <a href="<?php echo e(url('/logout')); ?>" class="btn btn-danger">Si
							</a>
					      </div>
					    </div>
					  </div>
					</div>

				</div>

				<?php if(Session::has('message')): ?>
					<div class="container">
						<div class="alert alert-<?php echo e(Session::get('typealert')); ?> mtop16">
							<?php echo e(Session::get('message')); ?>

							<?php if($errors->any()): ?>
								<ul>
									<?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<li style="margin-left: 16px">
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
				
				<?php $__env->startSection('content'); ?>
				<?php echo $__env->yieldSection(); ?>
				<a href="javascript: history.go(-1)" class="btn btn-dark btn-sm m-3">Atrás</a>
			</div>
		</div>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>

	

	<div class="footer shadow-lg" id="footer">
	  Desarrollado por Agustin Alegre & Mariano Wasinger con motivo académico para la carrera Lic. en Sistemas de Información | FCyT | UADER. ©
	</div>
</body>
	
</html><?php /**PATH G:\www\cms\resources\views/admin/master.blade.php ENDPATH**/ ?>