

<?php $__env->startSection('title','Información y Rol de usuario'); ?>


<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item">
	<a href="<?php echo e(url('/admin/usuarios/all')); ?>"><i class="fas fa-users"></i> Usuarios</a>
</li>
<li class="breadcrumb-item">
	<a href="<?php echo e(url('/admin/usuarios/'.$u->id.'/edit')); ?>"><i class="fas fa-user-edit"></i> Editar usuario</a>
</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">
	<div class="page-user">
		<div class="row">
			<div class="col-md-4">
				<div class="panel shadow">
					<div class="header">
						<h2 class="title"><i class="fas fa-user-circle"></i> Información</h2>
					</div>
					<div class="inside">
						<div class="info">
							<span class="title"><i class="fas fa-id-card"></i> Nombre y apellido:</span>
							<span class="text"><?php echo e($u->name); ?> <?php echo e($u->lastname); ?></span>
							<span class="title"><i class="far fa-envelope"></i> Correo Electrónico:</span>
							<span class="text"><?php echo e($u->email); ?></span>
							<span class="title"><i class="far fa-calendar-alt"></i> Fecha de registro:</span>
							<span class="text"><?php echo e($u->created_at); ?></span>
							<span class="title"><i class="fas fa-user-tag"></i> Rol:</span>
							<span class="text"><?php echo e(getRoleUsuarioArray(null, $u->role)); ?></span>
							<span class="title"><i class="fas fa-user-tie"></i> Estado:</span>
							<span class="text"><?php echo e(getStatusUsuarioArray(null, $u->status)); ?></span>
						</div>

						<div>	
							<?php if(kvfj(Auth::user()->permisos, 'usuarios_suspend')): ?>
								<?php if($u->status == "100"): ?>
									<a href="<?php echo e(url('admin/usuarios/'.$u->id.'/suspend')); ?>" class="btn btn-success"> Habilitar usuario
									</a>
								<?php else: ?>	
									<a href="<?php echo e(url('admin/usuarios/'.$u->id.'/suspend')); ?>" class="btn btn-danger"> Deshabilitar usuario
									</a>
								<?php endif; ?>
							<?php endif; ?>
						</div>
					</div>
				</div> 
			</div>

			<div class="col-md-8">
				<div class="panel shadow">
					<div class="header">
						<h2 class="title"><i class="fas fa-user-edit"></i> Editar rol</h2>
					</div>
					<div class="inside" style="text-align: -webkit-center"><!--alineado al centro-->
						
						<?php if(kvfj(Auth::user()->permisos, 'usuarios_editar')): ?>
							<?php echo Form::open(['url'=>'/admin/usuarios/'.$u->id.'/edit']); ?>

								
								<div class="col-md-8">
									<div class="input-group">
									   		<span class="input-group-text" id="basic-addon1">
									   			<i class="fas fa-tag"></i>
									   		</span>
								    	<?php echo Form::select('rol_user', getRoleUsuarioArray('list', null), $u->role, ['class' =>'form-select']); ?>	
									</div>
								</div>

								<div class="col-md-2 mtop16">
									<?php echo Form::submit('Guardar', ['class'=>'btn btn-success']); ?>

								</div>

							<?php echo Form::close(); ?>

						<?php endif; ?>
					</div>
				</div> 
			</div>
		</div>
	</div>	
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH G:\www\cms\resources\views/admin/usuarios/edit.blade.php ENDPATH**/ ?>