<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Proveedores</title>
	
</head>
	<body>
				<header><img style="width: 250px" src="{{url('/static/images/logo.png')}}"></header>
				<h6 style="font-family: courier; font-weight: 1px">Tel: {{config('settings.telefono')}}</h6>
			
				<h2 style="font-size: 25px; text-align: center; font-family: courier;"></i> 
				Reporte de proveedores
				</h2>
				<div style="font-family: courier;">Cantidad de items: {{ count($provs->all()) }}
				</div>
				<table style=" font-family: courier; width: 100%; text-align: center; border: 1px solid black;">
					<tr style="color:black; font-weight: bold; border-bottom: 1px solid black;">
					<td>CUIT</td>
					<td>Nombre</td>					
					<td>Dirección</td>
					<td>Teléfono</td>
					</tr>
					<tbody style="border-top: 1px solid black;">
						@foreach($provs as $p)
							<tr>
								<td>{{ $p->cuit }} </td>
								<td>{{ $p->name }} </td>								
								<td>{{ $p->direccion }} </td>
								<td>{{ $p->telefono }} </td>
							</tr>
						@endforeach	
					</tbody>
				</table>
						
				<div style="text-align: right; font-family: courier;">Fecha: {{date("d-m-Y ", time()) }}
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
