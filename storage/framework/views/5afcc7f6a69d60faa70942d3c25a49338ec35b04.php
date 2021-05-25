

<?php $__env->startSection('title','Agregar pieza'); ?>


<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item">
	<a href="<?php echo e(url('/admin/piezas/1')); ?>"><i class="fas fa-cog"></i> Piezas</a>
</li>
<li class="breadcrumb-item">
	<a href="<?php echo e(url('/admin/piezas/agregar')); ?>"><i class="fas fa-plus-circle"></i> Agregar pieza</a>
</li>
<?php $__env->stopSection(); ?>
 

 <?php $__env->startSection('content'); ?>

<div class="container-fluid">
	<div class="panel shadow">
		<div class="header">
			<h2 class="title"><i class="fas fa-plus-circle"></i> Agregar pieza</h2>
		</div>
		<div class="inside">
			<?php echo Form::open(['url' => '/admin/piezas/agregar','files'=>true]); ?> 
			
				<div class="row">
					<div class="col-md-6">
						<label for="title">Nombre de pieza:</label>
						<div class="input-group">							
						   	<span class="input-group-text" id="basic-addon1">
						   		<i class="fas fa-keyboard"></i>
						   	</span>						    
					    	<?php echo Form::text('name', null, ['class' => 'form-control']); ?>

					    </div>
					</div>
					
					<div class="col-md-6">
						<label for="img">Imagen:</label>
						<div class="input-group">
							<?php echo Form::file('img', ['class' => 'form-control', 'id'=>'formFile', 'accept'=> 'image/*']); ?>

							<label class="input-group-text" for="formFile"><i class="fas fa-image"></i></label>
						</div>
					</div>	
				</div>

				<div class="row mtop16">
					<div class="col-md-4">
						<label for="status">Estado:</label>
						<div class="input-group">									
						   		<span class="input-group-text" id="basic-addon1">
						   			<i class="fas fa-eye"></i>
						   		</span>								   
					    	<?php echo Form::select('status', ['0'=>'Inactivo','1'=>'Activo'], 1 , ['class' =>'form-select']); ?>							    		
						</div>
					</div>

					<div class="col-md-4">
						<label for="cantidad-min">Cantidad mínima:</label>
						<div class="input-group">									
						   		<span class="input-group-text" id="basic-addon1">
						   			<i class="fas fa-exclamation-triangle"></i>
						   		</span>								    
				    	<?php echo Form::number('cantidad-min', 0, ['class' => 'form-control', 'min' => '0'] ); ?>

				    	</div>
					</div>
					
					<div class="col-md-4">
						<label for="cantidad">Cantidad:</label>
						<div class="input-group">									
						   		<span class="input-group-text" id="basic-addon1">
						   			<i class="fas fa-boxes"></i>
						   		</span>								    
				    	<?php echo Form::number('cantidad', 0, ['class' => 'form-control', 'min' => '0'] ); ?>

				    	</div>
					</div>
				</div>

				<div class="row mtop16">
					<div class="col-md-4">
						<label for="title">Marca:</label>
						<div class="input-group">								
						   		<span class="input-group-text" id="basic-addon1">
						   			<i class="far fa-copyright"></i>
						   		</span>							   
					    	<?php echo Form::select('marca', $marca, 0, ['class' =>'form-select']); ?>

					    </div>
					</div>	

					<div class="col-md-4">
						<label for="categoria">Categoría:</label>
						<div class="input-group">							
						   		<span class="input-group-text" id="basic-addon1">
						   			<i class="fas fa-tag"></i>
						   		</span>						    
					    	<?php echo Form::select('categoria', $cats, 0, ['class' =>'form-select']); ?>				    		
						</div>
					</div>	

					<div class="col-md-4">
						<label for="deposito">Número de depósito:</label>
						<div class="input-group">									
						   		<span class="input-group-text" id="basic-addon1">
						   			<i class="fas fa-map-marker-alt"></i>
						   		</span>								   
					    	<?php echo Form::select('deposito', ['1'=>'1','2'=>'2'], 1, ['class' =>'form-select']); ?>

						</div>
					</div>						
				</div>
				
				<hr>
				<div class="row mtop16">
					<div class="col-md-12">
						<label for="content">Descripción:</label>
						<?php echo Form::textarea('content', null, ['class' => 'form-control', 'id' => 'editor', 'rows'=>3] ); ?>

					</div>
				</div>

				<div class="row mtop16" >
					<div class="col-md-12">
						<?php echo Form::submit('Guardar', ['class' => 'btn btn-success']); ?>

					</div>
				</div>
		</div>
			
			<?php echo Form::close(); ?>

		</div>
	</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH G:\www\cms\resources\views/admin/piezas/agregar.blade.php ENDPATH**/ ?>