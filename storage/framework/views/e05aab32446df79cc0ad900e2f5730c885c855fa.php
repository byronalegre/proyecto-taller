

<?php $__env->startSection('title','Registrar compra'); ?>

<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item">
	<a href="<?php echo e(url('/admin/compras')); ?>"><i class="far fa-plus-square"></i> Registrar compra</a>
</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">
	<div class="panel shadow">
		<div class="header">
			<h2 class="title"><i class="far fa-plus-square"></i> Registrar compra</h2>
		</div>
		<div class="inside">

			<?php if(kvfj(Auth::user()->permisos, 'compras_agregar')): ?>
			<a href="<?php echo e(url('admin/compras/agregar')); ?>" class="btn btn-success btn-sm">
			<i class="fas fa-plus-circle"></i> Agregar compra
			</a>
			<?php endif; ?>

			<table class="table table-striped mtop16">
				<thead class="table-dark">
					<td>ID</td>
					<td>Código</td>
					<td>Proveedor</td>					
					<td>Fecha registro</td>
					<td width="110"></td>
				</thead>
				<tbody>
					<?php $__currentLoopData = $input; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<tr>
						<td><?php echo e($i->id); ?> </td>
						<td><?php echo e($i->codigo); ?> </td>						
						<td><?php echo e($i->provs->name); ?> </td>
						<td><?php echo e($i->created_at); ?> </td>
						<td>
						<div class="opts">
							<a href="<?php echo e(url('admin/compras/'.$i->id.'/detalle')); ?>" data-toggle="tooltip" data-placement="top" title="Detalle">
						<i class="fas fa-info-circle"></i>
						</a>
						</div>
						</td>
					</tr>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					<tr>
						<td colspan="6"> <?php echo $input->render(); ?></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH G:\www\cms\resources\views/admin/entradas/home.blade.php ENDPATH**/ ?>