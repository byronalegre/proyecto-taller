

<?php $__env->startSection('title','Detalle pieza'); ?>

<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item">
	<a href="<?php echo e(url('/admin/piezas/1')); ?>"><i class="fas fa-cog"></i> Piezas</a>
</li>
<li class="breadcrumb-item">
	<a href="<?php echo e(url('/admin/piezas/'.$p->id.'/detalle')); ?>"><i class="fas fa-info-circle"></i> Detalle pieza</a>
</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">
	<div class="panel shadow">
		<div class="header">
			<h2 class="title"><i class="fas fa-info-circle"></i> Detalle pieza</h2>
		</div>
		<div class="inside">		

		  <div class="card">			  	
			  <div class="row m-2">
			    <div class="col-md-4 m-auto">
			    	<img src="<?php echo e(url('/uploads/'.$p->file_path.'/'.$p->image)); ?>" class="img-fluid w-80">
			    </div>

			    <div class="col-md-8">

			      <div class="card-body">

			      	<div style="text-align: right;">
			      		<?php if(kvfj(Auth::user()->permisos, 'piezas_editar')): ?>
							<?php if(is_null($p->deleted_at)): ?>
								<a class="btn btn-primary btn-sm" href="<?php echo e(url('admin/piezas/'.$p->id.'/edit')); ?>" data-toggle="tooltip" data-placement="top" title="Editar">
								<i class="fas fa-edit"></i>
								</a>
							<?php endif; ?>
						<?php endif; ?>						
		       			<?php if(kvfj(Auth::user()->permisos, 'historia')): ?>
							<a  class="btn btn-sm btn-secondary text-white" href="<?php echo e(url('admin/piezas/'.$p->id.'/detalle/historia_cambio')); ?>"data-toggle="tooltip" data-placement="top" title="Historial de cambios">
								<i class="fas fa-history"></i>
							</a>
						<?php endif; ?>
						<?php if(kvfj(Auth::user()->permisos, 'historia_precio')): ?>
							<a class="btn btn-sm text-white" href="<?php echo e(url('admin/piezas/'.$p->id.'/detalle/historia_precio')); ?>" data-toggle="tooltip" data-placement="top" title="Historial de precios" style="background-color: #239B56">
								<i class="fas fa-dollar-sign"></i>
							</a>
						<?php endif; ?>
			      	</div>			      	

			        <h5 class="card-title"><?php echo e($p->name); ?></h5>

			        <p class="card-text">

			        	<table class="table">

			        		<tr>
			        			<td><strong>ID</strong></td>
			        			<td> <?php echo e($p->id); ?> </td>
			        		</tr>
			        		<tr>
			        			<td><strong>Código</strong></td>
			        			<td> <?php echo e($p->codigo); ?> </td>
			        		</tr>
			        		<tr>
			        			<td><strong>Estado</strong></td>
			        			<td> 
			        				<?php if($p->status == 0): ?>
			        					Inactiva
			        				<?php endif; ?>
			        				<?php if($p->status == 1): ?>
			        					Activa
			        				<?php endif; ?>
			        			</td>
			        		</tr>
			        		<tr>
			        			<td><strong>Categoría</strong></td>
			        			<td> <?php echo e($p->cat->name); ?> </td>
			        		</tr>
			        		<tr>
			        			<td><strong>Cantidad mínima</strong></td>
			        			<td> <?php echo e($p->cantidad_min); ?> </td>
			        		</tr>
			        		<tr>
			        			<td><strong>Cantidad</strong></td>
			        			<td> <?php echo e($p->cantidad); ?> </td>
			        		</tr>
			        		<tr>
			        			<td><strong>Marca</strong></td>
			        			<td> <?php echo e($p->mark->name); ?> </td>
			        		</tr>
			        		<tr>
			        			<td><strong>Depósito</strong></td>
			        			<td> <?php echo e($p->deposito); ?> </td>
			        		</tr>
			        	</table>
			        </p>
			        <p class="card-text">
			        	<?php echo Form::textarea('content', $p->content, ['class' => 'form-control', 'id' => 'editor', 'readonly', 'rows'=>3] ); ?>

			        </p>
			      </div>
			    </div>
			  </div>
			</div>
		</div>
	</div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH G:\www\cms\resources\views/admin/piezas/detalle.blade.php ENDPATH**/ ?>