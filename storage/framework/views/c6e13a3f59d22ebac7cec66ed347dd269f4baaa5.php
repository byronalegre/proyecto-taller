

<?php $__env->startSection('title','Ordenes de Pedido'); ?>

<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item">
	<a href="<?php echo e(url('/admin/ordenespedido/all')); ?>"><i class="fas fa-file-invoice"></i> Ordenes de Pedido</a>
</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">
	<div class="panel shadow">
		<div class="header">
			<h2 class="title"><i class="fas fa-file-invoice"></i> Ordenes de Pedido</h2>
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
					<?php if(kvfj(Auth::user()->permisos, 'pedidos_ordenar')): ?>
						<div class="dropdown mx-2">
							<button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"> Ordenar por </button>
		
							<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
							<li><h6 class="dropdown-header">Código</h6></li>
							<a class="dropdown-item" href="<?php echo e(url('admin/ordenespedido/'.$status.'/id=asc')); ?>"><i class="fas fa-sort-amount-down-alt"></i> Ascendente</a>
							<a class="dropdown-item" href="<?php echo e(url('admin/ordenespedido/'.$status.'/id=desc')); ?>"><i class="fas fa-sort-amount-down"></i> Descendente</a>
							<li><h6 class="dropdown-header">Fecha de registro</h6></li>
							<a class="dropdown-item" href="<?php echo e(url('admin/ordenespedido/'.$status.'/created_at=asc')); ?>"><i class="fas fa-sort-amount-down-alt"></i> Ascendente</a>
							<a class="dropdown-item" href="<?php echo e(url('admin/ordenespedido/'.$status.'/created_at=desc')); ?>"><i class="fas fa-sort-amount-down"></i> Descendente</a>
							<li><h6 class="dropdown-header">Fecha programada</h6></li>
							<a class="dropdown-item" href="<?php echo e(url('admin/ordenespedido/'.$status.'/fecha_prog=asc')); ?>"><i class="fas fa-sort-amount-down-alt"></i> Ascendente</a>
							<a class="dropdown-item" href="<?php echo e(url('admin/ordenespedido/'.$status.'/fecha_prog=desc')); ?>"><i class="fas fa-sort-amount-down"></i> Descendente</a>
							<li><h6 class="dropdown-header">Estado</h6></li>
							<a class="dropdown-item" href="<?php echo e(url('admin/ordenespedido/'.$status.'/status=asc')); ?>"><i class="fas fa-sort-amount-down-alt"></i> Ascendente</a>
							<a class="dropdown-item" href="<?php echo e(url('admin/ordenespedido/'.$status.'/status=desc')); ?>"><i class="fas fa-sort-amount-down"></i> Descendente</a>
							</div> 					  
						</div>
					<?php endif; ?>
					<div class="dropdown mx-2">
						  <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"> Filtrar </button>

						  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
						  	<a class="dropdown-item" href="<?php echo e(url('admin/ordenespedido/new')); ?>"><i class="fas fa-bell"></i> Nuevas</a>
						    <a class="dropdown-item" href="<?php echo e(url('admin/ordenespedido/all')); ?>"><i class="fas fa-list"></i> Todos</a>
						    <a class="dropdown-item" href="<?php echo e(url('admin/ordenespedido/0')); ?>"><i class="fas fa-clock"></i> Pendientes</a>
						    <a class="dropdown-item" href="<?php echo e(url('admin/ordenespedido/1')); ?>"><i class="fas fa-check-double"></i> Completadas</a>
						    <a class="dropdown-item" href="<?php echo e(url('admin/ordenespedido/2')); ?>"><i class="fas fa-times"></i> Rechazadas</a>
						    <a class="dropdown-item" href="<?php echo e(url('admin/ordenespedido/trash')); ?>"><i class="fas fa-trash-alt"></i> Papelera</a>
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
				<?php if(kvfj(Auth::user()->permisos, 'pedidos_agregar')): ?>
					<a href="<?php echo e(url('admin/ordenespedido/agregar')); ?>" class="btn btn-success btn-sm">
						<i class="fas fa-plus-circle"></i> Nueva orden
					</a>
				<?php endif; ?>
				
					<div class="btn-group dropend" id="pdf" style="display: none;">

					  <button type="button" class="btn btn-danger btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
					    <i data-toggle="tooltip" data-placement="top" title="Generar PDF" class="far fa-file-pdf"></i> PDF
					  </button>

					  <ul class="dropdown-menu" id="menu-pdf">
					  	<?php if(kvfj(Auth::user()->permisos, 'reporte_pedidos_pdf')): ?>
					   		<li><a class="dropdown-item" href="<?php echo e(route('reporte_pedidos_pdf')); ?>" target="_blank">PDF global</a></li>
					    <?php endif; ?>

					    <?php if(kvfj(Auth::user()->permisos, 'reporte_pedidos_mes_pdf')): ?>
					    	<li><a class="dropdown-item" href="<?php echo e(route('reporte_pedidos_mes_pdf')); ?>" target="_blank">PDF último mes</a></li>
					    <?php endif; ?>

					    <?php if(kvfj(Auth::user()->permisos, 'reporte_pedidos_ano_pdf')): ?>
					    	<li><a class="dropdown-item" href="<?php echo e(route('reporte_pedidos_ano_pdf')); ?>" target="_blank">PDF último año</a></li>
					    <?php endif; ?>
					  </ul>

					</div>
					
			</div>			

			<table class="table table-hover mtop16" id="Datatable" style="width:100%">
				<thead class="table-dark">
					<td hidden="true"></td>
					<td style="text-align: center;">Código</td>
					<td style="text-align: center;">Responsable</td>				
					<td style="text-align: center;">Fecha registro</td>
					<td style="text-align: center;">Fecha programada</td>
					<td style="text-align: center;">Estado</td>
					<td width="120"></td>
				</thead>
				<tbody>
					<?php $__currentLoopData = $input; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<tr>
						<td hidden="true"><?php echo e($i->id); ?></td>
						<td style="text-align: center;"><?php echo e($i->codigo); ?> </td>	
						<td style="text-align: center;"><?php echo e($i->user->name.' '.$i->user->lastname); ?> </td>
						<td style="text-align: center;"><?php echo e($i->created_at->format('d/m/Y (H:i)')); ?> </td>
						<?php if($i->fecha_prog < date('Y-m-d') and ($i->status == '0')): ?>
							<td style="text-align: center;"><?php echo e(date('d/m/Y',strtotime($i->fecha_prog))); ?> 
								<span class="badge bg-danger">Expirada</span>
							</td>
						<?php else: ?>
							<td style="text-align: center;"><?php echo e(date('d/m/Y',strtotime($i->fecha_prog))); ?> </td>
						<?php endif; ?>
						<td style="text-align: center;" width="150"> 	
							<?php if($i->status == '0'): ?>
							<div class="progress">
							  <div class="progress-bar progress-bar-striped bg-warning" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" data-placement="top" title="Pendiente"></div>
							</div>
							<?php endif; ?>							
							<?php if($i->status == '1'): ?>
							<div class="progress">
							  <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" data-placement="top" title="Completada"></div>
							</div>
							<?php endif; ?>
							<?php if($i->status == '2'): ?>
							<div class="progress">
							  <div class="progress-bar progress-bar-striped bg-danger" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" data-placement="top" title="Rechazadas"></div>
							</div>
							<?php endif; ?>
						</td>				

						<td>
							<?php if(kvfj(Auth::user()->permisos, 'pedido_detalle')): ?>
								<?php if(is_null($i->deleted_at)): ?>
									<a href="<?php echo e(url('admin/ordenespedido/'.$i->id.'/detalle')); ?>" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Detalle">
										<i class="fas fa-info-circle"></i>
									</a>				
								<?php endif; ?>			
							<?php endif; ?>
							<?php if(kvfj(Auth::user()->permisos, 'pedidos_eliminar')): ?>
								<?php if(is_null($i->deleted_at)): ?>
									<a href="#" data-path="admin/ordenespedido" data-action="delete" data-object="<?php echo e($i->id); ?>" data-toggle="tooltip" data-placement="top" title="Anular" class="btn btn-danger btn-sm btn-deleted">
									<i class="fas fa-trash-alt"></i>
									</a> 
								<?php else: ?>
									<a href="<?php echo e(url('/admin/ordenespedido/'.$i->id.'/restore')); ?>" data-action="restore" data-path="admin/ordenespedido" data-object="<?php echo e($i->id); ?>" data-toggle="tooltip" data-placement="top" title="Restaurar" class="btn btn-success btn-sm btn-deleted">
									<i class="fas fa-trash-restore"></i>
									</a> 
								<?php endif; ?>
							<?php endif; ?>	
							<?php if(kvfj(Auth::user()->permisos, 'compras_agregar_directo')): ?>
								<?php if($i->status == 0): ?>
									<?php if(is_null($i->deleted_at)): ?>
									<a href=" <?php echo e(url('/admin/ordenescompra/agregar/'.$i->id)); ?> " class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Generar Orden de Compra">
										<i class="fas fa-arrow-circle-right"></i>
									</a>	
									<?php endif; ?>	
								<?php endif; ?>
							<?php endif; ?>
						</td>
					</tr>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>	
				</tbody>
			</table>
			<?php if($search): ?>				
				<?php echo e($input->appends(['search'=>$search])); ?>

				<p class="mtop16">
					Mostrando <?php echo e($input->count()); ?> de <?php echo e($input->total()); ?> elemento(s).
				</p>	
			<?php else: ?>
				<?php echo e($input->links()); ?>

				<p class="mtop16">
					Mostrando <?php echo e($input->count()); ?> de <?php echo e($input->total()); ?> elemento(s).
				</p>
			<?php endif; ?>
		</div>
	</div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH G:\www\cms\resources\views/admin/ordenespedido/home.blade.php ENDPATH**/ ?>