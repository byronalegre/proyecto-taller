<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Piezas</title>
	
</head>
	<body style="font-size: 12px;">
				<header><img style="width: 250px" src="<?php echo e(url('/static/images/logo.png')); ?>"><p style="font-family: Tahoma, sans-serif; font-weight: 1px; font-size: 10px;">
						Teléfono: <?php echo e(config('settings.telefono')); ?>

						<br>
						Dirección: <?php echo e(config('settings.direccion')); ?>

					</p></header>
				

				<div style="text-align: right; font-family: Tahoma, sans-serif; font-size: 10px; margin-top: 16px;">Fecha: <?php echo e(date("d-m-Y ", time())); ?>

				</div>

				<div style="font-size: 25px; text-align: center; font-family: courier; font-weight: bold;"></i> 
				Reporte stock de piezas
				</div>
				
				<div style="font-family: Tahoma, sans-serif; font-size: 10px;">Cantidad de items: <?php echo e(count($piezas->all())); ?>

				</div>
				
				<?php if($piezas_stock_min != 0): ?>
				<table style=" width: 100%; border: 1px solid black; font-family: Tahoma, sans-serif; margin-top: 16px;">
				<caption style="font-family: Tahoma, sans-serif; font-size: 12px; text-align: left; font-weight: bold;">Piezas con stock bajo</caption>
					<tr style="color:black; font-weight: bold; border-bottom: 1px solid black;font-size: 12px;">
						<td>Código</td>
						<td>Nombre</td>		
						<td>Marca</td>						
						<td>Categoría</td>
						<td style="text-align: right;">Mínimo</td>
						<td style="text-align: right;">Cantidad</td>
						<td style="text-align: right;">Depósito</td>
					</tr>
					<tbody style="font-size: 14px; border-top: 1px solid black; font-size: 12px;">
						<?php $__currentLoopData = $piezas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(($p->cantidad_min > $p->cantidad)&&($p->cantidad != 0)): ?>	
								<tr>
									<td><?php echo e($p->codigo); ?></td>
									<td><?php echo e($p->name); ?></td>
									<td><?php echo e($p->mark->name); ?></td>										
									<td><?php echo e($p->cat->name); ?></td>
									<td style="text-align: right;"><?php echo e($p->cantidad_min); ?></td>
									<td style="text-align: right;"><?php echo e($p->cantidad); ?></td>
									<td style="text-align: right;"><?php echo e($p->deposito); ?></td>
								</tr>
							<?php endif; ?>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>	
					</tbody>
				</table>
				<?php endif; ?>

				<?php if($piezas_stock_normal != 0): ?>
				<table style=" width: 100%; border: 1px solid black; font-family: Tahoma, sans-serif; margin-top: 16px;">
				<caption style="font-family: Tahoma, sans-serif; font-size: 12px; text-align: left; font-weight: bold;">Piezas con stock normal</caption>
					<tr style="color:black; font-weight: bold; border-bottom: 1px solid black;font-size: 12px;">
						<td>Código</td>
						<td>Nombre</td>		
						<td>Marca</td>						
						<td>Categoría</td>
						<td style="text-align: right;">Mínimo</td>
						<td style="text-align: right;">Cantidad</td>
						<td style="text-align: right;">Depósito</td>
					</tr>
					<tbody style="font-size: 14px; border-top: 1px solid black; font-size: 12px;">
						<?php $__currentLoopData = $piezas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if($p->cantidad >= $p->cantidad_min): ?>
								<tr>
									<td><?php echo e($p->codigo); ?></td>
									<td><?php echo e($p->name); ?></td>
									<td><?php echo e($p->mark->name); ?></td>										
									<td><?php echo e($p->cat->name); ?></td>
									<td style="text-align: right;"><?php echo e($p->cantidad_min); ?></td>
									<td style="text-align: right;"><?php echo e($p->cantidad); ?></td>
									<td style="text-align: right;"><?php echo e($p->deposito); ?></td>
								</tr>
							<?php endif; ?>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>	
					</tbody>
				</table>
				<?php endif; ?>

				<?php if($piezas_sin_stock != 0): ?>
				<table style=" width: 100%; border: 1px solid black; font-family: Tahoma, sans-serif; margin-top: 16px;">
				<caption style="font-family: Tahoma, sans-serif; font-size: 12px; text-align: left; font-weight: bold;">Piezas sin stock</caption>
					<tr style="color:black; font-weight: bold; border-bottom: 1px solid black;font-size: 12px;">
						<td>Código</td>
						<td>Nombre</td>		
						<td>Marca</td>						
						<td>Categoría</td>
						<td style="text-align: right;">Mínimo</td>
						<td style="text-align: right;">Cantidad</td>
						<td style="text-align: right;">Depósito</td>
					</tr>
					<tbody style="font-size: 14px; border-top: 1px solid black; font-size: 12px;">
						<?php $__currentLoopData = $piezas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if($p->cantidad == 0): ?>
								<tr>
									<td><?php echo e($p->codigo); ?></td>
									<td><?php echo e($p->name); ?></td>
									<td><?php echo e($p->mark->name); ?></td>										
									<td><?php echo e($p->cat->name); ?></td>
									<td style="text-align: right;"><?php echo e($p->cantidad_min); ?></td>
									<td style="text-align: right;"><?php echo e($p->cantidad); ?></td>
									<td style="text-align: right;"><?php echo e($p->deposito); ?></td>
								</tr>
							<?php endif; ?>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>	
					</tbody>
				</table>		
				<?php endif; ?>

				<script type="text/php">
				    if ( isset($pdf) ) {
				        $pdf->page_script('
				            $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
				            $pdf->text(270, 730, "Página $PAGE_NUM de $PAGE_COUNT", $font, 10);
				        ');
				    }
				</script>
	</body>
</html>
<?php /**PATH G:\www\cms\resources\views/admin/piezas/pdf-stock.blade.php ENDPATH**/ ?>