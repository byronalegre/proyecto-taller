

<?php $__env->startSection('title','Piezas'); ?>


<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item">
	<a href="<?php echo e(url('/admin/piezas/1/name=asc')); ?>"><i class="fas fa-cog"></i> Piezas</a>
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
									
					<form class="d-flex mx-2">							
						<div class="input-group">
							<span class="input-group-text"><i class="fas fa-search"></i></span>
							<input name="search" type="text" class="form-control form-control-sm w-50" placeholder="Ingrese su búsqueda" aria-label="Ingrese su búsqueda" aria-describedby="button-addon2">
							<button class="btn btn-outline-dark btn-sm" type="submit" id="button-addon2">Buscar</button>
						</div>
					</form>
					<?php if(kvfj(Auth::user()->permisos, 'piezas_ordenar')): ?>
						<div class="dropdown mx-2">
							<button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"> Ordenar por </button>

							<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
							<li><h6 class="dropdown-header">Nombre</h6></li>
							<a class="dropdown-item" href="<?php echo e(url('admin/piezas/'.$status.'/name=asc')); ?>"><i class="fas fa-sort-amount-down-alt"></i> Ascendente</a>
							<a class="dropdown-item" href="<?php echo e(url('admin/piezas/'.$status.'/name=desc')); ?>"><i class="fas fa-sort-amount-down"></i> Descendente</a>
							<li><h6 class="dropdown-header">Código</h6></li>
							<a class="dropdown-item" href="<?php echo e(url('admin/piezas/'.$status.'/codigo=asc')); ?>"><i class="fas fa-sort-amount-down-alt"></i> Ascendente</a>
							<a class="dropdown-item" href="<?php echo e(url('admin/piezas/'.$status.'/codigo=desc')); ?>"><i class="fas fa-sort-amount-down"></i> Descendente</a>
							<li><h6 class="dropdown-header">Depósito</h6></li>
							<a class="dropdown-item" href="<?php echo e(url('admin/piezas/'.$status.'/deposito=asc')); ?>"><i class="fas fa-sort-amount-down-alt"></i> Ascendente</a>
							<a class="dropdown-item" href="<?php echo e(url('admin/piezas/'.$status.'/deposito=desc')); ?>"><i class="fas fa-sort-amount-down"></i> Descendente</a>
							<li><h6 class="dropdown-header">Cantidad</h6></li>
							<a class="dropdown-item" href="<?php echo e(url('admin/piezas/'.$status.'/cantidad=asc')); ?>"><i class="fas fa-sort-amount-down-alt"></i> Ascendente</a>
							<a class="dropdown-item" href="<?php echo e(url('admin/piezas/'.$status.'/cantidad=desc')); ?>"><i class="fas fa-sort-amount-down"></i> Descendente</a>
							</div> 					  
						</div>
					<?php endif; ?>
					<div class="dropdown mx-2">
						  <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"> Filtrar </button>

						  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
						    <a class="dropdown-item" href="<?php echo e(url('admin/piezas/all')); ?>"><i class="fas fa-list"></i> Todos</a>
						    <a class="dropdown-item" href="<?php echo e(url('admin/piezas/1')); ?>"><i class="fas fa-check"></i> Activos</a>
						    <a class="dropdown-item" href="<?php echo e(url('admin/piezas/0')); ?>"><i class="fas fa-times"></i> Inactivos</a>
						    <a class="dropdown-item" href="<?php echo e(url('admin/piezas/trash')); ?>"><i class="fas fa-trash-alt"></i> Papelera</a>
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
				
				<div class="btns my-2">	
					<?php if(kvfj(Auth::user()->permisos, 'piezas_agregar')): ?>
						<a href="<?php echo e(url('admin/piezas/agregar')); ?>" class="btn btn-success btn-sm">
							<i class="fas fa-plus-circle"></i> Agregar pieza
						</a>
					<?php endif; ?>
					<?php if(kvfj(Auth::user()->permisos, 'piezas_pdf')): ?>
					<a data-toggle="tooltip" data-placement="top" title="Generar PDF" href="<?php echo e(route('piezas_pdf')); ?>" class="btn btn-sm btn-danger" target="_blank">
	           			<i data-toggle="tooltip" data-placement="top" title="Generar PDF" class="far fa-file-pdf"></i>
	           			PDF 
	       			</a>
	       			<?php endif; ?>
				</div>				
			
			<table class="table table-hover" id="Datatable" style="width:100%; text-align: center;">
				<thead class="table-dark">
					<td hidden="true">ID</td>
					<td></td>
					<td>Nombre</td>
					<td>Código</td>
					<td>Depósito</td>
					
					<td>Cantidad</td>
					
					<td width="90"></td>
					<td width="auto"></td>
				</thead>
				<tbody>
					<?php $__currentLoopData = $piezas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<tr <?php if(($p->cantidad < $p->cantidad_min) && ($p->cantidad != 0)): ?>
								class="table-warning" 
							<?php elseif($p->cantidad == 0): ?>
								class="table-danger" 
							<?php endif; ?>>

							<td hidden="true"><?php echo e($p->id); ?></td>
							<td width="64">
								<a href="<?php echo e(url('/uploads/'.$p->file_path.'/'.$p->image)); ?>" data-fancybox="gallery">
									<img src="<?php echo e(url('/uploads/'.$p->file_path.'/t_'.$p->image)); ?>" width="64">
								</a>
							</td>
							<td><?php echo e($p->name); ?></td>
							<td><?php echo e($p->codigo); ?></td>
							<td><?php echo e($p->deposito); ?></td>
							
							<td><?php echo e($p->cantidad); ?></td>

							
							<td>
								<?php if(kvfj(Auth::user()->permisos, 'pieza_detalle')): ?>
									<?php if(is_null($p->deleted_at)): ?>
										<a class="btn btn-primary btn-sm" href="<?php echo e(url('admin/piezas/'.$p->id.'/detalle')); ?>" data-toggle="tooltip" data-placement="top" title="Detalle">
										<i class="fas fa-info-circle"></i>
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
							<td style="text-align: center; padding-right: 0px; padding-left: 0px;">
								<?php if(($p->cantidad < $p->cantidad_min) && ($p->cantidad != 0)): ?>
									<span class="badge bg-warning text-dark"> Alerta Stock</span>
								<?php endif; ?>
								<?php if($p->cantidad == 0): ?>
									<span class="badge bg-danger text-dark"> Alerta Stock</span>
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
			<?php if($search): ?>				
				<?php echo e($piezas->appends(['search'=>$search])); ?>

				<p class="mtop16">
					Mostrando <?php echo e($piezas->count()); ?> de <?php echo e($piezas->total()); ?> elemento(s).
				</p>	
			<?php else: ?>
				<?php echo e($piezas->links()); ?>

				<p class="mtop16">
					Mostrando <?php echo e($piezas->count()); ?> de <?php echo e($piezas->total()); ?> elemento(s).
				</p>
			<?php endif; ?>
		</div>
	</div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH G:\www\cms\resources\views/admin/piezas/home.blade.php ENDPATH**/ ?>