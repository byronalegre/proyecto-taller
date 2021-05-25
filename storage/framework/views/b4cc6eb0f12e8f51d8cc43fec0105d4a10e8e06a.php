

<?php $__env->startSection('title','Nueva tarea'); ?>


<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item">
	<a href="<?php echo e(url('/admin/tareas/all')); ?>"><i class="fas fa-tasks"></i> Tareas</a>
</li>
<li class="breadcrumb-item">
	<a href="<?php echo e(url('/admin/tareas/agregar')); ?>"><i class="fas fa-plus-circle"></i> Nueva tarea</a>
</li>
<?php $__env->stopSection(); ?>
 

<?php $__env->startSection('content'); ?>

<div class="container-fluid"><!-- ONCONTEXTMENU DESACTIVA F12-->
	<div class="panel shadow">
		<div class="header">
			<h2 class="title"><i class="fas fa-plus-circle"></i> Nueva tarea</h2>
		</div>
		<div class="inside">			
			<?php echo Form::open(['url' => '/admin/tareas/agregar','files'=>true]); ?>	
				<div class="row">
					<div class="col-md-6">
						<label for="tarea">Tarea:</label>
						<div class="input-group">								
						   		<span class="input-group-text" id="basic-addon1">
						   			<i class="fas fa-tasks"></i>
						   		</span>							   
					    	<?php echo Form::select('tarea', $tarea, null, ['class' =>'form-select']); ?>

					    </div>
					</div>

					<div class="col-md-6">
						<label for="fecha_programada">Fecha programada:</label>
						<div class="input-group">									
					   		<span class="input-group-text" id="basic-addon1">
					   			<i class="fas fa-calendar-day"></i>
					   		</span>								    
				    	<?php echo Form::date('fecha_programada', now(), ['class' => 'form-control'] ); ?>

				    	</div>
					</div>
					
					
				</div>
				<div class="row mtop16">
					<div class="col-md-12">
						<label for="descripcion">Descripción:</label>
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
							<div class="col-md-6">
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
							<div class="col-md-3">
								<label for="cantidad">Cantidad solicitada:</label>
								<div class="input-group">									
							   		<span class="input-group-text">
							   			<i class="fas fa-minus"></i>
							   		</span>	
							   		<input type="number" class="form-control" min="1" max="<?php echo e($prods); ?>" name="cantidad" id="cantidad"> 
						    	</div>
							</div>
							<div class="col-md-1">	
								<button style="border-radius: 20px" id="agregar_item" class="btn btn-warning mtop16 shadow" data-toggle="tooltip" title="Agregar">
									<i class="fas fa-plus" data-toggle="tooltip" title="Agregar"></i>
								</button>
							</div>	
							<?php if(kvfj(Auth::user()->permisos, 'piezas')): ?>
							<div class="col-md-1">	
								<button type="button" class="btn btn-primary mtop16" data-bs-toggle="modal" data-bs-target="#exampleModal">
								  <i class="fas fa-bars" data-toggle="tooltip" title="Ver listado de piezas"></i>
								</button>

								<!-- Modal -->
								<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
								  <div class="modal-dialog modal-lg">
								    <div class="modal-content">
								      <div class="modal-header bg-dark text-white">
								        <h5 class="modal-title" id="exampleModalLabel">Listado de piezas y cantidades</h5>
								        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
								      </div>
								      <div class="modal-body p-0">
								        <table class="table table-bordered table-hover mb-0" width="100%">
								        	<tbody>
								        		<thead class="table-secondary">
								        			<tr>
								        				<td>Nombre</td>
								        				<td style="text-align: right;">Cantidad Minima</td>
								        				<td style="text-align: right;">Cantidad</td>
								        				<td style="text-align: right;">Reservadas</td>
								        			</tr>
								        		</thead>
								        		<?php $__currentLoopData = $prods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>									        			
									        		<?php if(($a->cantidad_min > $a->cantidad)&&($a->cantidad != 0)): ?>									        		
										        		<tr class="table-warning">								        			
										        			<td><?php echo e($a->name); ?></td>
										        			<td style="text-align: right;"><?php echo e($a->cantidad_min); ?></td>
										        			<td style="text-align: right;"><?php echo e($a->cantidad); ?></td>
										        			<?php if($a->reserve == '[]'): ?>
																<td style="text-align: right;">-</td>
															<?php else: ?>
																<?php $__currentLoopData = $array_r; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
																	<?php if($a->id == $i['pieza_id']): ?>
																		<?php if($i['cantidad_req'] != 0): ?>
																			<td style="text-align: right;"><?php echo e($i['cantidad_req']); ?></td>
																		<?php endif; ?>
																	<?php endif; ?>
																<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
															<?php endif; ?>
										        		</tr>
									        		<?php endif; ?>
									        		<?php if($a->cantidad == 0): ?>							        		
										        		<tr class="table-danger">								        			
										        			<td><?php echo e($a->name); ?></td>
										        			<td style="text-align: right;"><?php echo e($a->cantidad_min); ?></td>
										        			<td style="text-align: right;"><?php echo e($a->cantidad); ?></td>
										        			<?php if($a->reserve == '[]'): ?>
																<td style="text-align: right;">-</td>
															<?php else: ?>
																<?php $__currentLoopData = $array_r; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
																	<?php if($a->id == $i['pieza_id']): ?>
																		<?php if($i['cantidad_req'] != 0): ?>
																			<td style="text-align: right;"><?php echo e($i['cantidad_req']); ?></td>
																		<?php endif; ?>
																	<?php endif; ?>
																<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
															<?php endif; ?>
										        		</tr>
									        		<?php endif; ?>
									        		<?php if($a->cantidad_min <= $a->cantidad): ?>
									        			<tr>								        			
										        			<td><?php echo e($a->name); ?></td>
										        			<td style="text-align: right;"><?php echo e($a->cantidad_min); ?></td>
										        			<td style="text-align: right;"><?php echo e($a->cantidad); ?></td>
										        			<?php if($a->reserve == '[]'): ?>
																<td style="text-align: right;">-</td>
															<?php else: ?>
																<?php $__currentLoopData = $array_r; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
																	<?php if($a->id == $i['pieza_id']): ?>
																		<?php if($i['cantidad_req'] != 0): ?>
																			<td style="text-align: right;"><?php echo e($i['cantidad_req']); ?></td>
																		<?php endif; ?>
																	<?php endif; ?>
																<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
															<?php endif; ?>
										        		</tr>
										        	<?php endif; ?>
								        		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								        	</tbody>

								        	<caption class="text-warning mx-2 p-0" style="text-align: right;">Bajo Stock <button disabled="true" class="btn btn-warning"></button></caption>
								        	<caption class="text-danger mx-2 p-0" style="text-align: right;">Sin Stock <button disabled="true" class="btn btn-danger"></button></caption>
								        	
								        </table>
								      </div>
								      <div class="modal-footer">
								        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
								      </div>
								    </div>
								  </div>
								</div>
							</div>
							<?php endif; ?>
							<div class="col-md-1">
								<?php if(kvfj(Auth::user()->permisos, 'pedidos_agregar')): ?>
									<a class="btn btn-success mtop16" href="<?php echo e(route('pedidos_agregar')); ?>" data-toggle="tooltip" title="Generar Orden de Pedido"><i class="fas fa-external-link-alt"></i></a>
								<?php endif; ?>
							</div>
						</div>
						<hr>
						<table class="table table-bordered mtop16" id="tabla">
							<thead class="table-secondary">
								<tr>
									<td>Producto</td>
									<td style="text-align: center;">Cantidad solicitada</td>
									<td width="100"></td>
								</tr>
							</thead>
							<tbody>
							</tbody>
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


<?php echo $__env->make('admin.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH G:\www\cms\resources\views/admin/tareas/agregar.blade.php ENDPATH**/ ?>