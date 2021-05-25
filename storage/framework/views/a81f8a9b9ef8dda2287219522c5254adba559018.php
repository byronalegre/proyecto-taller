

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
					<form class="d-flex mx-2">
						<div class="input-group">
							<span class="input-group-text"><i class="fas fa-search"></i></span>
							<input name="search" type="text" class="form-control form-control-sm w-50" placeholder="Ingrese su búsqueda" aria-label="Ingrese su búsqueda" aria-describedby="button-addon2">
							
							<button class="btn btn-outline-dark btn-sm" type="submit" id="button-addon2">Buscar</button>
						</div>
					</form>
					<?php if(kvfj(Auth::user()->permisos, 'usuarios_ordenar')): ?>
						<div class="dropdown mx-2">
							<button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"> Ordenar por </button>

							<div class="dropdown-menu" aria-labelledby="dropdownMenuButton" id="menu-usuarios">
								<li><h6 class="dropdown-header">ID</h6></li>
								<a class="dropdown-item" href="<?php echo e(url('admin/usuarios/'.$status.'/id=asc')); ?>"><i class="fas fa-sort-amount-down-alt"></i> Ascendente</a>
								<a class="dropdown-item" href="<?php echo e(url('admin/usuarios/'.$status.'/id=desc')); ?>"><i class="fas fa-sort-amount-down"></i> Descendente</a>
								<li><h6 class="dropdown-header">Nombre</h6></li>
								<a class="dropdown-item" href="<?php echo e(url('admin/usuarios/'.$status.'/name=asc')); ?>"><i class="fas fa-sort-amount-down-alt"></i> Ascendente</a>
								<a class="dropdown-item" href="<?php echo e(url('admin/usuarios/'.$status.'/name=desc')); ?>"><i class="fas fa-sort-amount-down"></i> Descendente</a>
								<li><h6 class="dropdown-header">Apellido</h6></li>
								<a class="dropdown-item" href="<?php echo e(url('admin/usuarios/'.$status.'/lastname=asc')); ?>"><i class="fas fa-sort-amount-down-alt"></i> Ascendente</a>
								<a class="dropdown-item" href="<?php echo e(url('admin/usuarios/'.$status.'/lastname=desc')); ?>"><i class="fas fa-sort-amount-down"></i> Descendente</a>
								<li><h6 class="dropdown-header">Correo electrónico</h6></li>
								<a class="dropdown-item" href="<?php echo e(url('admin/usuarios/'.$status.'/email=asc')); ?>"><i class="fas fa-sort-amount-down-alt"></i> Ascendente</a>
								<a class="dropdown-item" href="<?php echo e(url('admin/usuarios/'.$status.'/email=desc')); ?>"><i class="fas fa-sort-amount-down"></i> Descendente</a>
								<li><h6 class="dropdown-header">Rol</h6></li>
								<a class="dropdown-item" href="<?php echo e(url('admin/usuarios/'.$status.'/role=asc')); ?>"><i class="fas fa-sort-amount-down-alt"></i> Ascendente</a>
								<a class="dropdown-item" href="<?php echo e(url('admin/usuarios/'.$status.'/role=desc')); ?>"><i class="fas fa-sort-amount-down"></i> Descendente</a>
								<li><h6 class="dropdown-header">Estado</h6></li>
								<a class="dropdown-item" href="<?php echo e(url('admin/usuarios/'.$status.'/status=asc')); ?>"><i class="fas fa-sort-amount-down-alt"></i> Ascendente</a>
								<a class="dropdown-item" href="<?php echo e(url('admin/usuarios/'.$status.'/status=desc')); ?>"><i class="fas fa-sort-amount-down"></i> Descendente</a>
							</div> 					  
						</div>		
					<?php endif; ?>

					<div class="dropdown mx-2">
						 <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"> Filtrar </button>

						  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
						    <a class="dropdown-item" href="<?php echo e(url('admin/usuarios/all')); ?>"><i class="fas fa-list"></i> Todos</a>
						    <a class="dropdown-item" href="<?php echo e(url('admin/usuarios/1')); ?>"><i class="fas fa-user-check"></i> Habilitados</a>
						    <a class="dropdown-item" href="<?php echo e(url('admin/usuarios/100')); ?>"><i class="fas fa-user-times"></i> Deshabilitados</a>
						  </div>
					</div>

					<div class="col-sm-2">
						<form>
							<div class="input-group input-group-sm">
								<span class="input-group-text" id="basic-addon1">Mostrar</span>
								<input name="paginate" type="number" class="form-control" aria-describedby="basic-addon1" placeholder="<?php echo e(session('paginate')); ?> elementos" min="1" >
							</div>
						</form>
					</div>
				
			</div>

			<div class="btns mb-2">		
				<?php if(kvfj(Auth::user()->permisos, 'usuarios_register')): ?>			
					<a href="<?php echo e(url('admin/usuarios/register')); ?>" class="btn btn-success btn-sm">
						<i class="fas fa-plus-circle"></i> Registrar usuario
					</a>	
				<?php endif; ?>						
			</div> 

			<table class="table table-hover mtop16" id="Datatable" style="width:100%; text-align: center;">
				<thead class="table-dark">
					<tr>
						<td>ID</td>
						<td>Nombre</td>
						<td>Apellido</td>
						<td>Correo Electrónico</td>
						<td>Rol</td>
						<td>Estado</td>
						<td width="100"></td>
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
								<a class="btn btn-warning btn-sm" href="<?php echo e(url('admin/usuarios/'.$user->id.'/edit')); ?>"data-toggle="tooltip" data-placement="top" title="Ver información y rol">
								<i class="fas fa-eye"></i>
								</a>
							<?php endif; ?>
							<?php if($user->role != '0'): ?>
								<?php if(kvfj(Auth::user()->permisos, 'usuarios_permisos')): ?>
									<a class="btn btn-warning btn-sm" href="<?php echo e(url('admin/usuarios/'.$user->id.'/permisos')); ?>"data-toggle="tooltip" data-placement="top" title="Permisos">
									<i class="fas fa-user-cog"></i>
									</a>
								<?php endif; ?>
							<?php endif; ?>
						</td>
					</tr>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</tbody>
			</table>
			<?php if($search): ?>				
				<?php echo e($users->appends(['search'=>$search])); ?>

				<p class="mtop16">
					Mostrando <?php echo e($users->count()); ?> de <?php echo e($users->total()); ?> elemento(s).
				</p>	
			<?php else: ?>
				<?php echo e($users->links()); ?>

				<p class="mtop16">
					Mostrando <?php echo e($users->count()); ?> de <?php echo e($users->total()); ?> elemento(s).
				</p>
			<?php endif; ?>
		</div>
	</div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH G:\www\cms\resources\views/admin/usuarios/home.blade.php ENDPATH**/ ?>