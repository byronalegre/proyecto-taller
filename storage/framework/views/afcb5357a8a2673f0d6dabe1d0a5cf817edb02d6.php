

<?php $__env->startSection('title','Historia'); ?>


<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item">
	<a href="<?php echo e(url('/admin/piezas/1')); ?>"><i class="fas fa-cog"></i> Piezas</a>
</li>
<li class="breadcrumb-item">
	<a href="<?php echo e(url('/admin/piezas/historia')); ?>"><i class="far fa-clock"></i> Historia</a>
</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">
	<div class="panel shadow">
			<div class="header">
				<h2 class="title"><i class="far fa-clock"></i> Historia</h2>
			</div>										
			<div class="inside">
				<div class="nav justify-content-end">
					<?php if(kvfj(Auth::user()->permisos, 'historia_buscar')): ?>					
						<?php echo Form::open(['url' => '/admin/piezas/historia/buscar']); ?>

							<div class="input-group mb-3">
								  <?php echo Form::text('buscar', null, ['class' => 'form-control form-control-sm','placeholder' => 'Buscar por']); ?>

								  <?php echo Form::select('filtro',['0'=>'ID','1'=>'Nombre pieza','2'=>'Responsable'], 0,['class'=>'form-select form-select-sm']); ?>

								  <?php echo Form::submit('Buscar', ['class'=> 'btn btn-outline-dark btn-sm']); ?>

							</div>
						<?php echo Form::close(); ?>

					<?php endif; ?>		
				</div>			
				
			
			<table style="text-align: center;" class="table table-hover mtop16">
				<thead class="table-dark">					
					<td>ID</td>
					<td>Pieza</td>
					<td>Responsable</td>
					<td>Fecha</td>
					<td></td>
				</thead>
				<tbody>
					<?php $__currentLoopData = $log; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<tr>
							<td><?php echo e($l->id); ?></td>
							<td><?php echo e($l->prods->name); ?></td>
							<td><?php echo e($l->user->name.' '.$l->user->lastname); ?></td>							
							<td><?php echo e($l->created_at->format('d/m/Y')); ?></td>
							<td>
								<?php if(kvfj(Auth::user()->permisos, 'remito_detalle')): ?>
									<?php if(is_null($l->deleted_at)): ?>
										<a href="<?php echo e(url('admin/piezas/historia/'.$l->id.'/detalle')); ?>" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Detalle">
											<i class="fas fa-info-circle"></i>
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
<?php echo $__env->make('admin.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH G:\www\cms\resources\views/admin/historia_piezas/buscar.blade.php ENDPATH**/ ?>