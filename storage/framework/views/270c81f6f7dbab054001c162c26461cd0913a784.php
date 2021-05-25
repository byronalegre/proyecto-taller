<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Ordenes de Compra</title>
	
</head>
	<body>
				<header><img style="width: 250px" src="<?php echo e(url('/static/images/logo.png')); ?>"><p style="font-family: Tahoma, sans-serif; font-weight: 1px; font-size: 10px;">
					Teléfono: <?php echo e(config('settings.telefono')); ?>

					<br>
					Dirección: <?php echo e(config('settings.direccion')); ?>

				</p></header>
			
				<h2 style="font-size: 25px; text-align: center; font-family: courier;"></i> 
				Reporte de Ordenes de Compra del año <?php echo e(now()->format('Y')); ?>

				</h2>
				<div style="font-family: Tahoma, sans-serif; font-size: 10px;">Cantidad de items: <?php echo e(count($oc->all())); ?>

				</div>
				<table style="font-family: Tahoma, sans-serif; width: 100%; border: 1px solid black;">
					<tr style="color:black; font-weight: bold; border-bottom: 1px solid black; font-size: 12px">
					<td>Código</td>
					<td></td>
					<td>Orden de Pedido</td>
					<td>Proveedor</td>	
					<td>Responsable</td>				
					<td>Fecha registro</td>
					</tr>
					<tbody style="font-size: 12px; border-top: 1px solid black;">
						<?php $__currentLoopData = $oc; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<tr>
								<td><?php echo e($i->codigo); ?> </td>	
								<td>»</td>
								<td><?php echo e($i->orden->codigo); ?> </td><!--mirar esto-->			
								<td><?php echo e($i->provs->name); ?> </td>
								<td><?php echo e($i->user->name.' '.$i->user->lastname); ?> </td>
								<td><?php echo e($i->created_at->format('d/m/Y (H:i)')); ?> </td>	
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
<?php /**PATH G:\www\cms\resources\views/admin/ordenescompra/ordenescompra_ano_pdf.blade.php ENDPATH**/ ?>