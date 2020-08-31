<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Piezas</title>
	
</head>
	<body>
				<header><img style="width: 250px" src="{{url('/static/images/logo.png')}}"></header>
			
				<h2 style="font-size: 25px; text-align: center; font-family: courier; border: 2px solid black"></i> 
				Reporte de piezas
				</h2>
				<div>Items: {{ count($piezas->all()) }}
				</div>
				<table style=" width: 100%; text-align: center; border: 1px solid black;">
					<tr style="color:black; font-weight: bold; border-bottom: 1px solid black;">
						<td>Código</td>
						<td>Nombre</td>		
						<td>Marca</td>						
						<td>Categoría</td>
						<td>Mínimo</td>
						<td>Cantidad</td>
						<td>Ubicación</td>
					</tr>
					<tbody style=" font-family: courier; font-size: 14px; background: #D7D7D7; border-top: 1px solid black;">
						@foreach($piezas as $p)
							<tr>
								<td>{{ $p->codigo }}</td>
								<td>{{ $p->name }}</td>
								<td>{{ $p->mark->name }}</td>										
								<td>{{ $p->cat->name }}</td>
								<td>{{ $p->cantidad_min }}</td>
								<td>{{ $p->cantidad }}</td>
								<td>{{ getLocalArray($p->ubicacion) }}</td>
							</tr>
						@endforeach	
					</tbody>
				</table>
						
				<div style="text-align: right">Fecha: {{date("d-m-Y ", time()) }}
				</div>
	</body>
</html>