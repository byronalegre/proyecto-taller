<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Detalle de tarea - {{$t->codigo}} </title>
	
</head>
	<body>
		
		<header>	
			<table width="100%" style="border: 2px solid black;border-bottom: 0px ">
				<tr>
					<td style="border-right: 2px solid black "><img style="width: 250px;" src="{{url('/static/images/logo.png')}}"></td>
					<td>
						<h2 style="font-size: 20px; text-align: center; font-family: courier;">	
							Orden de trabajo 
							<br> 
							ODT-{{$t->codigo}}<br>
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
						<a>ODT-{{$t->codigo}}</a>
					</td>
					<td>
						<b>TAREA:</b>
						<a>{{$t->work->name}}</a>
					</td>	
									
				</tr>
				<tr>
					<td>
						<b>FECHA DE SOLICITUD:</b>
						<a>{{$t->created_at->format('d/m/Y')}}</a>
					</td>
					<td>
						<b>FECHA PROGRAMADA</b>
						<a>{{date('d/m/Y',strtotime($t->fecha_prog))}}</a>
					</td>					
				</tr>
				
			</table>

			<table style=" width: 100%; text-align: center; border: 2px solid black; border-top: 0px">
				<tr style="background-color: #c0c0c0; font-weight: bold;">
					<td>PRODUCTO</td>
                    <td>CANTIDAD</td>
				</tr>
				<tbody style="font-family: courier; background: #D7D7D7; border-top: 1px solid black;">
					
						@foreach($a as $value)
						<tr>
						<td>{{$value['producto']}}</td>
						<td>{{$value['cantidad']}}</td>					
						@endforeach						
				</tbody> 				
	</body>
</html>