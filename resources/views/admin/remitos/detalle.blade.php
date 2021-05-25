@extends ('admin.master')

@section ('title','Remitos')

@section('breadcrumb')
<li class="breadcrumb-item">
	<a href="{{url('/admin/remitos/all') }}"><i class="fas fa-file-invoice-dollar"></i> Remitos</a>
</li>
<li class="breadcrumb-item">
	<a href="{{url('/admin/remitos/'.$r->id.'/detalle') }}"><i class="fas fa-info-circle"></i> Detalle remito: {{$r->codigo}}</a>
</li>

@endsection

@section('content')

<div class="container-fluid" oncontextmenu="return false"><!-- ONCONTEXTMENU DESACTIVA F12-->
	<div class="panel shadow">
		<div class="header">
			<h2 class="title"><i class="fas fa-info-circle"></i> Detalle</h2>
		</div>
		<div class="inside">
			<div class="card text-center">

			  <div class="card-header">
			    <div>
					<b>CODIGO REMITO:</b>
					<a>{{$r->codigo}}</a>
				</div>
			  </div>

			  <div class="card-body">
			  	<div style="text-align: right">
				@if(kvfj(Auth::user()->permisos, 'detalle_remito_pdf'))
					<a href="{{url('admin/remitos/'.$r->id.'/detalle/remito_pdf')}}" data-toggle="tooltip" data-placement="top" title="Generar PDF" class="btn btn-danger btn-sm" target="_blank">
						<i class="far fa-file-pdf"></i>
						PDF
					</a>
				@endif
				</div>

			    <h5 class="card-title">
			    	<div>
						<b>CORRESPONDE A ORDEN DE COMPRA:</b>
						<a> {{$r->orden->codigo}} </a> 
					</div>
				</h5>

			    <p class="card-text">		
			    	<div>
						<b>PROVEEDOR:</b>
						<a>{{$r->provs->name}}</a>
					</div>    	
			    	<div>
						<b>RESPONSABLE:</b>
						<a>{{ $r->user->name.' '.$r->user->lastname }}</a>
					</div>			

					<div>
						<b>FECHA:</b>
						<a>{{$r->created_at->format('d/m/Y')}}</a>
					</div>

					<div>
						<b>DESCRIPCIÓN:</b>
						<a>{{$r->descripcion}}</a>
					</div>					
			    </p>			    
			  </div>
			  
			  <div class="card-footer text-muted p-0">
			    <table class="table m-0">
	                <thead class="table-dark">                	
	                    <tr>
		                    <td>PRODUCTO</td>
		                    <td>CANTIDAD</td>
		                    <td>PRECIO UNITARIO</td>
		                    <td>IMPORTE</td>
	                    </tr>
	                </thead>
	                <tbody>
	                	@foreach($r->detalle as $dd)
	                	<tr>	                		
	                		<td> {{$dd->prods[0]->name}}</td>	                		
	                		<td> {{$dd->cantidad_req}} </td>
	                		<td> ${{$dd->precio}} </td>
	                		<td> ${{number_format($dd->cantidad_req * $dd->precio, 2)}} </td>
	                		<td hidden="true">{{$acum += ($dd->cantidad_req * $dd->precio) }}</td>
	                	</tr>
	                	@endforeach
	                </tbody>
	                <tfoot class="table-danger">
	            		<td>Total:</td>
	            		<td colspan="2"></td>					
						<td class="table-active"><b>${{number_format($acum,2)}}</b></td>
	           		</tfoot>
	            </table>
			  </div>
			</div>			
		</div>
	</div>
</div>
@endsection
