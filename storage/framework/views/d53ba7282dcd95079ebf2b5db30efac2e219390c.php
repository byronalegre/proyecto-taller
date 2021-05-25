<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Detalle de pedido - <?php echo e($op->codigo); ?> </title>
	
</head>
	<body>
		
		<header>	
			<table width="100%" style="border: 2px solid black;border-bottom: 0px ">
				<tr>
					<td style="border-right: 2px solid black"><img style="width: 250px;" src="<?php echo e(url('/static/images/logo.png')); ?>"><p style="font-family: Tahoma, sans-serif; font-weight: 1px; font-size: 10px; margin-bottom: 0px;">						
							Teléfono: <?php echo e(config('settings.telefono')); ?>

							<br>
							Dirección: <?php echo e(config('settings.direccion')); ?>

						</p>
					</td>
					<td>
						<h2 style="font-size: 20px; text-align: center; font-family: courier;">	
							Orden de pedido 
							<br> 
							<?php echo e($op->codigo); ?><br>
							<?php echo e(date("d/m/Y ", time())); ?>

						</h2>
					</td>
				</tr>	
				
			</table>
			
		</header>

			<table width="100%" style="font-family: Tahoma, sans-serif; font-size: 12px; border: 2px solid black;">
				<tr>
					<td>
						<b>NRO DE ORDEN:</b>
						<a><?php echo e($op->codigo); ?></a>
					</td>	
					<td>
						<b>FECHA DE PEDIDO:</b>
						<a><?php echo e($op->created_at->format('d/m/Y')); ?></a>
					</td>								
				</tr>
				<tr>
					<td>
						<b>RESPONSABLE:</b>
						<a><?php echo e($op->user->name.' '.$op->user->lastname); ?></a>
					</td>
					<td>
						<b>FECHA PROGRAMADA:</b>
						<a><?php echo e(date('d/m/Y', strtotime($op->fecha_prog))); ?></a>
					</td>
				</tr>				
			</table>

			<table style="font-family: Tahoma, sans-serif; font-size: 12px; width: 100%; border: 2px solid black; border-top: 0px">
				<tr style="background-color: #c0c0c0; font-weight: bold;">
					<td>PRODUCTO</td>
                    <td>CANTIDAD</td>
				</tr>
				<tbody style="border-top: 1px solid black;">					
					<?php $__currentLoopData = $op->detalle; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<tr>
							<td><?php echo e($value->prods[0]->name); ?></td>
							<td><?php echo e($value['cantidad_req']); ?></td>						
						</tr>					
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>						
				</tbody> 
				<script type="text/php">
				    if ( isset($pdf) ) {
				        $pdf->page_script('
				            $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
				            $pdf->text(270, 730, "Página $PAGE_NUM de $PAGE_COUNT", $font, 10);
				        ');
				    }
				</script>

	</body>
</html><?php /**PATH G:\www\cms\resources\views/admin/ordenespedido/pdf.blade.php ENDPATH**/ ?>