

<?php $__env->startSection('title','Remitos'); ?>

<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item">
	<a href="<?php echo e(url('/admin/remitos/all')); ?>"><i class="fas fa-file-invoice-dollar"></i> Remitos</a>
</li>
<li class="breadcrumb-item">
	<a href="<?php echo e(url('/admin/remitos/'.$r->id.'/detalle')); ?>"><i class="fas fa-info-circle"></i> Detalle remito: <?php echo e($r->codigo); ?></a>
</li>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid" oncontextmenu="return false"><!-- ONCONTEXTMENU DESACTIVA F12-->
	<div class="panel shadow">
		<div class="header">
			<h2 class="title"><i class="fas fa-info-circle"></i> Detalle</h2>
		</div>
		<div class="inside">
			<div class="card text-center">

			  <div class="card-header">
			    <div>
					<b>CODIGO REMITO:</b>
					<a><?php echo e($r->codigo); ?></a>
				</div>
			  </div>

			  <div class="card-body">
			  	<div style="text-align: right">
				<?php if(kvfj(Auth::user()->permisos, 'detalle_remito_pdf')): ?>
					<a href="<?php echo e(url('admin/remitos/'.$r->id.'/detalle/remito_pdf')); ?>" data-toggle="tooltip" data-placement="top" title="Generar PDF" class="btn btn-danger btn-sm" target="_blank">
						<i class="far fa-file-pdf"></i>
						PDF
					</a>
				<?php endif; ?>
				</div>

			    <h5 class="card-title">
			    	<div>
						<b>CORRESPONDE A ORDEN DE COMPRA:</b>
						<a> <?php echo e($r->orden->codigo); ?> </a> 
					</div>
				</h5>

			    <p class="card-text">		
			    	<div>
						<b>PROVEEDOR:</b>
						<a><?php echo e($r->provs->name); ?></a>
					</div>    	
			    	<div>
						<b>RESPONSABLE:</b>
						<a><?php echo e($r->user->name.' '.$r->user->lastname); ?></a>
					</div>			

					<div>
						<b>FECHA:</b>
						<a><?php echo e($r->created_at->format('d/m/Y')); ?></a>
					</div>

					<div>
						<b>DESCRIPCIÓN:</b>
						<a><?php echo e($r->descripcion); ?></a>
					</div>					
			    </p>			    
			  </div>
			  
			  <div class="card-footer text-muted p-0">
			    <table class="table m-0">
	                <thead class="table-dark">                	
	                    <tr>
		                    <td>PRODUCTO</td>
		                    <td>CANTIDAD</td>
		                    <td>PRECIO UNITARIO</td>
		                    <td>IMPORTE</td>
	                    </tr>
	                </thead>
	                <tbody>
	                	<?php $__currentLoopData = $r->detalle; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dd): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	                	<tr>	                		
	                		<td> <?php echo e($dd->prods[0]->name); ?></td>	                		
	                		<td> <?php echo e($dd->cantidad_req); ?> </td>
	                		<td> $<?php echo e($dd->precio); ?> </td>
	                		<td> $<?php echo e(number_format($dd->cantidad_req * $dd->precio, 2)); ?> </td>
	                		<td hidden="true"><?php echo e($acum += ($dd->cantidad_req * $dd->precio)); ?></td>
	                	</tr>
	                	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	                </tbody>
	                <tfoot class="table-danger">
	            		<td>Total:</td>
	            		<td colspan="2"></td>					
						<td class="table-active"><b>$<?php echo e(number_format($acum,2)); ?></b></td>
	           		</tfoot>
	            </table>
			  </div>
			</div>			
		</div>
	</div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH G:\www\cms\resources\views/admin/remitos/detalle.blade.php ENDPATH**/ ?>