

<?php $__env->startSection('title','Detalle historial'); ?>


<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item">
	<a href="<?php echo e(url('/admin/piezas/1/name=asc')); ?>"><i class="fas fa-cog"></i> Piezas</a>
</li>
<li class="breadcrumb-item">
	<a href="<?php echo e(url('/admin/piezas/'.$log->pieza_id.'/detalle')); ?>"><i class="fas fa-info-circle"></i> Detalle pieza </a>
</li>
<li class="breadcrumb-item">
	<a href="<?php echo e(url('/admin/piezas/'.$log->pieza_id.'/detalle/historia_cambio')); ?>"><i class="fas fa-history"></i> Historial de cambios</a>
</li>
<li class="breadcrumb-item">
	<a href="<?php echo e(url('/admin/piezas/'.$log->pieza_id.'/detalle/historia_cambio/'.$log->id.'/detalle')); ?>"><i class="fas fa-info-circle"></i> Detalle historial</a>
</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">
	<div class="panel shadow">
			<div class="header">
				<h2 class="title"><i class="fas fa-info-circle"></i> Detalle historial</h2>
			</div>	
			<div class="inside">
				<div style="justify-content: center;" class="row">
					<div class="col-md-4 mt-auto mb-auto">
						<div class="card bg-dark" style="width: 18rem;">
						  <div class="card-header text-white">
						    Valores anteriores
						  </div>
						  <ul class="list-group list-group-flush">
						 	<?php $__currentLoopData = json_decode($log->old_values,true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$o): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>								
								<?php switch($key):
									case ('codigo'): ?>
								        <li class="list-group-item"><strong>Código: </strong><?php echo e($o); ?></li>
								        <?php break; ?>
								    <?php case ('status'): ?>
								        <li class="list-group-item"><strong>Estado: </strong><?php if($o == 0): ?> Inactivo <?php else: ?> Activo <?php endif; ?></li>
								        <?php break; ?>
								    <?php case ('name'): ?>
								        <li class="list-group-item"><strong>Nombre: </strong><?php echo e($o); ?></li>
								        <?php break; ?>
								    <?php case ('categoria_id'): ?>
								        <li class="list-group-item"><strong>Categoría: </strong><?php echo e($cat[$o]); ?></li>
								        <?php break; ?>
								    <?php case ('cantidad'): ?>
								        <li class="list-group-item"><strong>Cantidad: </strong><?php echo e($o); ?></li>
								       	<?php break; ?>
								    <?php case ('cantidad_min'): ?>
								        <li class="list-group-item"><strong>Cantidad mínima: </strong><?php echo e($o); ?></li>
								        <?php break; ?>
								    <?php case ('marca'): ?>
								        <li class="list-group-item"><strong>Marca: </strong><?php echo e($cat[$o]); ?></li>
								        <?php break; ?>
								    <?php case ('deposito'): ?>
								        <li class="list-group-item"><strong>Depósito: </strong><?php echo e($o); ?></li>
								        <?php break; ?>
								    <?php case ('image'): ?>
								       <li class="list-group-item"><strong>Nombre imagen: </strong><?php echo e($o); ?></li>
								        <?php break; ?>
								<?php endswitch; ?>					
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</ul>	
						</div>
					</div>
					<div class="col-md-2 mt-auto mb-auto">
						<i class="fas fa-exchange-alt fa-4x"></i>
					</div>
					<div class="col-md-4 mt-auto mb-auto">
						<div class="card bg-success" style="width: 18rem;">
						  <div class="card-header text-white">
						    Valores nuevos
						  </div>
						  <ul class="list-group list-group-flush">
						 	<?php $__currentLoopData = json_decode($log->new_values,true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$o): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>								
								<?php switch($key):
									case ('codigo'): ?>
								        <li class="list-group-item"><strong>Código: </strong><?php echo e($o); ?></li>
								        <?php break; ?>
								    <?php case ('status'): ?>
								        <li class="list-group-item"><strong>Estado: </strong><?php if($o == 0): ?> Inactivo <?php else: ?> Activo <?php endif; ?></li>
								        <?php break; ?>
								    <?php case ('name'): ?>
								        <li class="list-group-item"><strong>Nombre: </strong><?php echo e($o); ?></li>
								        <?php break; ?>
								    <?php case ('categoria_id'): ?>
								        <li class="list-group-item"><strong>Categoría: </strong><?php echo e($cat[$o]); ?></li>
								        <?php break; ?>
								    <?php case ('cantidad'): ?>
								        <li class="list-group-item"><strong>Cantidad: </strong><?php echo e($o); ?></li>
								       	<?php break; ?>
								    <?php case ('cantidad_min'): ?>
								        <li class="list-group-item"><strong>Cantidad mínima: </strong><?php echo e($o); ?></li>
								        <?php break; ?>
								    <?php case ('marca'): ?>
								        <li class="list-group-item"><strong>Marca: </strong><?php echo e($cat[$o]); ?></li>
								        <?php break; ?>
								    <?php case ('deposito'): ?>
								        <li class="list-group-item"><strong>Depósito: </strong><?php echo e($o); ?></li>
								        <?php break; ?>
								    <?php case ('image'): ?>
								       <li class="list-group-item"><strong>Nombre imagen: </strong><?php echo e($o); ?></li>
								        <?php break; ?>
								<?php endswitch; ?>					
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</ul>	
						</div>
					</div>
				</div>
		</div>
	</div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH G:\www\cms\resources\views/admin/historia_piezas/detalle.blade.php ENDPATH**/ ?>