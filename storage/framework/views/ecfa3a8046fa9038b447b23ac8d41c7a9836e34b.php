<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Piezas</title>
	
</head>
	<body>
				<header><img style="width: 250px" src="<?php echo e(url('/static/images/logo.png')); ?>"><p style="font-family: Tahoma, sans-serif; font-weight: 1px; font-size: 10px;">
					Teléfono: <?php echo e(config('settings.telefono')); ?>

					<br>
					Dirección: <?php echo e(config('settings.direccion')); ?>

				</p></header>

			
				<h2 style="font-size: 25px; text-align: center; font-family: courier;"></i> 
				Reporte de piezas
				</h2>
				<div style="font-family: Tahoma, sans-serif; font-size: 10px;">Cantidad de items: <?php echo e(count($piezas->all())); ?>

				</div>
				<table style=" width: 100%; border: 1px solid black; font-family: Tahoma, sans-serif;">
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
							<tr>
								<td><?php echo e($p->codigo); ?></td>
								<td><?php echo e($p->name); ?></td>
								<td><?php echo e($p->mark->name); ?></td>										
								<td><?php echo e($p->cat->name); ?></td>
								<td style="text-align: right;"><?php echo e($p->cantidad_min); ?></td>
								<td style="text-align: right;"><?php echo e($p->cantidad); ?></td>
								<td style="text-align: right;"><?php echo e($p->deposito); ?></td>
							</tr>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>	
					</tbody>
				</table>
						
				<div style="text-align: right; font-family: Tahoma, sans-serif; font-size: 10px;">Fecha: <?php echo e(date("d-m-Y ", time())); ?>

				</div>

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
<?php /**PATH G:\www\cms\resources\views/admin/piezas/pdf.blade.php ENDPATH**/ ?>