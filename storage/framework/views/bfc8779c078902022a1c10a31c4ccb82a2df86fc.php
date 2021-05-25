

<?php $__env->startSection('title','Editar Orden de Compra'); ?>


<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item">
	<a href="<?php echo e(url('/admin/ordenescompra/all')); ?>"><i class="fas fa-cart-plus"></i> Ordenes de Compra</a>
</li>
<li class="breadcrumb-item">
	<a href="<?php echo e(url('/admin/ordenescompra/'.$oc->id.'/detalle')); ?>"><i class="fas fa-info-circle"></i> Detalle Orden de Compra: <?php echo e($oc->codigo); ?></a>
</li>
<li class="breadcrumb-item">
	<a href="<?php echo e(url('/admin/ordenescompra/'.$oc->id.'/edit')); ?>"><i class="fas fa-edit"></i> Editar Orden de Compra</a>
</li>
<?php $__env->stopSection(); ?>
 

<?php $__env->startSection('content'); ?>

<div class="container-fluid">
	<div class="panel shadow">
		<div class="header">
			<h2 class="title"><i class="fas fa-edit"></i> Editar Orden de Compra</h2>
		</div>
		<div class="inside">
			<?php echo Form::open(['url' => '/admin/ordenescompra/'.$oc->id.'/edit','files'=>true,'id'=>'formulario']); ?>	
				<div class="row">
					
					<div class="col-md-4">
							<label for="codigo">Código:</label>
								<div class="input-group">									
							   		<span class="input-group-text" id="basic-addon1">
							   			<i class="fas fa-barcode"></i>
							   		</span>								    
						    	<?php echo Form::text('codigo', $oc->codigo, ['class' => 'form-control', 'id' => 'orden_id', 'disabled'] ); ?>

						    	</div>
					</div>
					<div class="col-md-4">
							<label for="proveedor">Proveedor:</label>
								<div class="input-group">									
								   		<span class="input-group-text" id="basic-addon1">
								   			<i class="fas fa-hand-paper"></i>
								   		</span>								   
							    	<?php echo Form::select('proveedor', $provs ,$oc->proveedor_id,  ['class' =>'form-select', 'disabled']); ?>	
								</div>
					</div>
					<div class="col-md-4">
							<label for="status">Estado:</label>
								<div class="input-group">									
								   		<span class="input-group-text" id="basic-addon1">
								   			<i class="fas fa-hand-paper"></i>
								   		</span>					
								   	
							    	<?php echo Form::select('status', ['0'=>'Pendiente',/*'1'=>'Aprobada',*/ '1'=>'Completada', '2'=>'Rechazada'], $oc->status, ['class' =>'form-select']); ?>	
							    	
								</div>
					</div>
				</div>	
				<div class="row mtop16">
					<div class="col-md-12">
						<label for="descripcion">Descripción:</label>
						<div class="input-group">
						 	<textarea class="form-control" name="descripcion" rows="3" id="descripcion"><?php echo e($oc->descripcion); ?></textarea>
					    </div>
					</div>
				</div>

				<div class="panel shadow">
					<div class="header mtop16">
						<h2 class="title">Editar Detalle</h2>
					</div>
					<div class="inside">						
						<div class="row">
							<div class="col-md-5">
								<label for="producto">Producto:</label>
									<div class="input-group">								
									   		<span class="input-group-text">
									   			<i class="fas fa-boxes"></i>
									   		</span>							   
								  	 <?php echo Form::select('producto', $prods, 0, ['class' =>'form-select','id' => 'producto','placeholder'=>'Seleccione un item'] ); ?>

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
							<div class="col-md-3">
								<label for="precio">Precio unitario:</label>
									<div class="input-group">									
								   		<span class="input-group-text">
								   			<i class="fas fa-dollar-sign"></i>
								   		</span>								    
							    		<input type="number" class="form-control" min="1" name="precio" id="precio">
							    	</div>
							</div>
							<div class="col-md-1">	
								<button style="border-radius: 20px" id="agregar" class="btn btn-warning mtop16 shadow" data-toggle="tooltip" data-placement="top" title="Agregar">
									<i class="fas fa-plus"></i>
								</button>
							</div>	
						</div>
						<hr>
						<table class="table table-bordered mtop16" id="tablaEditarOCompra">
							<thead class="table-secondary">
								<tr>
									<td>Producto</td>
									<td style="text-align: right;">Cantidad</td>
									<td style="text-align: right;">Precio unitario ($)</td>
									<td style="text-align: right;">Importe ($)</td>
									<td width="100"></td>
								</tr>
							</thead>
							<tbody>
							</tbody>
							<caption>
								<h5>								
								</h5>
							</caption>
						<?php echo Form::text('productos', $oc ,['class' => 'form-control', 'id'=>'productos', 'hidden'] ); ?>

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


<?php echo $__env->make('admin.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH G:\www\cms\resources\views/admin/ordenescompra/edit.blade.php ENDPATH**/ ?>