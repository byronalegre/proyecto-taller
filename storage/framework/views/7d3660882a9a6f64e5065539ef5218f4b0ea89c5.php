

<?php $__env->startSection('title','Editar categoria'); ?>

<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item">
	<a href="<?php echo e(url('/admin/categorias/agregar')); ?>"><i class="fas fa-tags"></i> Categorias</a>
</li>
<li class="breadcrumb-item">
	<a href="<?php echo e(url('/admin/categorias/agregar')); ?>"><i class="fas fa-edit"></i> Editar categoría</a>
</li>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>

<div class="container-fluid">
	<div class="row">
		<div class="col-md-4">
			<div class="panel shadow">
				<div class="header">
					<h2 class="title"><i class="fas fa-edit"></i>Editar categoria
					</h2>
				</div>
				<div class="inside">
					<?php echo Form::open(['url' => 'admin/categorias/'.$cat->id.'/edit']); ?>

						<label for="title">Nombre de categoría:</label>
						<div class="input-group">							
						   		<span class="input-group-text" id="basic-addon1">
						   			<i class="fas fa-keyboard"></i>
						   		</span>						    
					    	<?php echo Form::text('name', $cat->name, ['class' => 'form-control']); ?>

					    </div>

					    <label for="seccion" class="mtop16">Sección:</label>
						<div class="input-group">							
						   		<span class="input-group-text" id="basic-addon1">
						   			<i class="fas fa-cubes"></i>
						   		</span>						    
					    	<?php echo Form::select('seccion', getSeccionArray(), $cat->seccion, ['class' =>'form-select']); ?>

					    		
						</div>

					    <label for="descripcion" class="mtop16">Descripción:</label>
						<div class="input-group">
						 	<?php echo Form::textarea('descripcion', $cat->descripcion, ['class' => 'form-control', 'rows'=>4]); ?>

					    </div>

					<?php echo Form::submit('Guardar', ['class' => 'btn btn-success mtop16']); ?>


					<?php echo Form::close(); ?>

				</div>
			
			</div>
		</div>

	</div>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH G:\www\cms\resources\views/admin/categorias/edit.blade.php ENDPATH**/ ?>