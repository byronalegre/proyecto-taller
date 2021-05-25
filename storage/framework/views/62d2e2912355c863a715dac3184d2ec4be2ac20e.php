

<?php $__env->startSection('title','Completar tarea'); ?>


<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item">
	<a href="<?php echo e(url('/admin/tareas/all')); ?>"><i class="fas fa-tasks"></i> Tareas</a>
</li>
<li class="breadcrumb-item">
	<a href="<?php echo e(url('/admin/tareas/'.$t->id.'/detalle')); ?>"><i class="fas fa-info-circle"></i> Detalle tarea: <?php echo e($t->codigo); ?></a>
</li>
<li class="breadcrumb-item">
	<a href="<?php echo e(url('/admin/tareas/'.$t->id.'/complete')); ?>"><i class="fas fa-check"></i> Completar tarea</a>
</li>
<?php $__env->stopSection(); ?>
 

<?php $__env->startSection('content'); ?>

<div class="container-fluid">
	<div class="panel shadow">
		<div class="header">
			<h2 class="title"><i class="fas fa-check"></i> Completar tarea</h2>
		</div>
		<div class="inside">
			<?php echo Form::open(['url' => '/admin/tareas/'.$t->id.'/complete','files'=>true,'id'=>'formulario']); ?>	
				<div class="row">
					<div class="col-md-4">
							<label for="codigo">Código:</label>
							<div class="input-group">									
						   		<span class="input-group-text" id="basic-addon1">
						   			<i class="fas fa-barcode"></i>
						   		</span>								    
					    	<?php echo Form::text('codigo', $t->codigo, ['class' => 'form-control', 'id' => 'orden_id', 'disabled'] ); ?>

					    	</div>
					</div>

					

					<div class="col-md-4">
							<label for="tarea">Tarea:</label>
							<div class="input-group">								
							   		<span class="input-group-text" id="basic-addon1">
							   			<i class="fas fa-tasks"></i>
							   		</span>							   
						    	<?php echo Form::select('tarea', $tarea, $t->tarea_id, ['class' =>'form-select']); ?>

						    </div>
					</div>
					
					<div class="col-md-4">
							<label for="fecha_programada">Fecha programada:</label>
							<div class="input-group">									
						   		<span class="input-group-text" id="basic-addon1">
						   			<i class="fas fa-calendar-day"></i>
						   		</span>								    
					    	<?php echo Form::date('fecha_programada', $t->fecha_prog, ['class' => 'form-control', 'disabled'] ); ?>

					    	</div>
					</div>
				</div>	

				<div class="row mtop16">
					<div class="col-md-12">
						<label for="descripcion">Descripción:</label>
						<div class="input-group">
						 	<textarea class="form-control" name="descripcion" rows="3" id="descripcion"><?php echo e($t->descripcion); ?></textarea>
					    </div>
					</div>
				</div>

				<div class="row mtop16" style="justify-content: center;">
					<div class="col-md-6">
						<div class="card border-warning border-3" id="card_check" style="display: none;">	
							<div class="card-header">Detalle solicitud</div>						
							<div class="card-body p-0">								
								<table class="table mb-0" style="text-align: center;" id="tablaTarea">
									<thead class="bg-light">
										<td>Productos solicitados</td>
										
										<td width="100">Incluido</td>
									</thead>
									<tbody>
										
									</tbody>
								</table>
							</div>
														
						</div>						
					</div>					
				</div>

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
							  	 

							  	 <select name="producto" id="producto" class="form-select">
							  	 	<option value="" selected>Seleccione un item</option>
							  	 	
							  	 	<?php $__currentLoopData = $prods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>							  	 		
							  	 		<option value="<?php echo e($p->id); ?>"><?php echo e($p->name.' ['); ?>

							  	 			<?php if($p->reserve == '[]'): ?>
												<?php echo e($p->cantidad); ?>

											<?php else: ?>						
							  	 				<?php $__currentLoopData = $array_r; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
													<?php if($p->id == $a['pieza_id']): ?>
														<?php $__currentLoopData = $t->detalle; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
															<?php if($p->id == $ot->pieza_id): ?>
																<?php echo e(($p->cantidad - $a['cantidad_req']) + $ot->cantidad_req); ?>

															<?php break 2; ?>
															<?php endif; ?>
														<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>	

														<?php if($a['cantidad_req'] != 0): ?>	
															<?php echo e($p->cantidad - $a['cantidad_req']); ?>

														<?php endif; ?>
													<?php endif; ?>
												<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>												
											<?php endif; ?>

							  	 		<?php echo e(']'); ?></option>
							  	 	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							  	 	
							  	 </select>

							    </div>
							</div>
							<div class="col-md-5">
								<label for="cantidad_usada">Cantidad utilizada:</label>
								<div class="input-group">									
							   		<span class="input-group-text">
							   			<i class="fas fa-minus"></i>
							   		</span>	
							   		<input type="number" class="form-control" min="1" max="<?php echo e($prods); ?>" name="cantidad_usada" id="cantidad_usada"> 
						    	</div>
							</div>

							<div class="col-md-1">	
								<button style="border-radius: 20px" id="agregar_item" class="btn btn-warning mtop16 shadow" data-toggle="tooltip" data-placement="top" title="Agregar">
									<i class="fas fa-plus"></i>
								</button>
							</div>	
							<div class="col-md-1">	
								<button style="border-radius: 20px" id="fila_hide" class="btn btn-primary mtop16 shadow" data-toggle="tooltip" data-placement="top" title="Mostrar detalle solicitud" type="button">
									<i class="fas fa-eye"></i>
								</button>
							</div>
						</div>
						<hr>
						<table class="table table-bordered mtop16" id="tabla">
							<thead class="table-secondary">
								<tr>
									<td>Producto</td>
									<td style="text-align: center;" >Cantidad utilizada</td>
									<td width="100"></td>
								</tr>
							</thead>
							<tbody>
							</tbody>
						<?php echo Form::text('productos', $t ,['class' => 'form-control', 'id'=>'productos', 'hidden'] ); ?>

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


<?php echo $__env->make('admin.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH G:\www\cms\resources\views/admin/tareas/complete.blade.php ENDPATH**/ ?>