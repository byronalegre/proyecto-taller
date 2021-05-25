

<?php $__env->startSection('title','Ordenes de compra'); ?>

<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item">
	<a href="<?php echo e(url('/admin/ordenescompra/all')); ?>"><i class="fas fa-cart-plus"></i> Ordenes de Compra</a>
</li>
<li class="breadcrumb-item">
	<a href="<?php echo e(url('/admin/ordenescompra/'.$c->id.'/detalle')); ?>"><i class="fas fa-info-circle"></i> Detalle Orden de Compra: <?php echo e($c->codigo); ?></a>
</li>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">
	<div class="panel shadow">
		<div class="header">
			<h2 class="title"><i class="fas fa-info-circle"></i> Detalle</h2>
		</div>
		<div class="inside">
			<div class="card text-center">
			  <div class="card-header">
			    <div>
					<b>CODIGO:</b>
					<a><?php echo e($c->codigo); ?></a>
				</div>
			  </div>

			  <div class="card-body">
			  	<div style="text-align: right">
					<?php if($c->status == '0'): ?>		
						<?php if(kvfj(Auth::user()->permisos, 'compras_editar')): ?>
							<a class="btn btn-primary btn-sm" href="<?php echo e(url('admin/ordenescompra/'.$c->id.'/edit')); ?>" data-toggle="tooltip" data-placement="top" title="Editar">
							<i class="fas fa-edit"></i>
							</a>
						<?php endif; ?>
						<?php if(kvfj(Auth::user()->permisos, 'remitos_agregar_directo')): ?>
							<?php if(is_null($c->deleted_at)): ?>
								<a href=" <?php echo e(url('/admin/remitos/agregar/'.$c->id)); ?> " class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Generar Remito">
									<i class="fas fa-arrow-circle-right"></i>
								</a>				
							<?php endif; ?>	
						<?php endif; ?>	
					<?php endif; ?>
					<?php if(kvfj(Auth::user()->permisos, 'detalle_compra_pdf')): ?>
						<a href="<?php echo e(url('admin/ordenescompra/'.$c->id.'/detalle/ordencompra_pdf')); ?>" data-toggle="tooltip" data-placement="top" title="Generar PDF" class="btn btn-danger btn-sm" target="_blank">
							<i class="far fa-file-pdf"></i>
							PDF
						</a>
					<?php endif; ?>
				</div>
			    <h5 class="card-title">
			    	<div>
						<b>CORRESPONDE A ORDEN DE PEDIDO:</b>
						<a> <?php echo e($c->orden->codigo); ?> </a> 
					</div>			    	
			    </h5>
			    <p class="card-text">
			    	<div>
						<b>PROVEEDOR:</b>
						<a><?php echo e($c->provs->name); ?></a>
					</div>

			    	<div>
						<b>RESPONSABLE:</b>
						<a><?php echo e($c->user->name.' '.$c->user->lastname); ?></a>
					</div>

					<div>
						<b>FECHA:</b>
						<a><?php echo e($c->created_at->format('d/m/Y')); ?></a>
					</div>

					<div>
						<b>DESCRIPCIÓN:</b>
						<a><?php echo e($c->descripcion); ?></a>
					</div>
			    </p>
			  </div>
			  <?php if($c->status == '0'): ?>
					<div class="progress">
					  <div class="progress-bar progress-bar-striped bg-warning" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" data-placement="top" title="Pendiente">				  	
					  </div>
					</div>
				<?php endif; ?>
				<?php if($c->status == '1'): ?>
					<div class="progress">
					  <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" data-placement="top" title="Completada">				  	
					  </div>
					</div>
				<?php endif; ?>
				<?php if($c->status == '2'): ?>
					<div class="progress">
					  <div class="progress-bar progress-bar-striped bg-danger" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" data-placement="top" title="Rechazada">				  	
					  </div>
					</div>
				<?php endif; ?>

			  <div class="card-footer text-muted p-0">
			    	<table class="table mtop16">
		                <thead class="table-dark">                	
		                    <tr>
			                    <td>PRODUCTO</td>
			                    <td>CANTIDAD</td>
			                    <td>PRECIO UNITARIO</td>
			                    <td>IMPORTE</td>
		                    </tr>
		                </thead>
		                <tbody >
		                	<?php $__currentLoopData = $c->detalle; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<tr>
									<td><?php echo e($value->prods[0]->name); ?></td>
									<td><?php echo e($value['cantidad_req']); ?></td>
									<td>$<?php echo e($value['precio']); ?></td>
									<td>$<?php echo e($value['cantidad_req']*$value['precio']); ?></td>
									<td hidden="true"><?php echo e($acum += ($value['cantidad_req']*$value['precio'])); ?></td>
									</tr>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		                </tbody>
		                <tfoot class="table-danger">
		            		<td>Total:</td>
		            		<td colspan="2"></td>					
							<td class="table-active"><b>$<?php echo e($acum); ?></b></td>
		           		</tfoot>
		            </table>
			  </div>
			</div>
		</div>
	</div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH G:\www\cms\resources\views/admin/ordenescompra/detalle.blade.php ENDPATH**/ ?>