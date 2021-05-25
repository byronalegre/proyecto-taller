

<?php $__env->startSection('title','Permisos de usuario'); ?>


<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item">
	<a href="<?php echo e(url('/admin/usuarios/all')); ?>"><i class="fas fa-users"></i> Usuarios</a>
</li>
<li class="breadcrumb-item">
	<a href="<?php echo e(url('/admin/usuarios/'.$u->id.'/permisos')); ?>"><i class="fas fa-user-edit"></i> Permisos del usuario: <?php echo e($u->name); ?> <?php echo e($u->lastname); ?></a>
</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

	<div class="container-fluid">
		
		<div class="page-user">
			
			<form action="<?php echo e(url('/admin/usuarios/'.$u->id.'/permisos')); ?>" method="POST">

				<?php echo csrf_field(); ?>

				<div class="row">
				
					<?php $__currentLoopData = permisos_usuario(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					
						<div class="col-md-4 d-flex mtop16">
							<div class="panel shadow">

								<div class="header">
									<h2 class="title"><?php echo $value['icon']; ?> <?php echo $value['title']; ?> </h2>
								</div>

								<div class="inside">
									<?php $__currentLoopData = $value['keys']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<div class="form-check form-switch">
											<input class="form-check-input" type="checkbox" id="flexCheckDefault" value="true" name="<?php echo e($k); ?>" <?php if(kvfj($u->permisos, $k )): ?> checked <?php endif; ?>>
											<label class="form-check-label" for="flexCheckDefault"> <?php echo e($v); ?> </label>
										</div>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</div>
								
							</div> 
						</div>	
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</div>

				<div class="row mtop16">
					<div class="col-md-12">
						<div class="panel shadow">
							<div class="inside">
								<input style="width: auto" type="submit" value="Guardar" class="btn btn-success">
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH G:\www\cms\resources\views/admin/usuarios/permisos.blade.php ENDPATH**/ ?>