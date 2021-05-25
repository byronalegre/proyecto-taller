<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Tareas</title>
	
</head>
	<body>
				<header><img style="width: 250px" src="{{url('/static/images/logo.png')}}"><p style="font-family: Tahoma, sans-serif; font-weight: 1px; font-size: 10px;">
					Teléfono: {{config('settings.telefono')}}
					<br>
					Dirección: {{config('settings.direccion')}}
				</p></header>
			
				<h2 style="font-size: 25px; text-align: center; font-family: courier;"></i> 
				Reporte de Tareas  del mes
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
				<div style="font-family: Tahoma, sans-serif; font-size: 10px;">Cantidad de items: {{ count($ot->all()) }}
				</div>
				<table style="font-family: Tahoma, sans-serif; width: 100%; border: 1px solid black;">
					<tr style="color:black; font-weight: bold; border-bottom: 1px solid black; font-size: 12px">
					<td>Código</td>
					<td>Tarea</td>					
					<td>Fecha solicitud</td>
					<td>Fecha programada</td>
					</tr>
					<tbody style="font-size: 12px; border-top: 1px solid black;">
						@foreach($ot as $i)
							<tr>
								<td>{{ $i->codigo }} </td>						
								<td>{{ $i->work->name }} </td>
								<td>{{ $i->created_at->format('d/m/Y (H:i)') }} </td>
								<td>{{ date('d/m/Y',strtotime($i->fecha_prog))}} </td>
							</tr>
						@endforeach	
					</tbody>
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
