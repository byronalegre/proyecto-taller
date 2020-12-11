@extends ('admin.master')

@section ('title','Ordenes de pedido')

@section('breadcrumb')
<li class="breadcrumb-item">
	<a href="{{url('/admin/ordenespedido/all') }}"><i class="fas fa-file-invoice"></i> Ordenes de Pedido</a>
</li>
<li class="breadcrumb-item">
	<a href="{{url('/admin/ordenespedido/'.$op->id.'/detalle') }}"><i class="fas fa-info-circle"></i> Detalle Orden de Pedido: {{$op->codigo}}</a>
</li>

@endsection

@section('content')

<div class="container-fluid" oncontextmenu="return false"><!-- ONCONTEXTMENU DESACTIVA F12-->
	<div class="panel shadow">
		<div class="header">
			<h2 class="title"><i class="fas fa-info-circle"></i> Detalle</h2>
		</div>
		<div class="inside">

			<div style="text-align: right">
				@if($op->status != '1')		
					@if(kvfj(Auth::user()->permisos, 'pedidos_editar'))
						<a class="btn btn-primary btn-sm" href="{{url('admin/ordenespedido/'.$op->id.'/edit') }}"data-toggle="tooltip" data-placement="top" title="Editar">
						<i class="fas fa-edit"></i>
						</a>
					@endif
				@endif
				@if(kvfj(Auth::user()->permisos, 'detalle_pedido_pdf'))
					<a href="{{url('admin/ordenespedido/'.$op->id.'/detalle/ordenpedido_pdf')}}" data-toggle="tooltip" data-placement="top" title="Generar PDF" class="btn btn-danger btn-sm" target="_blank">
						<i class="far fa-file-pdf"></i>
						PDF
					</a>
				@endif
			</div>
			
			<div class="mtop16">
				<b>CODIGO:</b>
				<a>ODP-{{$op->codigo}}</a>
			</div>

			<div>
				<b>RESPONSABLE:</b>
				<a>{{substr($op->responsable,4)}}</a>
			</div>

			<div>
				<b>FECHA:</b>
				<a>{{$op->created_at->format('d/m/Y')}}</a>
			</div>

			@if($op->status == '0')
				<div class="progress mtop16">
				  <div class="progress-bar progress-bar-striped bg-warning" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" data-placement="top" title="Pendiente">				  	
				  </div>
				</div>
			@endif
			@if($op->status == '1')
				<div class="progress mtop16">
				  <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" data-placement="top" title="Completada">				  	
				  </div>
				</div>
			@endif
			@if($op->status == '2')
				<div class="progress mtop16">
				  <div class="progress-bar progress-bar-striped bg-danger" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" data-placement="top" title="Rechazada">				  	
				  </div>
				</div>
			@endif

			<table class="table mtop16">
                <thead class="table-dark">                	
                    <tr>
	                    <td>PRODUCTO</td>
	                    <td>CANTIDAD</td>
                    </tr>
                </thead>
                <tbody >
                	@foreach($a as $value)
							<tr>
							<td>{{$value['producto']}}</td>
							<td>{{$value['cantidad']}}</td>
							</tr>
					@endforeach
                </tbody>
                
            </table>
		</div>
	</div>
</div>
@endsection
