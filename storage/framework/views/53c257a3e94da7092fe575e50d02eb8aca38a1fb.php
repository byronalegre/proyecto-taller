<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Detalle de remito - <?php echo e($c->codigo); ?> </title>
	
</head>
	<body>
		
		<header>	
			<table width="100%" style="border: 2px solid black;border-bottom: 0px ">
				<tr>
					<td style="border-right: 2px solid black"><img style="width: 250px;" src="<?php echo e(url('/static/images/logo.png')); ?>"></td>
					<td>
						<h2 style="font-size: 20px; text-align: center; font-family: courier;">	
							Remito de compra 
							<br> 
							<?php echo e($c->codigo); ?><br>
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
						<a><?php echo e($c->codigo); ?></a>
					</td>
					<td>
						<b>PROVEEDOR:</b>
						<a><?php echo e($c->provs->name); ?></a>
					</td>	
									
				</tr>
				<tr>
					<td>
						<b>FECHA DE COMPRA:</b>
						<a><?php echo e($c->created_at->format('d/m/Y')); ?></a>
					</td>
					<td>
						<b>C.U.I.T:</b>
						<a><?php echo e($c->provs->cuit); ?></a>
					</td>					
				</tr>
				<tr>
					<td>
						<b>RESPONSABLE:</b>
						<a><?php echo e(substr($c->responsable,4)); ?></a>
					</td>
					<td>
						<b>DOMICILIO:</b>
						<a><?php echo e($c->provs->direccion); ?></a>
					</td>
				</tr>
				
			</table>

			<table style=" font-family: Tahoma, sans-serif; font-size: 12px; width: 100%; text-align: center; border: 2px solid black; border-top: 0px">
				<tr style="background-color: #c0c0c0; font-weight: bold;">
					<td>PRODUCTO</td>
                    <td>CANTIDAD</td>
                    <td>PRECIO UNITARIO</td>
                    <td>IMPORTE</td>
				</tr>
				<tbody style="border-top: 1px solid black;">					
						<?php $__currentLoopData = $a; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<tr>
						<td><?php echo e($value['producto']); ?></td>
						<td><?php echo e($value['cantidad']); ?></td>
						<td>$<?php echo e($value['precio']); ?></td>
						<td>$<?php echo e($value['cantidad']*$value['precio']); ?></td>							
						</tr>
						<?php echo e($acum += ($value['cantidad']*$value['precio'])); ?>							
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>						
				</tbody> 
				<tfoot style="background-color: #c0c0c0;">
					<tr>	
	           			</td>
	           			<td>Total:</td>
	            		<td colspan="2"></td>					
						<td><b>$<?php echo e($acum); ?></b></td>
	           		</tr>
				</tfoot>

				<script type="text/php">
				    if ( isset($pdf) ) {
				        $pdf->page_script('
				            $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
				            $pdf->text(270, 730, "Página $PAGE_NUM de $PAGE_COUNT", $font, 10);
				        ');
				    }
				</script>

	</body>
</html><?php /**PATH G:\www\cms\resources\views/admin/compras/pdf.blade.php ENDPATH**/ ?>