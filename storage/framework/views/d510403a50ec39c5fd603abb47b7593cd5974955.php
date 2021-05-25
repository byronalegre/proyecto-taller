

<?php $__env->startSection('title','Inicio'); ?>

<?php $__env->startSection('content'); ?>
 
<div class="container-fluid">
	<?php if(kvfj(Auth::user()->permisos, 'estadisticas_rapidas')): ?>
	
	<div class="panel shadow">
		<div class="header">
			<h2 class="title"><i class="fas fa-chart-line"></i> Estadísticas rápidas</h2>
		</div>
		<div class="inside">
			<div class="row">
				<div class="col-md-3 d-flex">
					<a href="<?php echo e(url('/admin/usuarios/0')); ?>" type="button" class="btn btn-dark shadow">
						<i class="fas fa-users fa-2x mtop16"></i>
							Usuarios registrados 
						<span class="big-count badge rounded-pill bg-success mtop16">
							<?php echo e($u_reg); ?>

						</span>
					</a>
				</div>
				<div class="col-md-3 d-flex">
					<a href="<?php echo e(url('/admin/piezas/1')); ?>" type="button" class="btn btn-dark shadow">
						<i class="fas fa-cogs fa-2x mtop16"></i>
							Piezas activas 
						<span class="big-count badge rounded-pill bg-success mtop16">
							<?php echo e($piezas_act); ?>

						</span>
					</a>
				</div>
				<?php if(kvfj(Auth::user()->permisos, 'facturado')): ?>
				
					<div class="col-md-3 d-flex">
						<a href="<?php echo e(url('/admin/compras')); ?>" type="button" class="btn btn-dark shadow">
							<i class="fas fa-receipt fa-2x mtop16"></i>
								Compras realizadas hoy 
							<span class="big-count badge rounded-pill bg-success mtop16">
								<?php echo e(count($compras)); ?>

							</span>
						</a>
					</div>

					<div class="col-md-3 d-flex">
						<a type="button" class="btn btn-dark shadow">
							<i class="fas fa-cash-register fa-2x mtop16"></i>
								Gastado hoy 
							<span class="big-count badge rounded-pill bg-success mtop16">
								<?php $__currentLoopData = $compras; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<?php $__currentLoopData = $c->productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<?php echo e($value); ?>

									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</span>
						</a>
					</div>
				<?php endif; ?>
			</div>
			</div>
		</div>
			<div class="panel shadow mtop16">
				<div class="header">
					<h2 class="title"><i class="fas fa-chart-pie"></i> Gráficos</h2>
				</div>
			<div class="inside">
				<div class="row">
						<!--DESDE ACA LOS GRAFICOS-->
								<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
							    <script type="text/javascript">
							      google.charts.load('current', {'packages':['corechart']});
							      google.charts.setOnLoadCallback(drawChart);

							      function drawChart() {

							        var data = google.visualization.arrayToDataTable([
							          ['Tipo', 'Cantidad'],
							          ['Usuarios registrados',     <?php echo e($u_reg); ?>],
							          ['Usuarios suspendidos',     <?php echo e($u_susp); ?>],
							        ]);

							        var options = {
							          title: 'Usuarios total: <?php echo e($users); ?>',
							          slices: {
									            0: { color: 'green', offset: 0.1},
									            1: { color: 'grey' }
									          },
									  is3D: true
							        };

							        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

							        chart.draw(data, options);
							      
							        var data2 = google.visualization.arrayToDataTable([
							          ['Piezas', 'Cantidad'],
							          ['Piezas activas',     <?php echo e($piezas_act); ?>],
							          ['Piezas inactivas',     <?php echo e($piezas_inact); ?>],
							        ]);

							        var options2 = {
							          title: 'Piezas total: <?php echo e($piezas); ?>',
							          slices: {
									            0: { color: 'green', offset: 0.1},
									            1: { color: 'grey' }
									          },
									  is3D: true
							        };

							        var chart = new google.visualization.PieChart(document.getElementById('piechart2'));

							        chart.draw(data2, options2);
							      }
							    </script>
							    <div id="piechart" style="width: 400px; height: 200px;"></div>
							    <div id="piechart2" style="width: 400px; height: 200px;"></div>	
						<!--HASTA ACA-->
					</div>
				</div>
		</div>
	
	<?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH G:\www\cms\resources\views/admin/Panel.blade.php ENDPATH**/ ?>