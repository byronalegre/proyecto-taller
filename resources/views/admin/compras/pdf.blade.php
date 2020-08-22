<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Detalle de compra - {{$c->codigo}} </title>
	
</head>
	<body>
		
		<header><img style="width: 250px" src="{{url('/static/images/logo.png')}}"></header>
			
		<h2 style="font-size: 25px; text-align: center; font-family: courier; border: 2px solid black"></i> 
		Orden de compra <br> {{$c->codigo}}<br>{{$c->provs->name}}<br> 
		</h2>
			<div style="text-align: right">{{date("d/m/Y ", time()) }}
			</div>
			<div>
				<b>NRO DE ORDEN:</b>
				<a>{{$c->codigo}}</a>
			</div>
			<div>
				<b>FECHA DE COMPRA:</b>
				<a>{{$c->created_at->format('d/m/Y')}}</a>
			</div>
			<div>
				<b>PROVEEDOR:</b>
				<a>{{$c->provs->name}}</a>
			</div>				
				<table style=" width: 100%; text-align: center; border: 1px solid black; margin-top: 16px">
					<tr style="background-color: #c0c0c0; font-weight: bold; border-bottom: 1px solid black;">
						<td>PRODUCTO</td>
	                    <td>CANTIDAD</td>
	                    <td>PRECIO UNITARIO</td>
	                    <td>IMPORTE</td>
					</tr>
					<tbody style="font-family: courier; background: #D7D7D7; border-top: 1px solid black;">
						
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
					
                	<tfoot style="background-color: #c0c0c0">
                		<td>Total:</td>
                		<td colspan="2"></td>					
						<td>${{$acum}}</td>
               		</tfoot>
               		
				</table>				
	</body>
</html>