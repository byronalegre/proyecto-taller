

<?php $__env->startSection('title','Piezas'); ?>


<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item">
	<a href="<?php echo e(url('/admin/piezas/1')); ?>"><i class="fas fa-cog"></i> Piezas</a>
</li>
<?php $__env->stopSection(); ?>
 

<?php $__env->startSection('content'); ?>

<div class="container-fluid">
	<div class="panel shadow">
			<div class="header">
				<h2 class="title"><i class="fas fa-cog"></i> Piezas</h2>
			</div>
		<div class="inside">
				<div class="nav justify-content-end">
							<div class="nav justify-content-end">
								<?php if(kvfj(Auth::user()->permisos, 'piezas_buscar')): ?>					
									<?php echo Form::open(['url' => '/admin/piezas/buscar']); ?>

										<div class="input-group  mb-3">
											  <?php echo Form::text('buscar', null, ['class' => 'form-control form-control-sm','placeholder' => 'Buscar por']); ?>

											  <?php echo Form::select('filtro',['0'=>'ID','1'=>'Nombre','2'=>'Código','3'=>'Depósito'], 0,['class'=>'form-select form-select-sm']); ?>

											  <?php echo Form::submit('Buscar', ['class'=> 'btn btn-outline-dark btn-sm']); ?>

										</div>
									<?php echo Form::close(); ?>

								<?php endif; ?>							
											
								<div class="dropdown pl-3">
									  <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Filtrar </button>

									  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
									    <a class="dropdown-item" href="<?php echo e(url('admin/piezas/all')); ?>"><i class="fas fa-list"></i> Todos</a>
									    <a class="dropdown-item" href="<?php echo e(url('admin/piezas/1')); ?>"><i class="fas fa-check"></i> Activos</a>
									    <a class="dropdown-item" href="<?php echo e(url('admin/piezas/0')); ?>"><i class="fas fa-times"></i> Inactivos</a>
									    <a class="dropdown-item" href="<?php echo e(url('admin/piezas/trash')); ?>"><i class="fas fa-trash-alt"></i> Papelera</a>

									  </div>
								</div>
							</div>
					</div>		
				
			<div class="btns">	
				<?php if(kvfj(Auth::user()->permisos, 'piezas_agregar')): ?>
					<a href="<?php echo e(url('admin/piezas/agregar')); ?>" class="btn btn-success btn-sm">
						<i class="fas fa-plus-circle"></i> Agregar pieza
					</a>
				<?php endif; ?>
				<?php if(kvfj(Auth::user()->permisos, 'piezas_pdf')): ?>
				<a data-toggle="tooltip" data-placement="top" title="Generar PDF" href="<?php echo e(route('piezas_pdf')); ?>" class="btn btn-sm btn-danger">PDF
           			<i data-toggle="tooltip" data-placement="top" title="Generar PDF" class="far fa-file-pdf"></i>
       			</a>
       			<?php endif; ?>
			</div> 
	
			<table class="table table-hover mtop16">
				<thead class="table-dark">
					<td>ID</td>
					<td></td>
					<td>Nombre</td>
					<td>Código</td>
					<td>Depósito</td>
					<td>Categoría</td>
					<td>Mínimo</td>
					<td>Cantidad</td>
					<td>Marca</td>
					<td width="90"></td>
					<td width="auto"></td>
				</thead>
				<tbody>
					<?php $__currentLoopData = $piezas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<tr <?php if($p->cantidad < $p->cantidad_min): ?>
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
							<td style="text-align: center"><?php echo e($p->deposito); ?></td>
							<td><?php echo e($p->cat->name); ?></td>
							<td><?php echo e($p->cantidad_min); ?></td>
							<td><?php echo e($p->cantidad); ?></td>
							<td><?php echo e($p->mark->name); ?></td>
							<td>
								<?php if(kvfj(Auth::user()->permisos, 'piezas_editar')): ?>
									<?php if(is_null($p->deleted_at)): ?>
										<a class="btn btn-primary btn-sm" href="<?php echo e(url('admin/piezas/'.$p->id.'/edit')); ?>"data-toggle="tooltip" data-placement="top" title="Editar">
										<i class="fas fa-edit"></i>
										</a>
									<?php endif; ?>
								<?php endif; ?>

								<?php if(kvfj(Auth::user()->permisos, 'piezas_eliminar')): ?>
									<?php if(is_null($p->deleted_at)): ?>
										<a href="#" data-path="admin/piezas" data-action="delete" data-object="<?php echo e($p->id); ?>" data-toggle="tooltip" data-placement="top" title="Eliminar" class="btn btn-danger btn-sm btn-deleted">
										<i class="fas fa-trash-alt"></i>
										</a> 
									<?php else: ?>
										<a href="<?php echo e(url('/admin/piezas/'.$p->id.'/restore')); ?>" data-action="restore" data-path="admin/piezas" data-object="<?php echo e($p->id); ?>" data-toggle="tooltip" data-placement="top" title="Restaurar" class="btn btn-success btn-sm btn-deleted">
										<i class="fas fa-trash-restore"></i>
										</a> 
									<?php endif; ?>
								<?php endif; ?>
							</td>
							<td style="text-align: center;">
								<?php if($p->cantidad < $p->cantidad_min): ?>
									<span class="badge bg-warning text-dark"> Alerta Stock</span>
								<?php endif; ?>
								<br>
								<?php if($p->status == '0'): ?> 
									<span class="badge bg-dark">
										<i class="fas fa-eye-slash" data-toggle="tooltip" data-placement="top" title="Inactivo"></i>
									</span>
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
<?php echo $__env->make('admin.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH G:\www\cms\resources\views/admin/piezas/buscar.blade.php ENDPATH**/ ?>