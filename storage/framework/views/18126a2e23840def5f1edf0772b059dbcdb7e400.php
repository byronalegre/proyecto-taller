

<?php $__env->startSection('title','Proveedores'); ?>

<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item">
	<a href="<?php echo e(url('/admin/proveedores/all')); ?>"><i class="fas fa-truck"></i> Proveedores</a>
</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">
	<div class="panel shadow">
		<div class="header">
			<h2 class="title"><i class="fas fa-truck"></i> Proveedores</h2>
		</div>
		
		<div class="inside">
			<div class="nav justify-content-end">
					<?php if(kvfj(Auth::user()->permisos, 'proveedores_buscar')): ?>					
						<?php echo Form::open(['url' => '/admin/proveedores/buscar']); ?>

							<div class="input-group mb-3">
								  <?php echo Form::text('buscar', null, ['class' => 'form-control form-control-sm','placeholder' => 'Buscar por']); ?>

								  <?php echo Form::select('filtro',['0'=>'ID','1'=>'Nombre','2'=>'CUIT','3'=>'Dirección','4'=>'Teléfono'], 0,['class'=>'form-select form-select-sm']); ?>

								  <?php echo Form::submit('Buscar', ['class'=> 'btn btn-outline-dark btn-sm']); ?>

							</div>
						<?php echo Form::close(); ?>

					<?php endif; ?>	
							
					<div class="dropdown pl-3">
						  <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Filtrar </button>

						  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
						    <a class="dropdown-item" href="<?php echo e(url('admin/proveedores/all')); ?>"><i class="fas fa-list"></i> Todos</a>
						    <a class="dropdown-item" href="<?php echo e(url('admin/proveedores/trash')); ?>"><i class="fas fa-trash-alt"></i> Papelera</a>

						  </div>
					</div>
			</div>	

			<div class="btns">
				<?php if(kvfj(Auth::user()->permisos, 'proveedores_agregar')): ?>
					<a href="<?php echo e(url('admin/proveedores/agregar')); ?>" class="btn btn-success btn-sm">
						<i class="fas fa-plus-circle"></i> Agregar proveedor
					</a>
				<?php endif; ?>
				<?php if(kvfj(Auth::user()->permisos, 'proveedores_pdf')): ?>
					<a data-toggle="tooltip" data-placement="top" title="Generar PDF" href="<?php echo e(route('proveedores_pdf')); ?>" class="btn btn-sm btn-danger">PDF
	           			<i data-toggle="tooltip" data-placement="top" title="Generar PDF" class="far fa-file-pdf"></i>
	       			</a>
	       		<?php endif; ?>
			</div>

			<table class="table table-hover mtop16">
				<thead class="table-dark">
					<td>ID</td>
					<td>Nombre</td>
					<td>CUIT</td>
					<td>Dirección</td>
					<td>Teléfono</td>
					<td>Correo Electrónico</td>
					<td width="90"></td>
				</thead>
				<tbody>
					
					<?php $__currentLoopData = $provs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<tr>
						<td><?php echo e($p->id); ?> </td>
						<td><?php echo e($p->name); ?> </td>
						<td><?php echo e($p->cuit); ?> </td>
						<td><?php echo e($p->direccion); ?> </td>
						<td><?php echo e($p->telefono); ?> </td>
						<td><?php echo e($p->correo); ?> </td>
						<td>
							<?php if(kvfj(Auth::user()->permisos, 'proveedores_editar')): ?>
								<?php if(is_null($p->deleted_at)): ?>
									<a class="btn btn-primary btn-sm" href="<?php echo e(url('admin/proveedores/'.$p->id.'/edit')); ?>"data-toggle="tooltip" data-path="admin/piezas" data-action="delete" data-object="<?php echo e($p->id); ?>" data-placement="top" title="Editar">
									<i class="fas fa-edit"></i>
									</a>
								<?php endif; ?>
							<?php endif; ?>
								
							<?php if(kvfj(Auth::user()->permisos, 'proveedores_eliminar')): ?>
								<?php if(is_null($p->deleted_at)): ?>
									<a href="#" data-path="admin/proveedores" data-action="delete" data-object="<?php echo e($p->id); ?>" data-toggle="tooltip" data-placement="top" title="Eliminar" class="btn btn-danger btn-sm btn-deleted">
									<i class="fas fa-trash-alt"></i>
									</a> 
								<?php else: ?>
									<a href="<?php echo e(url('/admin/proveedores/'.$p->id.'/restore')); ?>" data-action="restore" data-path="admin/proveedores" data-object="<?php echo e($p->id); ?>" data-toggle="tooltip" data-placement="top" title="Restaurar" class="btn btn-success btn-sm btn-deleted">
									<i class="fas fa-trash-restore"></i>
									</a> 
								<?php endif; ?>
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

<?php echo $__env->make('admin.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH G:\www\cms\resources\views/admin/proveedores/buscar.blade.php ENDPATH**/ ?>