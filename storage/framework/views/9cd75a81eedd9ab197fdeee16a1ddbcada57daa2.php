<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo $__env->yieldContent('title'); ?></title>
	<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
	<meta name="routeName" content="<?php echo e(Route::currentRouteName()); ?>">
	<link rel="icon" type="image/png" href="<?php echo e(url('/static/images/mini.ico')); ?>"/>
	<!--<meta name="viewport" content="width=device-width, initial-scale=1, shirnk-to-fit=no">-->
	
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
	
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
	<link rel="stylesheet" href="<?php echo e(url('/static/css/style.css?v='.time())); ?>">	
	<script src="https://kit.fontawesome.com/e86cf146da.js" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

</head>
<body>
	
	<div class="modal fade" id="salir" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-centered">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">¿Desea cerrar sesión?</h5>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn" data-bs-dismiss="modal">No</button>
	        <a href="<?php echo e(url('/logout')); ?>" style="background-color: red;" class="btn">Si
			</a>
	      </div>
	    </div>
	  </div>
	</div>

	<nav class="navbar navbar-expand-lg">
	  <div class="container-fluid">
	    <a class="navbar-brand" href="<?php echo e(url('/')); ?>" ><img src="<?php echo e(url('static/images/logo1.png')); ?>" width="50" alt="" loading="lazy"></a>
	    <div>
	    <?php if(Auth::check()): ?>  
	      <ul class="navbar-nav me-auto mb-2 mb-lg-0">	
	        <li class="nav-item dropdown">
	          <a class="nav-link dropdown-toggle bg-dark" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
	            <i class="fas fa-user-astronaut"></i> <?php echo e(Auth::user()->name.' '.Auth::user()->lastname); ?>

	          </a>
	          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
	             <li><a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#salir"><i class="fas fa-sign-out-alt" style="color: red;"></i> Cerrar sesión</a></li>
	          </ul>
	        </li>
	      </ul>
	    <?php endif; ?>
	    </div>
	  </div>
	</nav>

	<div class="container-fluid w-50" style="margin-top: 1rem;">
		<div class="card text-center">
		  <div class="card-body">
		    
		    <?php if(!Auth::check()): ?>
			    <h5 class="card-title">Bienvenido</h5>
			    <p class="card-text">Para comenzar, inicie sesión.</p>
			    <a href="<?php echo e(url('/login')); ?>" class="btn shadow"><i class="fas fa-sign-in-alt"></i> Ingresar</a>
		    <?php endif; ?>

		    <?php if(Auth::check()): ?>		    	
					<?php if((Auth::user()->role == "1")||(Auth::user()->role == "2")||(Auth::user()->role == "3")|(Auth::user()->role == "4")): ?>
						<h5 class="card-title">Para realizar cualquier tarea debe dirigirse a la Administración</h5>
						<a href="<?php echo e(url('/admin')); ?>" class="btn"><i class="fas fa-user-tie"></i> Administración</a>
					<?php endif; ?>
					<?php if(Auth::user()->role == "0"): ?>
						<h5 class="card-title">Bienvenido, aún no tiene los permisos necesarios ni un rol asignado.</h5>
					<?php endif; ?>
			<?php endif; ?>
		  </div>
		</div>
	</div>

	
	<?php if(Session::has('message')): ?>
		<div class="container-fluid">
			<div class="alert alert-<?php echo e(Session::get('typealert')); ?> mtop16" style="display:none; margin-bottom: 16px; margin: 16px;">
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
	
	<?php $__env->startSection('content'); ?>
	<?php echo $__env->yieldSection(); ?>

	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js" integrity="sha384-KsvD1yqQ1/1+IA7gi3P0tyJcT3vR+NdBTt13hSJ2lnve8agRGXTTyNaBYmCR/Nwi" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js" integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG" crossorigin="anonymous"></script>

	<nav class="navbar fixed-bottom navbar-dark bg-dark">
	  <div class="container-fluid">
	    <a style="font-size: 10px;" class="navbar-brand">Desarrollado por Agustin Alegre & Mariano Wasinger con motivo académico para la carrera Lic. en Sistemas de Información | FCyT | UADER. ©</a>
	  </div>
	</nav>	

</body>

</html><?php /**PATH G:\www\cms\resources\views/master.blade.php ENDPATH**/ ?>