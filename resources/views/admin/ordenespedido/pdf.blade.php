<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Detalle de pedido - {{$op->codigo}} </title>
	
</head>
	<body>
		
		<header>	
			<table width="100%" style="border: 2px solid black;border-bottom: 0px ">
				<tr>
					<td style="border-right: 2px solid black"><img style="width: 250px;" src="{{url('/static/images/logo.png')}}"></td>
					<td>
						<h2 style="font-size: 20px; text-align: center; font-family: courier;">	
							Orden de pedido
							<br> 
							ODP-{{$op->codigo}}<br>
							{{date("d/m/Y ", time()) }}
						</h2>
					</td>
				</tr>	
				
			</table>
			
		</header>

			<table width="100%" style="border: 2px solid black;">
				<tr>
					<td>
						<b>NRO DE ORDEN:</b>
						<a>ODP-{{$op->codigo}}</a>
					</td>									
				</tr>
				<tr>
					<td>
						<b>FECHA DE PEDIDO:</b>
						<a>{{$op->created_at->format('d/m/Y')}}</a>
					</td>					
				</tr>
				<tr>
					<td>
						<b>RESPONSABLE:</b>
						<a>{{substr($op->responsable,4)}}</a>
					</td>
				</tr>
				
			</table>

			<table style=" width: 100%; text-align: center; border: 2px solid black; border-top: 0px">
				<tr style="background-color: #c0c0c0; font-weight: bold;">
					<td>PRODUCTO</td>
                    <td>CANTIDAD</td>
				</tr>
				<tbody style="font-family: courier; border-top: 1px solid black;">
					
						@foreach($a as $value)
						<tr>
						<td>{{$value['producto']}}</td>
						<td>{{$value['cantidad']}}</td>						
						@endforeach						
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
</html>