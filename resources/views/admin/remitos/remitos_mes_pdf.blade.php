<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Remitos</title>
	
</head>
	<body>
				<header><img style="width: 250px" src="{{url('/static/images/logo.png')}}"><p style="font-family: Tahoma, sans-serif; font-weight: 1px; font-size: 10px;">
					Teléfono: {{config('settings.telefono')}}
					<br>
					Dirección: {{config('settings.direccion')}}
				</p></header>
			
				<h2 style="font-size: 25px; text-align: center; font-family: courier;"></i> 
				Reporte de remitos del mes 
					@switch(date('n', strtotime(now())))
						@case(1) Enero
						@break
						@case(2) Febrero
						@break
						@case(3) Marzo
						@break
						@case(4) Abril
						@break
						@case(5) Mayo
						@break
						@case(6) Junio
						@break
						@case(7) Julio
						@break
						@case(8) Agosto
						@break
						@case(9) Septiembre
						@break
						@case(10) Octubre
						@break
						@case(11) Noviembre
						@break
						@case(12) Diciembre
						@break
					@endswitch
				</h2>
				<div style="font-family: Tahoma, sans-serif; font-size: 10px;">Cantidad de items: {{ count($r->all()) }}
				</div>
				<table style="font-family: Tahoma, sans-serif; width: 100%; border: 1px solid black;">
					<tr style="color:black; font-weight: bold; border-bottom: 1px solid black; font-size: 12px">
					<td>Código</td>
					<td></td>
					<td>Orden de Compra</td>
					<td>Proveedor</td>											
					<td>Fecha registro</td>
					<td>Responsable</td>
					<td style="text-align: right;">Importe total ($)</td>
					</tr>
					<tbody style="font-size: 12px; border-top: 1px solid black;">
						@foreach($r as $item)
							<tr>
								<td>{{ $item->codigo }} </td>	
								<td>»</td>
								<td>{{ $item->orden->codigo }} </td><!--mirar esto-->
								<td>{{ $item->provs->name }} </td>																		
								<td>{{ $item->created_at->format('d/m/Y') }} </td>	
								<td>{{ $item->user->name.' '.$item->user->lastname }} </td>		
								<td style="text-align: right;">{{ $item->importe_total }} </td>
							</tr>
							{{$acum+=$item->importe_total}}
						@endforeach										
					</tbody>
					<tfoot style="font-size: 14px; background-color: #c0c0c0;">
						<tr>	
		           			</td>
		           			<td>Total:</td>
		            		<td colspan="5"></td>					
							<td style="text-align: right;"><b>${{number_format($acum, 2)}}</b></td>
		           		</tr>
					</tfoot>

				</table>
						
				<div style="text-align: right; font-family: Tahoma, sans-serif; font-size: 10px;">Fecha: {{date("d-m-Y ", time()) }}
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
