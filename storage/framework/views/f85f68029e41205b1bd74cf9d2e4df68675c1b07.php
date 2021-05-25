

<?php $__env->startSection('title','Nuevo remito'); ?>


<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item">
	<a href="<?php echo e(url('/admin/compras/all')); ?>"><i class="fas fas fa-file-invoice-dollar"></i> Remitos</a>
</li>
<li class="breadcrumb-item">
	<a href="<?php echo e(url('/admin/compras/agregar')); ?>"><i class="fas fa-plus-circle"></i> Nuevo remito</a>
</li>
<?php $__env->stopSection(); ?>
 

<?php $__env->startSection('content'); ?>

<div class="container-fluid" oncontextmenu="return false"><!-- ONCONTEXTMENU DESACTIVA F12-->
	<div class="panel shadow">
		<div class="header">
			<h2 class="title"><i class="fas fa-plus-circle"></i> Nuevo remito</h2>
		</div>
		<div class="inside">
			<?php echo Form::open(['url' => '/admin/compras/agregar','files'=>true,'id'=>'formulario']); ?>	
				<div class="row">
					<div class="col-md-4">
							<label for="orden_id">Corresponde a Orden de Compra:</label>
							<div class="input-group">								
							   		<span class="input-group-text" id="basic-addon1">
							   			<i class="fas fa-hashtag"></i>
							   		</span>							   
						    	<?php echo Form::select('orden_id', $orden, null, ['class' =>'form-select']); ?>

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
										
					<div class="col-md-12">
						<label for="descripcion" class="mtop16">Descripción:</label>
						<div class="input-group">
						 	<textarea class="form-control" name="descripcion" rows="3" id="descripcion"></textarea>
					    </div>
					</div>
				</div>
				<hr>
				<div class="panel shadow">
					<div class="header mtop16">
						<h2 class="title">Agregar producto</h2>
					</div>
					<div class="inside">						
						<div class="row">
							<div class="col-md-4">
								<label for="producto">Producto:</label>
									<div class="input-group">								
									   		<span class="input-group-text">
									   			<i class="fas fa-boxes"></i>
									   		</span>							   
								  	 <?php echo Form::select('producto', $prods, 0, ['class' =>'form-select','id' => 'producto'] ); ?>

								  	 </select>
								    </div>
							</div>
							<div class="col-md-3">
								<label for="cantidad">Cantidad:</label>
									<div class="input-group">									
								   		<span class="input-group-text">
								   			<i class="fas fa-plus"></i>
								   		</span>	
								   		<input type="number" class="form-control" min="1" name="cantidad" id="cantidad" required="true"> 
							    	</div>
							</div>
							<div class="col-md-3">
								<label for="precio">Precio unitario:</label>
									<div class="input-group">									
								   		<span class="input-group-text">
								   			<i class="fas fa-dollar-sign"></i>
								   		</span>								    
							    		<input type="number" class="form-control" min="1" name="precio" id="precio" required="true">
							    	</div>
							</div>
							<div class="col-md-2">	
								<button style="border-radius: 20px" id="agregar" class="btn btn-warning mtop16 shadow" data-toggle="tooltip" data-placement="top" title="Agregar">
									<i class="fas fa-plus"></i>
								</button>
							</div>	
						</div>
						<hr>
						<table class="table table-bordered mtop16">
							<thead class="table-secondary">
								<tr>
									<td>Producto</td>
									<td>Cantidad</td>
									<td>Precio unitario ($)</td>
									<td>Importe ($)</td>
									<td width="100"></td>
								</tr>
							</thead>
							<tbody>
							</tbody>
							<caption>
								<h6>								
								</h6>
							</caption>
						<?php echo Form::text('productos', 0 ,['class' => 'form-control', 'id'=>'productos', 'hidden'] ); ?>

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


<?php echo $__env->make('admin.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH G:\www\cms\resources\views/admin/compras/agregar.blade.php ENDPATH**/ ?>