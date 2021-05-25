

<?php $__env->startSection('title','Editar Orden de Pedido'); ?>


<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item">
	<a href="<?php echo e(url('/admin/ordenespedido/all')); ?>"><i class="fas fa-file-invoice"></i> Ordenes de Pedido</a>
</li>
<li class="breadcrumb-item">
	<a href="<?php echo e(url('/admin/ordenespedido/'.$op->id.'/detalle')); ?>"><i class="fas fa-info-circle"></i> Detalle Orden de Pedido: <?php echo e($op->codigo); ?></a>
</li>
<li class="breadcrumb-item">
	<a href="<?php echo e(url('/admin/ordenespedido/'.$op->id.'/edit')); ?>"><i class="fas fa-edit"></i> Editar Orden de Pedido</a>
</li>
<?php $__env->stopSection(); ?>
 

<?php $__env->startSection('content'); ?>

<div class="container-fluid">
	<div class="panel shadow">
		<div class="header">
			<h2 class="title"><i class="fas fa-edit"></i> Editar Orden de Pedido</h2>
		</div>
		<div class="inside">
			<?php echo Form::open(['url' => '/admin/ordenespedido/'.$op->id.'/edit','files'=>true,'id'=>'formulario']); ?>	
				<div class="row">					
					<div class="col-md-6">
							<label for="codigo">Código:</label>
								<div class="input-group">									
							   		<span class="input-group-text" id="basic-addon1">
							   			<i class="fas fa-barcode"></i>
							   		</span>								    
						    	<?php echo Form::text('codigo', $op->codigo, ['class' => 'form-control', 'id' => 'orden_id', 'disabled'] ); ?>

						    	</div>
					</div>

					<div class="col-md-6">
							<label for="status">Estado:</label>
								<div class="input-group">									
								   		<span class="input-group-text" id="basic-addon1">
								   			<i class="fas fa-hand-paper"></i>
								   		</span>								   
							    	<?php echo Form::select('status', ['0'=>'Pendiente','1'=>'Completada', '2'=>'Rechazada'], $op->status, ['class' =>'form-select']); ?>	
								</div>
					</div>
				</div>	

				<div class="row mtop16">
					<div class="col-md-12">
						<label for="descripcion">Descripción:</label>
						<div class="input-group">
						 	<textarea class="form-control" name="descripcion" rows="3" id="descripcion"><?php echo e($op->descripcion); ?></textarea>
					    </div>
					</div>
				</div>

				<div class="panel shadow">
					<div class="header mtop16">
						<h2 class="title">Editar Detalle</h2>
					</div>
					<div class="inside">						
						<div class="row">
							<div class="col-md-7">
								<label for="producto">Producto:</label>
									<div class="input-group">								
									   		<span class="input-group-text">
									   			<i class="fas fa-boxes"></i>
									   		</span>							   
								  	 <?php echo Form::select('producto', $prods->pluck('name','id'), null, ['class' =>'form-select','id' => 'producto','placeholder'=>'Seleccione un item'] ); ?>

								    </div>
							</div>
							<div class="col-md-3">
								<label for="cantidad">Cantidad:</label>
									<div class="input-group">									
								   		<span class="input-group-text">
								   			<i class="fas fa-plus"></i>
								   		</span>	
								   		<input type="number" class="form-control" min="1" name="cantidad" id="cantidad"> 
							    	</div>
							</div>

							<div class="col-md-1">	
								<button style="border-radius: 20px" id="agregar_item" class="btn btn-warning mtop16 shadow" data-toggle="tooltip" data-placement="top" title="Agregar">
									<i class="fas fa-plus"></i>
								</button>
							</div>	
							<?php if(kvfj(Auth::user()->permisos, 'piezas')): ?>
							<div class="col-md-1">	
								<button type="button" class="btn btn-primary mtop16" data-bs-toggle="modal" data-bs-target="#exampleModal">
								  <i class="fas fa-bars" data-toggle="tooltip" title="Ver listado de piezas"></i>
								</button>

								<!-- Modal -->
								<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
								  <div class="modal-dialog">
								    <div class="modal-content">
								      <div class="modal-header bg-dark text-white">
								        <h5 class="modal-title" id="exampleModalLabel">Listado de piezas y cantidades</h5>
								        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
								      </div>
								      <div class="modal-body p-0">
								        <table class="table table-bordered table-hover mb-0" width="100%">
								        	<tbody>
								        		<thead class="table-secondary">
								        			<tr>
								        				<td>Nombre</td>
								        				<td style="text-align: right;">Cantidad Minima</td>
								        				<td style="text-align: right;">Cantidad</td>
								        			</tr>
								        		</thead>
								        		<?php $__currentLoopData = $prods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>	
									        		<?php if(($a->cantidad_min > $a->cantidad)&&($a->cantidad != 0)): ?>								        		
										        		<tr class="table-warning">								        			
										        			<td><?php echo e($a->name); ?></td>
										        			<td style="text-align: right;"><?php echo e($a->cantidad_min); ?></td>
										        			<td style="text-align: right;"><?php echo e($a->cantidad); ?></td>
										        		</tr>
									        		<?php endif; ?>
									        		<?php if($a->cantidad == 0): ?>							        		
										        		<tr class="table-danger">								        			
										        			<td><?php echo e($a->name); ?></td>
										        			<td style="text-align: right;"><?php echo e($a->cantidad_min); ?></td>
										        			<td style="text-align: right;"><?php echo e($a->cantidad); ?></td>
										        		</tr>
									        		<?php endif; ?>
									        		<?php if($a->cantidad_min <= $a->cantidad): ?>
									        			<tr>								        			
										        			<td><?php echo e($a->name); ?></td>
										        			<td style="text-align: right;"><?php echo e($a->cantidad_min); ?></td>
										        			<td style="text-align: right;"><?php echo e($a->cantidad); ?></td>
										        		</tr>
										        	<?php endif; ?>
								        		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								        	</tbody>

								        	<caption class="text-warning mx-2 p-0" style="text-align: right;">Bajo Stock <button disabled="true" class="btn btn-warning"></button></caption>
								        	<caption class="text-danger mx-2 p-0" style="text-align: right;">Sin Stock <button disabled="true" class="btn btn-danger"></button></caption>
								        </table>
								      </div>
								      <div class="modal-footer">
								        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
								      </div>
								    </div>
								  </div>
								</div>
							</div>
							<?php endif; ?>
						</div>
						<hr>
						<table class="table table-bordered mtop16" id="tabla">
							<thead class="table-secondary">
								<tr>
									<td>Producto</td>
									<td>Cantidad</td>
									<td width="100"></td>
								</tr>
							</thead>
							<tbody>
							</tbody>
						<?php echo Form::text('productos', $op ,['class' => 'form-control', 'id'=>'productos', 'hidden'] ); ?>

						</table>						
					</div>				
				</div>										 
				
				<div class="row mtop16">
					<div class="col-md-12">
						<?php echo Form::submit('Guardar', ['class' => 'btn btn-success']); ?>

					</div>
				</div>
		</div>
			
		<?php echo Form::close(); ?>

		</div>
	</div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH G:\www\cms\resources\views/admin/ordenespedido/edit.blade.php ENDPATH**/ ?>