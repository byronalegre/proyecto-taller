<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Detalle de Trabajo - <?php echo e($t->codigo); ?> </title>
	
</head>
	<body>
		
		<header>	
			<table width="100%" style="border: 2px solid black;border-bottom: 0px ">
				<tr>
					<td style="border-right: 2px solid black "><img style="width: 250px;" src="<?php echo e(url('/static/images/logo.png')); ?>"><p style="font-family: Tahoma, sans-serif; font-weight: 1px; font-size: 10px; margin-bottom: 0px;">						
							Teléfono: <?php echo e(config('settings.telefono')); ?>

							<br>
							Dirección: <?php echo e(config('settings.direccion')); ?>

						</p>
					</td>
					<td>
						<h2 style="font-size: 20px; text-align: center; font-family: courier;">	
							ORDEN DE TRABAJO 
							<br> 
							<?php echo e($t->codigo); ?><br>
							<?php echo e(date("d/m/Y ", time())); ?>

						</h2>
					</td>
				</tr>	
				
			</table>
			
		</header>

			<table width="100%" style="font-family: Tahoma, sans-serif; font-size: 12px;border: 2px solid black;">
				<tr>
					<td>
						<b>NRO DE ORDEN:</b>
						<a><?php echo e($t->codigo); ?></a>
					</td>
					<td>
						<b>RESPONSABLE:</b>
						<a> <?php echo e($t->user->name.' '.$t->user->lastname); ?> </a>
					</td>
					<td>
						<b>TAREA:</b>
						<a><?php echo e($t->work->name); ?></a>
					</td>	
									
				</tr>
				<tr>
					<td>
						<b>FECHA DE SOLICITUD:</b>
						<a><?php echo e($t->created_at->format('d/m/Y')); ?></a>
					</td>
					<td>
						<b>FECHA PROGRAMADA</b>
						<a><?php echo e(date('d/m/Y',strtotime($t->fecha_prog))); ?></a>
					</td>					
				</tr>
				
			</table>
			
			<table style="font-family: Tahoma, sans-serif; font-size: 12px; width: 100%; border: 2px solid black; border-top: 0px">
				
				<thead style="background-color: #c0c0c0; font-weight: bold;">
					<tr>
						<td>PRODUCTO</td>
						<td style="text-align: center;">CANTIDAD SOLICITADA</td>
	                    <td style="text-align: center;">CANTIDAD UTILIZADA</td>	                    
					</tr>
				</thead>

				<tbody style="border-top: 1px solid black;">					
					<?php $__currentLoopData = $t->detalle; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<tr>
						<td><?php echo e($value->prods[0]->name); ?></td>
						<td style="text-align: center;"><?php echo e($value->cantidad_req); ?></td>		
						<td style="text-align: center;"><?php echo e($value->cantidad_usada); ?></td>						
					</tr>			
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>						
				</tbody> 	
			</table>		

			<script type="text/php">
			    if ( isset($pdf) ) {
			        $pdf->page_script('
			            $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
			            $pdf->text(270, 730, "Página $PAGE_NUM de $PAGE_COUNT", $font, 10);
			        ');
			    }
			</script>	
	</body>
</html><?php /**PATH G:\www\cms\resources\views/admin/tareas/pdf.blade.php ENDPATH**/ ?>