<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Detalle de remito - {{$c->codigo}} </title>
	
</head>
	<body>
		
		<header>	
			<table width="100%" style="border: 2px solid black;border-bottom: 0px ">
				<tr>
					<td style="border-right: 2px solid black"><img style="width: 250px;" src="{{url('/static/images/logo.png')}}"></td>
					<td>
						<h2 style="font-size: 20px; text-align: center; font-family: courier;">	
							Remito de compra 
							<br> 
							RC-{{$c->codigo}}<br>
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
						<a>ODC-{{$c->codigo}}</a>
					</td>
					<td>
						<b>PROVEEDOR:</b>
						<a>{{$c->provs->name}}</a>
					</td>	
									
				</tr>
				<tr>
					<td>
						<b>FECHA DE COMPRA:</b>
						<a>{{$c->created_at->format('d/m/Y')}}</a>
					</td>
					<td>
						<b>C.U.I.T:</b>
						<a>{{$c->provs->cuit}}</a>
					</td>					
				</tr>
				<tr>
					<td>
						<b>RESPONSABLE:</b>
						<a>{{substr($c->responsable,4)}}</a>
					</td>
					<td>
						<b>DOMICILIO:</b>
						<a>{{$c->provs->direccion}}</a>
					</td>
				</tr>
				
			</table>

			<table style=" width: 100%; text-align: center; border: 2px solid black; border-top: 0px">
				<tr style="background-color: #c0c0c0; font-weight: bold;">
					<td>PRODUCTO</td>
                    <td>CANTIDAD</td>
                    <td>PRECIO UNITARIO</td>
                    <td>IMPORTE</td>
				</tr>
				<tbody style="font-family: courier; border-top: 1px solid black;">
					
						@foreach($a as $value)
						<tr>
						<td>{{$value['producto']}}</td>
						<td>{{$value['cantidad']}}</td>
						<td>${{$value['precio']}}</td>
						<td>${{$value['cantidad']*$value['precio']}}</td>							
						</tr>
						{{$acum += ($value['cantidad']*$value['precio']) }}							
						@endforeach						
				</tbody> 
				<tfoot style="background-color: #c0c0c0;">
					<tr>	
	           			</td>
	           			<td>Total:</td>
	            		<td colspan="2"></td>					
						<td><b>${{$acum}}</b></td>
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
</html>