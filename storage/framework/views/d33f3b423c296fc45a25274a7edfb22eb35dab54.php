

<?php $__env->startSection('title','Agregar entrada'); ?>


<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item">
	<a href="<?php echo e(url('/admin/entradas')); ?>"><i class="far fa-plus-square"></i> Registrar entrada</a>
</li>
<li class="breadcrumb-item">
	<a href="<?php echo e(url('/admin/entradas/agregar')); ?>"><i class="fas fa-plus-circle"></i> Agregar entrada</a>
</li>
<?php $__env->stopSection(); ?>
 

<?php $__env->startSection('content'); ?>

<div class="container-fluid">
	<div class="panel shadow">
		<div class="header">
			<h2 class="title"><i class="fas fa-plus-circle"></i> Agregar entrada</h2>
		</div>
		<div class="inside">
			
				<div class="row">
					
					<div class="col-md-4">
							<label for="proveedor">Proveedor:</label>
							<div class="input-group">								
							   		<span class="input-group-text" id="basic-addon1">
							   			<i class="fas fa-truck"></i>
							   		</span>							   
						    	<?php echo Form::select('proveedor', $provs, 0, ['class' =>'form-select']); ?>

						    </div>
					</div>
					<div class="col-md-4">
							<label for="codigo">Código:</label>
								<div class="input-group">									
							   		<span class="input-group-text" id="basic-addon1">
							   			<i class="fas fa-barcode"></i>
							   		</span>								    
						    	<?php echo Form::text('codigo', 0, ['class' => 'form-control'] ); ?>

						    	</div>
					</div>

					<div class="col-md-4">
							<label for="status">Estado:</label>
								<div class="input-group">									
								   		<span class="input-group-text" id="basic-addon1">
								   			<i class="fas fa-hand-paper"></i>
								   		</span>								   
							    	<?php echo Form::select('status', ['0'=>'Pendiente','1'=>'Aprobado'],0, ['class' =>'form-select']); ?>							    		
								</div>
					</div>
					
				</div>
				
				<div class="panel-shadow">
					<div class="header mtop16">
						<h2 class="title">Agregar producto</h2>
					</div>
					<div class="inside">
						<div class="row">
							<div class="col-md-4">
								<label for="producto">Producto/s:</label>
									<div class="input-group">								
									   		<span class="input-group-text">
									   			<i class="fas fa-boxes"></i>
									   		</span>							   
								    	
								    	<select class="form-select" name="producto" id="producto" >
								    		<?php $__currentLoopData = $prods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								    			<option value="<?php echo e($p); ?>"><?php echo e($p); ?></option>
								    		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								    	</select>
								    </div>
							</div>
							<div class="col-md-3">
								<label for="cantidad">Cantidad:</label>
									<div class="input-group">									
								   		<span class="input-group-text">
								   			<i class="fas fa-plus"></i>
								   		</span>								    
								   		<input type="number" class="form-control" name="cantidad" id="cantidad" required="true">
							    	</div>
							</div>
							<div class="col-md-3">
								<label for="precio">Precio:</label>
									<div class="input-group">									
								   		<span class="input-group-text">
								   			<i class="fas fa-dollar-sign"></i>
								   		</span>								    
							    		<input type="number" class="form-control" name="precio" id="precio" required="true">
							    	</div>
							</div>
							<div class="col-md-2">	
								<button id="agregar" class="btn btn-secondary mtop16">
									Agregar
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
					</div>
					
				</div>	
		
			<div class="row">
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
<?php echo $__env->make('admin.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH G:\www\cms\resources\views/admin/entradas/agregar.blade.php ENDPATH**/ ?>