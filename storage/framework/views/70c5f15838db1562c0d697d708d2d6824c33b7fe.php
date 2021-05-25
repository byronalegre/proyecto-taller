

<?php $__env->startSection('title','Remitos'); ?>

<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item">
	<a href="<?php echo e(url('/admin/remitos/all')); ?>"><i class="fas fas fa-file-invoice-dollar"></i> Remitos</a>
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
				
				<form class="d-flex mx-2">
					<div class="input-group">
						<span class="input-group-text"><i class="fas fa-search"></i></span>
						<input name="search" type="text" class="form-control form-control-sm w-50" placeholder="Ingrese su búsqueda" aria-label="Ingrese su búsqueda" aria-describedby="button-addon2">
						<button class="btn btn-outline-dark btn-sm" type="submit" id="button-addon2">Buscar</button>
					</div>
				</form>
				<?php if(kvfj(Auth::user()->permisos, 'remitos_ordenar')): ?>
					<div class="dropdown mx-2">
						<button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"> Ordenar por </button>

						<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
							<li><h6 class="dropdown-header">Código</h6></li>
							<a class="dropdown-item" href="<?php echo e(url('admin/remitos/'.$status.'/id=asc')); ?>"><i class="fas fa-sort-amount-down-alt"></i> Ascendente</a>
							<a class="dropdown-item" href="<?php echo e(url('admin/remitos/'.$status.'/id=desc')); ?>"><i class="fas fa-sort-amount-down"></i> Descendente</a>
							<li><h6 class="dropdown-header">Importe</h6></li>
							<a class="dropdown-item" href="<?php echo e(url('admin/remitos/'.$status.'/importe_total=asc')); ?>"><i class="fas fa-sort-amount-down-alt"></i> Ascendente</a>
							<a class="dropdown-item" href="<?php echo e(url('admin/remitos/'.$status.'/importe_total=desc')); ?>"><i class="fas fa-sort-amount-down"></i> Descendente</a>
							<li><h6 class="dropdown-header">Fecha de registro</h6></li>
							<a class="dropdown-item" href="<?php echo e(url('admin/remitos/'.$status.'/created_at=asc')); ?>"><i class="fas fa-sort-amount-down-alt"></i> Ascendente</a>
							<a class="dropdown-item" href="<?php echo e(url('admin/remitos/'.$status.'/created_at=desc')); ?>"><i class="fas fa-sort-amount-down"></i> Descendente</a>
						</div> 					  
					</div>
				<?php endif; ?>
				<div class="dropdown mx-2">
						<button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"> Filtrar </button>

						<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
						<a class="dropdown-item" href="<?php echo e(url('admin/remitos/new')); ?>"><i class="fas fa-bell"></i> Nuevos</a>
						<a class="dropdown-item" href="<?php echo e(url('admin/remitos/all')); ?>"><i class="fas fa-list"></i> Todos</a>
						<a class="dropdown-item" href="<?php echo e(url('admin/remitos/trash')); ?>"><i class="fas fa-trash-alt"></i> Papelera</a>
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
				<?php if(kvfj(Auth::user()->permisos, 'remitos_agregar')): ?>
					<a href="<?php echo e(url('admin/remitos/agregar')); ?>" class="btn btn-success btn-sm">
						<i class="fas fa-plus-circle"></i> Nuevo remito
					</a>
				<?php endif; ?>
				
					<div class="btn-group dropend" id="pdf" style="display: none;">

					  <button type="button" class="btn btn-danger btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
					    <i data-toggle="tooltip" data-placement="top" title="Generar PDF" class="far fa-file-pdf"></i> PDF
					  </button>

					  <ul class="dropdown-menu" id="menu-pdf">
					  	<?php if(kvfj(Auth::user()->permisos, 'reporte_remitos_pdf')): ?>
					    	<li><a class="dropdown-item" href="<?php echo e(route('reporte_remitos_pdf')); ?>" target="_blank">PDF global</a></li>
					    <?php endif; ?>

					    <?php if(kvfj(Auth::user()->permisos, 'reporte_remitos_mes_pdf')): ?>
					    	<li><a class="dropdown-item" href="<?php echo e(route('reporte_remitos_mes_pdf')); ?>" target="_blank">PDF último mes</a></li>
					    <?php endif; ?>

					    <?php if(kvfj(Auth::user()->permisos, 'reporte_remitos_ano_pdf')): ?>
					    	<li><a class="dropdown-item" href="<?php echo e(route('reporte_remitos_ano_pdf')); ?>" target="_blank">PDF último año</a></li>
					    <?php endif; ?>
					  </ul>

					</div>
					
			</div>
			

			<table class="table table-hover mtop16" id="Datatable" style="width:100%">
				<thead class="table-dark">
					<td style="text-align: center;">Código</td>
					<td width="1"></td>
					<td width="100" style="text-align: center;">Orden de Compra</td>
					<td style="text-align: center;">Proveedor</td>	
					<td style="text-align: center;">Responsable</td>
					<td style="text-align: center;">Importe total ($)</td>
					<td style="text-align: center;">Fecha registro</td>
					<td width="90"></td>
				</thead>
				<tbody>
					<?php $__currentLoopData = $input; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<tr>
						<td style="text-align: center;"><?php echo e($i->codigo); ?> </td>	
						<td width="1"><i class="fas fa-exchange-alt" data-toggle="tooltip" data-placement="top" title="Corresponde a"></i></td>
						<td width="150" style="text-align: center;"><?php echo e($i->orden->codigo); ?> </td><!--mirar esto-->
						<td style="text-align: center;"><?php echo e($i->provs->name); ?> </td>
						<td style="text-align: center;"><?php echo e($i->user->name.' '.$i->user->lastname); ?> </td>						
						<td style="text-align: center;"><?php echo e($i->importe_total); ?> </td>
						<td style="text-align: center;"><?php echo e($i->created_at->format('d/m/Y')); ?> </td>	
						<td>
							<?php if(kvfj(Auth::user()->permisos, 'remito_detalle')): ?>
								<?php if(is_null($i->deleted_at)): ?>
									<a href="<?php echo e(url('admin/remitos/'.$i->id.'/detalle')); ?>" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Detalle">
										<i class="fas fa-info-circle"></i>
									</a>				
								<?php endif; ?>			
							<?php endif; ?>
							<?php if(kvfj(Auth::user()->permisos, 'remitos_eliminar')): ?>
								<?php if(is_null($i->deleted_at)): ?>
									<a href="#" data-path="admin/remitos" data-action="delete" data-object="<?php echo e($i->id); ?>" data-toggle="tooltip" data-placement="top" title="Anular" class="btn btn-danger btn-sm btn-deleted">
									<i class="fas fa-trash-alt"></i>
									</a> 
								<?php else: ?>
									<a href="<?php echo e(url('/admin/remitos/'.$i->id.'/restore')); ?>" data-action="restore" data-path="admin/remitos" data-object="<?php echo e($i->id); ?>" data-toggle="tooltip" data-placement="top" title="Restaurar" class="btn btn-success btn-sm btn-deleted">
									<i class="fas fa-trash-restore"></i>
									</a> 
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

<?php echo $__env->make('admin.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH G:\www\cms\resources\views/admin/remitos/home.blade.php ENDPATH**/ ?>