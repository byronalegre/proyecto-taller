

<?php $__env->startSection('title','Agregar items'); ?>


<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item">
	<a href="<?php echo e(url('/admin/compras')); ?>"><i class="fas fa-cart-plus"></i> Compras</a>
</li>
<li class="breadcrumb-item">
	<a href="<?php echo e(url('/admin/compras/agregar')); ?>"><i class="fas fa-plus-circle"></i> Agregar compra</a>
</li>
<li class="breadcrumb-item">
	<a href="<?php echo e(url('/admin/compras/agregar')); ?>"><i class="fas fa-plus-circle"></i> Agregar items</a>
</li>
<?php $__env->stopSection(); ?>
 

<?php $__env->startSection('content'); ?>

<div class="container-fluid">
	<div class="panel shadow">
		<div class="header">
			<h2 class="title"><i class="fas fa-plus-circle"></i> Agregar compra</h2>
		</div>
		<div class="inside">
				
				<div class="row">
					<div class="col-md-4">
							<label for="proveedor">Proveedor:</label>
							<div class="input-group">								
							   		<span class="input-group-text" id="basic-addon1">
							   			<i class="fas fa-truck"></i>
							   		</span>							   
						    	<?php echo Form::text('proveedor', $c->proveedor_id, ['class' =>'form-select','disabled']); ?>

						    </div>
					</div>
					<div class="col-md-4">
							<label for="codigo">Código:</label>
								<div class="input-group">									
							   		<span class="input-group-text" id="basic-addon1">
							   			<i class="fas fa-barcode"></i>
							   		</span>								    
						    	<?php echo Form::text('codigo', $c->codigo, ['class' => 'form-control','disabled'] ); ?>

						    	</div>
					</div>

					<div class="col-md-4">
							<label for="status">Estado:</label>
								<div class="input-group">									
								   		<span class="input-group-text" id="basic-addon1">
								   			<i class="fas fa-hand-paper"></i>
								   		</span>								   
							    	<?php echo Form::text('status', $c->status, ['class' =>'form-select','disabled']); ?>	
								</div>
					</div>
					
				</div>
				
				 <div class="panel shadow">
					<div class="header mtop16">
						<h2 class="title">Agregar producto</h2>
					</div>
					<div class="inside">
						<?php echo Form::open(['url' => '/admin/compras/agregar/'.$c->id,'files'=>true]); ?>

						<div class="row">
							<div class="col-md-4">
								<label for="producto">Producto:</label>
									<div class="input-group">								
									   		<span class="input-group-text">
									   			<i class="fas fa-boxes"></i>
									   		</span>							   
								  	  <?php echo Form::select('producto', $prods ,0, ['class' =>'form-select' , 'id'=>'producto']); ?>

								    </div>
							</div>
							<div class="col-md-3">
								<label for="cantidad">Cantidad:</label>
									<div class="input-group">									
								   		<span class="input-group-text">
								   			<i class="fas fa-plus"></i>
								   		</span>	
								   		<?php echo Form::number('cantidad', 0, ['class' => 'form-control', 'id'=> 'cantidad', 'min' => '0'] ); ?>

							    	</div>
							</div>
							<div class="col-md-3">
								<label for="precio">Precio:</label>
									<div class="input-group">									
								   		<span class="input-group-text">
								   			<i class="fas fa-dollar-sign"></i>
								   		</span>								    
							    		<?php echo Form::number('precio', 0, ['class' => 'form-control', 'id'=> 'precio', 'min' => '0'] ); ?>

							    	</div>
							</div>
							<div class="col-md-2">	
								<button style="border-radius: 20px" id="agregar" class="btn btn-warning mtop16 shadow" data-toggle="tooltip" data-placement="top" title="Agregar">
									<i class="fas fa-plus"></i>
								</button>
							</div>	
						</div>
						<table class="table table-bordered mtop16">
							<thead class="table-secondary">
								<tr>
									<td>Producto</td>
									<td>Cantidad</td>
									<td>Precio</td>
									<td width="100"></td>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
						<b>Total: $</b><b id="acumulado"></b>
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
<?php echo $__env->make('admin.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH G:\www\cms\resources\views/admin/compras/agregarItems.blade.php ENDPATH**/ ?>