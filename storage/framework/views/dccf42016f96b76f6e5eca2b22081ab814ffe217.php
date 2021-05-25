

<?php $__env->startSection('title','Usuarios'); ?>


<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item">
	<a href="<?php echo e(url('/admin/usuarios/all')); ?>"><i class="fas fa-users"></i> Usuarios</a>
</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">
	<div class="panel shadow">
		<div class="header">
			<h2 class="title"><i class="fas fa-users"></i> Usuarios</h2>
		</div>

		
		<div class="inside">
			<div class="nav justify-content-end">
					<?php if(kvfj(Auth::user()->permisos, 'usuarios_buscar')): ?>					
						<?php echo Form::open(['url' => '/admin/usuarios/buscar']); ?>

							<div class="input-group mb-3">
								  <?php echo Form::text('buscar', null, ['class' => 'form-control form-control-sm','placeholder' => 'Buscar por']); ?>

								  <?php echo Form::select('filtro',['0'=>'ID','1'=>'Nombre','2'=>'Apellido'], 0,['class'=>'form-select form-select-sm']); ?>

								  <?php echo Form::submit('Buscar', ['class'=> 'btn btn-outline-dark btn-sm']); ?>

							</div>
						<?php echo Form::close(); ?>

					<?php endif; ?>				
				
					<div class="dropdown pl-3">
						  <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Filtrar </button>

						  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
						    <a class="dropdown-item" href="<?php echo e(url('admin/usuarios/all')); ?>"><i class="fas fa-list"></i> Todos</a>
						    <a class="dropdown-item" href="<?php echo e(url('admin/usuarios/1')); ?>"><i class="fas fa-user-check"></i> Activos</a>
						    <a class="dropdown-item" href="<?php echo e(url('admin/usuarios/100')); ?>"><i class="fas fa-user-clock"></i> Suspendidos</a>

						  </div>
					</div>
				
			</div>

			<div class="btns">		
			<?php if(kvfj(Auth::user()->permisos, 'usuarios_register')): ?>			
				<a href="<?php echo e(url('admin/usuarios/register')); ?>" class="btn btn-success btn-sm">
					<i class="fas fa-plus-circle"></i> Registrar usuario
				</a>	
			<?php endif; ?>						
			</div>
			
			<table class="table table-hover mtop16">
				<thead class="table-dark">
					<tr>
						<td>ID</td>
						<td>Nombre</td>
						<td>Apellido</td>
						<td>Email</td>
						<td>Rol</td>
						<td>Estado</td>
						<td width="90"></td>
					</tr>
				</thead>
				<tbody>
					<?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<tr>
						<td><?php echo e($user->id); ?> </td>
						<td><?php echo e($user->name); ?> </td>
						<td><?php echo e($user->lastname); ?> </td>
						<td><?php echo e($user->email); ?> </td>
						<td class="text"><?php echo e(getRoleUsuarioArray(null, $user->role)); ?></td>
						<td class="text"><?php echo e(getStatusUsuarioArray(null, $user->status)); ?></td>
						<td>
							<?php if(kvfj(Auth::user()->permisos, 'usuarios_editar')): ?>
							<a class="btn btn-warning btn-sm" href="<?php echo e(url('admin/usuarios/'.$user->id.'/edit')); ?>"data-toggle="tooltip" data-placement="top" title="Ver">
							<i class="fas fa-eye"></i>
							</a>
							<?php endif; ?>
							<?php if(kvfj(Auth::user()->permisos, 'usuarios_permisos')): ?>
							<a class="btn btn-warning btn-sm" href="<?php echo e(url('admin/usuarios/'.$user->id.'/permisos')); ?>"data-toggle="tooltip" data-placement="top" title="Permisos">
							<i class="fas fa-user-cog"></i>
							</a>
							<?php endif; ?>
						</td>
					</tr>

					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

				</tbody>
			</table>
		</div>
	</div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH G:\www\cms\resources\views/admin/usuarios/buscar.blade.php ENDPATH**/ ?>