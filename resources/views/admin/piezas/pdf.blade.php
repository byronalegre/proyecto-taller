<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Piezas</title>
	
</head>
	<body>
				<header><img style="width: 250px" src="{{url('/static/images/logo.png')}}"><h6 style="font-family: courier; font-weight: 1px">Tel: {{config('settings.telefono')}}</h6></header>

			
				<h2 style="font-size: 25px; text-align: center; font-family: courier;"></i> 
				Reporte de piezas
				</h2>
				<div style="font-family: courier;">Cantidad de items: {{ count($piezas->all()) }}
				</div>
				<table style=" width: 100%; text-align: center; border: 1px solid black; font-family: courier;">
					<tr style="color:black; font-weight: bold; border-bottom: 1px solid black;">
						<td>Código</td>
						<td>Nombre</td>		
						<td>Marca</td>						
						<td>Categoría</td>
						<td>Mínimo</td>
						<td>Cantidad</td>
						<td>Depósito</td>
					</tr>
					<tbody style="font-size: 14px; border-top: 1px solid black;">
						@foreach($piezas as $p)
							<tr>
								<td>{{ $p->codigo }}</td>
								<td>{{ $p->name }}</td>
								<td>{{ $p->mark->name }}</td>										
								<td>{{ $p->cat->name }}</td>
								<td>{{ $p->cantidad_min }}</td>
								<td>{{ $p->cantidad }}</td>
								<td>{{ $p->deposito }}</td>
							</tr>
						@endforeach	
					</tbody>
				</table>
						
				<div style="text-align: right; font-family: courier">Fecha: {{date("d-m-Y ", time()) }}
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
