@extends ('admin.master')

@section ('title','Compras')

@section('breadcrumb')
<li class="breadcrumb-item">
	<a href="{{url('/admin/compras') }}"><i class="fas fa-cart-plus"></i> Compras</a>
</li>
<li class="breadcrumb-item">
	<a href="{{url('/admin/compras') }}"><i class="fas fa-info-circle"></i> Detalle compra: {{$c->codigo}}</a>
</li>

@endsection

@section('content')

<div class="container-fluid">
	<div class="panel shadow">
		<div class="header">
			<h2 class="title"><i class="fas fa-info-circle"></i> Detalle</h2>
		</div>
		<div class="inside">

			<div style="text-align: right">
			@if(kvfj(Auth::user()->permisos, 'detalle_pdf'))
				<a href="{{url('admin/compras/'.$c->id.'/detalle/compra_pdf')}}" data-toggle="tooltip" data-placement="top" title="Generar PDF" class="btn btn-danger btn-sm">
					PDF <i class="far fa-file-pdf"></i>
				</a>
			@endif
			</div>
			
			<div class="mtop16">
				<b>FECHA:</b>
				<a>{{$c->created_at->format('d/m/Y')}}</a>
			</div>
			<div>
				<b>CODIGO:</b>
				<a>{{$c->codigo}}</a>
			</div>
			<div>
				<b>PROVEEDOR:</b>
				<a>{{$c->provs->name}}</a>
			</div>

			<table class="table mtop16">
                <thead class="table-dark">                	
                    <tr>
	                    <td>PRODUCTO</td>
	                    <td>CANTIDAD</td>
	                    <td>PRECIO UNITARIO</td>
	                    <td>IMPORTE</td>
                    </tr>
                </thead>
                <tbody >
                	@foreach($a as $value)
							<tr>
							<td>{{$value['producto']}}</td>
							<td>{{$value['cantidad']}}</td>
							<td>${{$value['precio']}}</td>
							<td>${{$value['cantidad']*$value['precio']}}</td>
							<td hidden="true">{{$acum += ($value['cantidad']*$value['precio']) }}</td>
							</tr>
					@endforeach
                </tbody>
                <tfoot class="table-danger">
            		<td>Total:</td>
            		<td colspan="2"></td>					
					<td class="table-active"><b>${{$acum}}</b></td>
           		</tfoot>
            </table>
		</div>
	</div>
</div>
@endsection
