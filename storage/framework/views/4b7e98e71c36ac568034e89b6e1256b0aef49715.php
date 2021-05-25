

<?php $__env->startSection('title','Nuevo remito'); ?>


<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item">
	<a href="<?php echo e(url('/admin/remitos/all')); ?>"><i class="fas fas fa-file-invoice-dollar"></i> Remitos</a>
</li>
<li class="breadcrumb-item">
	<a href="<?php echo e(url('/admin/remitos/agregar')); ?>"><i class="fas fa-plus-circle"></i> Nuevo remito</a>
</li>
<?php $__env->stopSection(); ?>
 

<?php $__env->startSection('content'); ?>

<div class="container-fluid" oncontextmenu="return false"><!-- ONCONTEXTMENU DESACTIVA F12-->
	<div class="panel shadow">
		<div class="header">
			<h2 class="title"><i class="fas fa-plus-circle"></i> Nuevo remito</h2>
		</div>
		<div class="inside">
			<?php echo Form::open(['url' => '/admin/remitos/agregar','files'=>true,'id'=>'formulario']); ?>	
				<div class="row">
					<div class="col-md-6">
							<label for="orden_id">Corresponde a Orden de Compra:</label>
							<div class="input-group">								
							   		<span class="input-group-text" id="basic-addon1">
							   			<i class="fas fa-hashtag"></i>
							   		</span>							   
						    	<?php echo Form::select('orden_id', $code, null, ['class' =>'form-select', 'id'=>'orden_id', 'placeholder'=>'Seleccione una ODC']); ?>

						    </div>
					</div>
					
					<div class="col-md-6">
							<label for="proveedor">Proveedor:</label>
							<div class="input-group">								
							   		<span class="input-group-text" id="basic-addon1">
							   			<i class="fas fa-truck"></i>
							   		</span>							   
						    	<?php echo Form::select('proveedor', $provs, null, ['class' =>'form-select', 'id'=>'prov_id']); ?>

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
							    		<input type="number" class="form-control" min="1" name="precio" id="precio" step="any">
							    	</div>
							</div>
							<div class="col-md-1">	
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


<?php echo $__env->make('admin.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH G:\www\cms\resources\views/admin/remitos/agregar.blade.php ENDPATH**/ ?>