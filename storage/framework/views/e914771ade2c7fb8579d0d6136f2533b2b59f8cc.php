

<?php $__env->startSection('title','Nueva Orden'); ?>


<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item">
	<a href="<?php echo e(url('/admin/ordenescompra/all')); ?>"><i class="fas fas fa-cart-plus"></i> Ordenes de Compra</a>
</li>
<li class="breadcrumb-item">
	<a href="<?php echo e(url('/admin/ordenescompra/agregar')); ?>"><i class="fas fa-plus-circle"></i> Nueva Orden</a>
</li>
<?php $__env->stopSection(); ?>
 

<?php $__env->startSection('content'); ?>

<div class="container-fluid"><!-- ONCONTEXTMENU DESACTIVA F12-->
	<div class="panel shadow">
		<div class="header">
			<h2 class="title"><i class="fas fa-plus-circle"></i> Nueva Orden</h2>
		</div>
		<div class="inside">
			<?php echo Form::open(['url' => '/admin/ordenescompra/agregar','files'=>true,'id'=>'formulario']); ?>	
				<div class="row">

					<div class="col-md-4">
							<label for="orden_id">Corresponde a Orden de Pedido:</label>
							<div class="input-group">								
							   		<span class="input-group-text" id="basic-addon1">
							   			<i class="fas fa-hashtag"></i>
							   		</span>							   
						    	<?php echo Form::select('orden_id', $code, null, ['class' =>'form-select', 'id'=>'orden_id', 'placeholder'=>'Seleccione una ODP']); ?>

						    </div>
					</div>
					
					<div class="col-md-4">
							<label for="proveedor">Proveedor:</label>
							<div class="input-group">								
							   		<span class="input-group-text" id="basic-addon1">
							   			<i class="fas fa-truck"></i>
							   		</span>							   
						    	<?php echo Form::select('proveedor', $provs, null, ['class' =>'form-select']); ?>

						    </div>
					</div>

					<div class="col-md-4">
							<label for="status">Estado:</label>
								<div class="input-group">									
								   		<span class="input-group-text" id="basic-addon1">
								   			<i class="fas fa-hand-paper"></i>
								   		</span>								   
							    	<?php echo Form::select('status', ['0'=>'Pendiente'/*, '1'=>'Aprobada'*/, '1'=>'Completada'], 0, ['class' =>'form-select']); ?>	
								</div>
					</div>
					<div class="col-md-12">
						<label for="descripcion" class="mtop16">Descripción:</label>
						<div class="input-group">
						 	<textarea class="form-control" name="descripcion" rows="3" id="descripcion"></textarea>
					    </div>
					</div>
					
				</div>

				<div class="row mtop16" style="justify-content: center;">
					<div class="col-md-6">
						<div class="card border-warning border-3" id="card" style="display: none;">
							<div class="card-header">Detalle ODP</div>						
							<div class="card-body p-0">
								<table class="table mb-0" id="tablaODC" style="text-align: center;">
									<thead class="bg-light">
										<td>Producto</td>
										<td>Cantidad solicitada</td>
										<td width="100">Incluido</td>
									</thead>
									<tbody>
										
									</tbody>
								</table>	
							</div>						
						</div>						
					</div>					
				</div>			

				
				<hr>
				<div class="panel shadow">
					<div class="header">
						<h2 class="title">Agregar producto</h2>
					</div>
					<div class="inside">						
						<div class="row">
							<div class="col-md-5">
								<label for="producto">Producto:</label>
									<div class="input-group">								
									   		<span class="input-group-text">
									   			<i class="fas fa-boxes"></i>
									   		</span>							   
								  	 <?php echo Form::select('producto', $prods, null, ['class' =>'form-select','id' => 'producto', 'placeholder'=>'Seleccione un item'] ); ?>

								  	 </select>
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

						<table class="table table-bordered mtop16" id="tablaCompra">
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
						<?php echo Form::text('productos', $orden ,['class' => 'form-control', 'id'=>'productos', 'hidden'] ); ?>

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


<?php echo $__env->make('admin.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH G:\www\cms\resources\views/admin/ordenescompra/agregar.blade.php ENDPATH**/ ?>