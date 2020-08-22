<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Proveedores</title>
	
</head>
	<body>
				<header><img style="width: 250px" src="{{url('/static/images/logo.png')}}"></header>
			
				<h2 style="font-size: 25px; text-align: center; font-family: courier; border: 2px solid black"></i> 
				Reporte de proveedores
				</h2>
				<div>Items: {{ count($provs->all()) }}
				</div>
				<table style=" width: 100%; text-align: center; border: 1px solid black;">
					<tr style="color:black; font-weight: bold; border-bottom: 1px solid black;">
					<td>CUIT</td>
					<td>Nombre</td>					
					<td>Dirección</td>
					<td>Teléfono</td>
					</tr>
					<tbody style=" font-family: courier; background: #D7D7D7; border-top: 1px solid black;">
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
						
				<div style="text-align: right">Fecha: {{date("d-m-Y ", time()) }}
				</div>
	</body>
</html>
