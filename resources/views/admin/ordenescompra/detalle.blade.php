@extends ('admin.master')

@section ('title','Ordenes de compra')

@section('breadcrumb')
<li class="breadcrumb-item">
	<a href="{{url('/admin/ordenescompra/all') }}"><i class="fas fa-cart-plus"></i> Ordenes de Compra</a>
</li>
<li class="breadcrumb-item">
	<a href="{{url('/admin/ordenescompra/'.$c->id.'/detalle') }}"><i class="fas fa-info-circle"></i> Detalle Orden de Compra: {{$c->codigo}}</a>
</li>

@endsection

@section('content')

<div class="container-fluid">
	<div class="panel shadow">
		<div class="header">
			<h2 class="title"><i class="fas fa-info-circle"></i> Detalle</h2>
		</div>
		<div class="inside">
			<div class="card text-center">
			  <div class="card-header">
			    <div>
					<b>CODIGO:</b>
					<a>{{$c->codigo}}</a>
				</div>
			  </div>

			  <div class="card-body">
			  	<div style="text-align: right">
					@if($c->status == '0')		
						@if(kvfj(Auth::user()->permisos, 'compras_editar'))
							<a class="btn btn-primary btn-sm" href="{{url('admin/ordenescompra/'.$c->id.'/edit') }}" data-toggle="tooltip" data-placement="top" title="Editar">
							<i class="fas fa-edit"></i>
							</a>
						@endif
						@if(kvfj(Auth::user()->permisos, 'remitos_agregar_directo'))
							@if(is_null($c->deleted_at))
								<a href=" {{ url('/admin/remitos/agregar/'.$c->id) }} " class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Generar Remito">
									<i class="fas fa-arrow-circle-right"></i>
								</a>				
							@endif	
						@endif	
					@endif
					@if(kvfj(Auth::user()->permisos, 'detalle_compra_pdf'))
						<a href="{{url('admin/ordenescompra/'.$c->id.'/detalle/ordencompra_pdf')}}" data-toggle="tooltip" data-placement="top" title="Generar PDF" class="btn btn-danger btn-sm" target="_blank">
							<i class="far fa-file-pdf"></i>
							PDF
						</a>
					@endif
				</div>
			    <h5 class="card-title">
			    	<div>
						<b>CORRESPONDE A ORDEN DE PEDIDO:</b>
						<a> {{$c->orden->codigo}} </a> 
					</div>			    	
			    </h5>
			    <p class="card-text">
			    	<div>
						<b>PROVEEDOR:</b>
						<a>{{$c->provs->name}}</a>
					</div>

			    	<div>
						<b>RESPONSABLE:</b>
						<a>{{$c->user->name.' '.$c->user->lastname}}</a>
					</div>

					<div>
						<b>FECHA:</b>
						<a>{{$c->created_at->format('d/m/Y')}}</a>
					</div>

					<div>
						<b>DESCRIPCIÓN:</b>
						<a>{{$c->descripcion}}</a>
					</div>
			    </p>
			  </div>
			  @if($c->status == '0')
					<div class="progress">
					  <div class="progress-bar progress-bar-striped bg-warning" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" data-placement="top" title="Pendiente">				  	
					  </div>
					</div>
				@endif
				@if($c->status == '1')
					<div class="progress">
					  <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" data-placement="top" title="Completada">				  	
					  </div>
					</div>
				@endif
				@if($c->status == '2')
					<div class="progress">
					  <div class="progress-bar progress-bar-striped bg-danger" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" data-placement="top" title="Rechazada">				  	
					  </div>
					</div>
				@endif

			  <div class="card-footer text-muted p-0">
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
		                	@foreach($c->detalle as $value)
									<tr>
									<td>{{$value->prods[0]->name}}</td>
									<td>{{$value['cantidad_req']}}</td>
									<td>${{$value['precio']}}</td>
									<td>${{$value['cantidad_req']*$value['precio']}}</td>
									<td hidden="true">{{$acum += ($value['cantidad_req']*$value['precio']) }}</td>
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
	</div>
</div>
@endsection
