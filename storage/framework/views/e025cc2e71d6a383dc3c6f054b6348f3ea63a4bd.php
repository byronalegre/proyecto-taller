

<?php $__env->startSection('title','Categorias'); ?>

<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item">
	<a href="<?php echo e(url('/admin/categorias/0')); ?>"><i class="fas fa-tags"></i> Categorias</a>
</li>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>

<div class="container-fluid">
	<div class="row">
	<?php if(kvfj(Auth::user()->permisos, 'categorias_agregar')): ?>
		<div class="col-md-4">
			<div class="panel shadow">				
				<div class="header">
					<h2 class="title"><i class="fas fa-plus-circle"></i> Agregar categoria
					</h2>
				</div>				
				<div class="inside">					
					<?php echo Form::open(['url' => 'admin/categorias/agregar']); ?>

						<label for="title">Nombre de categoría:</label>
						<div class="input-group">							
						   		<span class="input-group-text" id="basic-addon1">
						   			<i class="fas fa-keyboard"></i>
						   		</span>						    
					    	<?php echo Form::text('name', null, ['class' => 'form-control']); ?>

					    </div>

					    <label for="seccion" class="mtop16">Sección:</label>
						<div class="input-group">							
						   		<span class="input-group-text" id="basic-addon1">
						   			<i class="fas fa-cubes"></i>
						   		</span>						    
					    	<?php echo Form::select('seccion', getSeccionArray(), 0, ['class' =>'form-select']); ?>

					    		
						</div>

					    <label for="descripcion" class="mtop16">Descripción:</label>
						<div class="input-group">
						 	<?php echo Form::textarea('descripcion', null, ['class' => 'form-control', 'rows'=>13]); ?>

					    </div>

					<?php echo Form::submit('Guardar', ['class' => 'btn btn-success mtop16']); ?>


					<?php echo Form::close(); ?>					
				</div>		
			</div>
		</div>
	<?php endif; ?>
		<div class="col-md-8 d-flex">
			<div class="panel shadow">
				<div class="header">
					<h2 class="title"><i class="fas fa-tags"></i> Categorias
					</h2>
				</div>

				<div class="inside">
					<div class="row mb-2">
						<div class="col-sm-2">
							<div class="dropend">
							  <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"> <h7></h7> </button>
	
							  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">						    
									<?php $__currentLoopData = getSeccionArray(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m => $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>				
										<li>
											<a class="dropdown-item" href="<?php echo e(url('/admin/categorias/'.$m)); ?>" id="cats">
												<?php echo e($k); ?>

											</a>
										</li>							
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							  </div>
							</div>
						</div>

						<div class="col-sm-6">
							<form class="d-flex">
								<div class="input-group">
									<span class="input-group-text"><i class="fas fa-search"></i></span>
									<input name="search" type="text" class="form-control form-control-sm w-50" placeholder="Ingrese su búsqueda" aria-label="Ingrese su búsqueda" aria-describedby="button-addon2">
									<button class="btn btn-outline-dark btn-sm" type="submit" id="button-addon2">Buscar</button>
								</div>
							</form>
						</div>
						<div class="col-sm-4">
							<form>
								<div class="input-group input-group-sm">
									<span class="input-group-text" id="basic-addon1">Mostrar</span>
									<input name="paginate" type="number" class="form-control" aria-describedby="basic-addon1" placeholder="<?php echo e(session('paginate')); ?> elementos" min="1" >
								</div>
							</form>
						</div>
						
					</div>

					<table class="table table-hover" id="Datatable" style="width: 100%">
						<thead class="table-dark">
							<tr>
								<td hidden="true">ID</td>
								<td>Nombre</td>
								<td>Descripción</td>
								<td width="90"></td>
							</tr>
						</thead>
						<tbody>
							<?php $__currentLoopData = $cats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<tr>
									<td hidden="true"><?php echo e($cat->id); ?></td>
									<td><?php echo e($cat->name); ?></td>
									<td><?php echo e($cat->descripcion); ?></td>
									
									<td>
										<?php if(kvfj(Auth::user()->permisos, 'categorias_editar')): ?>
										<a class="btn btn-primary btn-sm" href="<?php echo e(url('admin/categorias/'.$cat->id.'/edit')); ?>"data-toggle="tooltip" data-placement="top" title="Editar">
										<i class="fas fa-edit"></i>
										</a>
										<?php endif; ?>
										<?php if(kvfj(Auth::user()->permisos, 'categorias_eliminar')): ?>
										<a class="btn btn-danger btn-sm" href="<?php echo e(url('admin/categorias/'.$cat->id.'/delete')); ?>"data-toggle="tooltip" data-placement="top" title="Eliminar">
										<i class="fas fa-times"></i>
										</a>
										<?php endif; ?>
									</td>
								</tr>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tbody>
					</table>
					<?php if($search): ?>				
						<?php echo e($cats->appends(['search'=>$search])); ?>

						<p class="mtop16">cats
							Mostrando <?php echo e($cats->count()); ?> de <?php echo e($cats->total()); ?> elemento(s).
						</p>	
					<?php else: ?>
						<?php echo e($cats->links()); ?>

						<p class="mtop16">
							Mostrando <?php echo e($cats->count()); ?> de <?php echo e($cats->total()); ?> elemento(s).
						</p>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH G:\www\cms\resources\views/admin/categorias/home.blade.php ENDPATH**/ ?>