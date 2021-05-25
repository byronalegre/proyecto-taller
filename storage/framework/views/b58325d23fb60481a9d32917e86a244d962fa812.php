

<?php $__env->startSection('title','Remitos'); ?>

<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item">
	<a href="<?php echo e(url('/admin/compras/all')); ?>"><i class="fas fas fa-file-invoice-dollar"></i> Remitos</a>
</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">
	<div class="panel shadow">
		<div class="header">
			<h2 class="title"><i class="fas fas fa-file-invoice-dollar"></i> Remitos</h2>
		</div>
		<div class="inside">

				<div class="nav justify-content-end">				
					
					<div class="dropdown">
						  <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Filtrar </button>

						  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
						    <a class="dropdown-item" href="<?php echo e(url('admin/compras/all')); ?>"><i class="fas fa-list"></i> Todos</a>
						    <a class="dropdown-item" href="<?php echo e(url('admin/compras/trash')); ?>"><i class="fas fa-trash-alt"></i> Papelera</a>
						  </div>
					</div>

				</div>	

			<?php if(kvfj(Auth::user()->permisos, 'remitos_agregar')): ?>
			<a href="<?php echo e(url('admin/compras/agregar')); ?>" class="btn btn-success btn-sm">
			<i class="fas fa-plus-circle"></i> Nuevo remito
			</a>
			<?php endif; ?>

			<table class="table table-hover mtop16">
				<thead class="table-dark">
					<td style="text-align: center;">Código</td>
					<td width="1"></td>
					<td width="150" style="text-align: center;">Orden de Compra</td>
					<td style="text-align: center;">Proveedor</td>	
					<td style="text-align: center;">Responsable</td>				
					<td style="text-align: center;">Fecha registro</td>
					<td></td>
					<td width="90"></td>
				</thead>
				<tbody>
					<?php $__currentLoopData = $input; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<tr>
						<td style="text-align: center;"><?php echo e($i->codigo); ?> </td>	
						<td width="1"><i class="fas fa-exchange-alt" data-toggle="tooltip" data-placement="top" title="Corresponde a"></i></td>
						<td width="150" style="text-align: center;"><?php echo e($i->orden->codigo); ?> </td>
						<td style="text-align: center;"><?php echo e($i->provs->name); ?> </td>
						<td style="text-align: center;"><?php echo e(substr($i->responsable,4)); ?> </td>
						<td style="text-align: center;"><?php echo e($i->created_at->format('d/m/Y (H:i)')); ?> </td>	
						<td><i class="far fa-comment-dots fa-2x" data-toggle="tooltip" data-placement="top" title="<?php echo e($i->descripcion); ?>"></i></td>
						<td>
							<?php if(kvfj(Auth::user()->permisos, 'remito_detalle')): ?>
								<?php if(is_null($i->deleted_at)): ?>
									<a href="<?php echo e(url('admin/compras/'.$i->id.'/detalle')); ?>" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Detalle">
										<i class="fas fa-info-circle"></i>
									</a>				
								<?php endif; ?>			
							<?php endif; ?>
							<?php if(kvfj(Auth::user()->permisos, 'remitos_eliminar')): ?>
								<?php if(is_null($i->deleted_at)): ?>
									<a href="#" data-path="admin/compras" data-action="delete" data-object="<?php echo e($i->id); ?>" data-toggle="tooltip" data-placement="top" title="Anular" class="btn btn-danger btn-sm btn-deleted">
									<i class="fas fa-trash-alt"></i>
									</a> 
								<?php else: ?>
									<a href="<?php echo e(url('/admin/compras/'.$i->id.'/restore')); ?>" data-action="restore" data-path="admin/compras" data-object="<?php echo e($i->id); ?>" data-toggle="tooltip" data-placement="top" title="Restaurar" class="btn btn-success btn-sm btn-deleted">
									<i class="fas fa-trash-restore"></i>
									</a> 
								<?php endif; ?>
							<?php endif; ?>	
											
						</td>
					</tr>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>					
					<tr>
						<td colspan="8"> <?php echo $input->render(); ?></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH G:\www\cms\resources\views/admin/compras/home.blade.php ENDPATH**/ ?>