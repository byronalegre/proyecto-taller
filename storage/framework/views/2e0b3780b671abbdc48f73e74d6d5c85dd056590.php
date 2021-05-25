

<?php $__env->startSection('title','Historial de cambios'); ?>

<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item">
	<a href="<?php echo e(url('/admin/piezas/1')); ?>"><i class="fas fa-cog"></i> Piezas</a>
</li>
<li class="breadcrumb-item">
	<a href="<?php echo e(url('/admin/piezas/'.$id.'/detalle')); ?>"><i class="fas fa-info-circle"></i> Detalle pieza </a>
</li>
<li class="breadcrumb-item">
	<a href="<?php echo e(url('/admin/piezas/'.$id.'/detalle/historia_cambio')); ?>"><i class="fas fa-history"></i> Historial de cambios</a>
</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">
	<?php if($log->total() != 0): ?>
		<div class="panel shadow">
				<div class="header">
					<h2 class="title"><i class="fas fa-history"></i> Historial de cambios</h2>
				</div>										
				<div class="inside">	
					<div class="row mb-2">
						<div class="col-sm-3">
							<form>
								<div class="input-group input-group-sm">
									<span class="input-group-text" id="basic-addon1">Mostrar</span>
									<input name="paginate" type="number" class="form-control" aria-describedby="basic-addon1" placeholder="<?php echo e(session('paginate')); ?> elementos" min="1" >
								</div>
							</form>
						</div>	
					</div>			
					<table style="text-align: center;" class="table table-hover" id="Datatable">
						<thead class="table-dark">			
							<td>Responsable</td>
							<td>Fecha Edición</td>
							<td></td>
						</thead>
						<tbody>
							<?php $__currentLoopData = $log; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<tr>
									<td><?php echo e($l->user->name.' '.$l->user->lastname); ?></td>							
									<td><?php echo e($l->created_at->format('d/m/Y')); ?></td>
									<td>
										<?php if(kvfj(Auth::user()->permisos, 'historia_detalle')): ?>
											<?php if(is_null($l->deleted_at)): ?>
												<a href="<?php echo e(url('admin/piezas/'.$id.'/detalle/historia_cambio/'.$l->id.'/detalle')); ?>" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Detalle">
													<i class="fas fa-info-circle"></i>
												</a>				
											<?php endif; ?>			
										<?php endif; ?>
									</td>
								</tr>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>								
						</tbody>
					</table>
				<?php echo e($log->links()); ?>

				<p class="mtop16">
					Mostrando <?php echo e($log->count()); ?> de <?php echo e($log->total()); ?> elemento(s).
				</p>
			</div>
		</div>
	<?php else: ?>
		<div class="panel shadow mtop16">
			<div class="header">
				<h2 class="title"><i class="fas fa-chart-line"></i> Gráfico de línea</h2>
			</div>
			
			<div class="inside">
				<div class="alert alert-dark" style="text-align: center;">
					No existe información sobre cambios.
				</div>
			</div>
		</div>
	<?php endif; ?>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH G:\www\cms\resources\views/admin/historia_piezas/home.blade.php ENDPATH**/ ?>