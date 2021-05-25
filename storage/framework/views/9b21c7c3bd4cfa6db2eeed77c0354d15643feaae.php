<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Piezas</title>
</head>
<body>
	<?php $__currentLoopData = $piezas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<tr <?php if($p->status == '0'): ?>
								class="table-secondary"
							<?php elseif($p->cantidad < '10'): ?>
								class="table-warning" 
							<?php endif; ?>>

							<td width="50"><?php echo e($p->id); ?></td>
							<td width="64">
								<a href="<?php echo e(url('/uploads/'.$p->file_path.'/'.$p->image)); ?>" data-fancybox="gallery">
									<img src="<?php echo e(url('/uploads/'.$p->file_path.'/t_'.$p->image)); ?>" width="64">
								</a>
							</td>
							<td><?php echo e($p->name); ?></td>
							<td><?php echo e($p->codigo); ?></td>
							<td><?php echo e($p->cat->name); ?></td>
							<td><?php echo e($p->cantidad); ?></td>
							<td><?php echo e($p->mark->name); ?></td>
							<td>

								<div class="opts">
									<?php if(kvfj(Auth::user()->permisos, 'piezas_editar')): ?>
									<a href="<?php echo e(url('admin/piezas/'.$p->id.'/edit')); ?>"data-toggle="tooltip" data-placement="top" title="Editar">
									<i class="fas fa-edit"></i>
									</a>
									<?php endif; ?>
									<?php if(kvfj(Auth::user()->permisos, 'piezas_eliminar')): ?>
										<?php if(is_null($p->deleted_at)): ?>
											<a href="#" data-path="admin/piezas" data-action="delete" data-object="<?php echo e($p->id); ?>" data-toggle="tooltip" data-placement="top" title="Eliminar" class="btn-deleted">
											<i class="fas fa-trash"></i>
											</a> 
										<?php else: ?>
											<a href="<?php echo e(url('/admin/piezas/'.$p->id.'/restore')); ?>" data-action="restore" data-path="admin/piezas" data-object="<?php echo e($p->id); ?>" data-toggle="tooltip" data-placement="top" title="Restaurar" class="btn-deleted">
											<i class="fas fa-trash-restore"></i>
											</a> 
										<?php endif; ?>
									<?php endif; ?>

								</div>
							</td>
							<td>
								<?php if($p->cantidad < '10'): ?>
									<p><i data-toggle="tooltip" title="Alerta stock" class="fas fa-exclamation-triangle fa-2x"></i></p>
								<?php endif; ?>
							</td>
						</tr>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</body>
</html>


<?php /**PATH G:\www\cms\resources\views/admin/pdf/pdf.blade.php ENDPATH**/ ?>