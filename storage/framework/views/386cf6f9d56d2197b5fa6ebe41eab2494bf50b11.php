<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Detalle de remito - <?php echo e($r->codigo); ?> </title>
	
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
							Remito de compra 
							<br> 
							<?php echo e($r->codigo); ?><br>
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
						<a><?php echo e($r->codigo); ?></a>
					</td>
					<td>
						<b>PROVEEDOR:</b>
						<a><?php echo e($r->provs->name); ?></a>
					</td>	
									
				</tr>
				<tr>
					<td>
						<b>FECHA DE COMPRA:</b>
						<a><?php echo e($r->created_at->format('d/m/Y')); ?></a>
					</td>
					<td>
						<b>C.U.I.T:</b>
						<a><?php echo e($r->provs->cuit); ?></a>
					</td>					
				</tr>
				<tr>
					<td>
						<b>RESPONSABLE:</b>
						<a><?php echo e($r->user->name.' '.$r->user->lastname); ?></a>
					</td>
					<td>
						<b>DOMICILIO:</b>
						<a><?php echo e($r->provs->direccion); ?></a>
					</td>
				</tr>
				
			</table>

			<table style=" font-family: Tahoma, sans-serif; font-size: 12px; width: 100%; border: 2px solid black; border-top: 0px">
				<tr style="background-color: #c0c0c0; font-weight: bold;">
					<td>PRODUCTO</td>
                    <td style="text-align: right;">CANTIDAD</td>
                    <td style="text-align: right;">PRECIO UNITARIO</td>
                    <td style="text-align: right;">IMPORTE</td>
				</tr>
				<tbody style="border-top: 1px solid black;">					
						<?php $__currentLoopData = $r->detalle; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<tr>
						<td><?php echo e($value->prods[0]->name); ?></td>
						<td style="text-align: right;"><?php echo e($value['cantidad_req']); ?></td>
						<td style="text-align: right;">$<?php echo e($value['precio']); ?></td>
						<td style="text-align: right;">$<?php echo e(number_format($value['cantidad_req']*$value['precio'], 2)); ?></td>							
						</tr>
						<?php echo e($acum += ($value['cantidad_req']*$value['precio'])); ?>							
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>						
				</tbody> 
				<tfoot style="background-color: #c0c0c0;">
					<tr>	
	           			</td>
	           			<td>Total:</td>
	            		<td colspan="2"></td>					
						<td style="text-align: right;"><b>$<?php echo e(number_format($acum, 2)); ?></b></td>
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
</html><?php /**PATH G:\www\cms\resources\views/admin/remitos/pdf.blade.php ENDPATH**/ ?>