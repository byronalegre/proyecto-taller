<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Tareas</title>
	
</head>
	<body>
				<header><img style="width: 250px" src="<?php echo e(url('/static/images/logo.png')); ?>"><p style="font-family: Tahoma, sans-serif; font-weight: 1px; font-size: 10px;">
					Teléfono: <?php echo e(config('settings.telefono')); ?>

					<br>
					Dirección: <?php echo e(config('settings.direccion')); ?>

				</p></header>
			
				<h2 style="font-size: 25px; text-align: center; font-family: courier;"></i> 
				Reporte de Tareas  del mes
					<?php switch(date('n', strtotime(now()))):
						case (1): ?> Enero
						<?php break; ?>
						<?php case (2): ?> Febrero
						<?php break; ?>
						<?php case (3): ?> Marzo
						<?php break; ?>
						<?php case (4): ?> Abril
						<?php break; ?>
						<?php case (5): ?> Mayo
						<?php break; ?>
						<?php case (6): ?> Junio
						<?php break; ?>
						<?php case (7): ?> Julio
						<?php break; ?>
						<?php case (8): ?> Agosto
						<?php break; ?>
						<?php case (9): ?> Septiembre
						<?php break; ?>
						<?php case (10): ?> Octubre
						<?php break; ?>
						<?php case (11): ?> Noviembre
						<?php break; ?>
						<?php case (12): ?> Diciembre
						<?php break; ?>
					<?php endswitch; ?>
				</h2>
				<div style="font-family: Tahoma, sans-serif; font-size: 10px;">Cantidad de items: <?php echo e(count($ot->all())); ?>

				</div>
				<table style="font-family: Tahoma, sans-serif; width: 100%; border: 1px solid black;">
					<tr style="color:black; font-weight: bold; border-bottom: 1px solid black; font-size: 12px">
					<td>Código</td>
					<td>Tarea</td>					
					<td>Fecha solicitud</td>
					<td>Fecha programada</td>
					</tr>
					<tbody style="font-size: 12px; border-top: 1px solid black;">
						<?php $__currentLoopData = $ot; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<tr>
								<td><?php echo e($i->codigo); ?> </td>						
								<td><?php echo e($i->work->name); ?> </td>
								<td><?php echo e($i->created_at->format('d/m/Y (H:i)')); ?> </td>
								<td><?php echo e(date('d/m/Y',strtotime($i->fecha_prog))); ?> </td>
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
<?php /**PATH G:\www\cms\resources\views/admin/tareas/tareas_mes_pdf.blade.php ENDPATH**/ ?>