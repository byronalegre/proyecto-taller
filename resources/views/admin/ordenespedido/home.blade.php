@extends ('admin.master')

@section ('title','Ordenes de Pedido')

@section('breadcrumb')
<li class="breadcrumb-item">
	<a href="{{url('/admin/ordenespedido/all') }}"><i class="fas fa-file-invoice"></i> Ordenes de Pedido</a>
</li>
@endsection

@section('content')

<div class="container-fluid">
	<div class="panel shadow">
		<div class="header">
			<h2 class="title"><i class="fas fa-cart-plus"></i> Ordenes de Pedido</h2>
		</div>
		<div class="inside">

				<div class="nav justify-content-end">				
					
					<div class="dropdown">
						  <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Filtrar </button>

						  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
						    <a class="dropdown-item" href="{{url('admin/ordenespedido/all') }}"><i class="fas fa-list"></i> Todos</a>
						    <a class="dropdown-item" href="{{url('admin/ordenespedido/0') }}"><i class="fas fa-clock"></i> Pendientes</a>
						    <a class="dropdown-item" href="{{url('admin/ordenespedido/1') }}"><i class="fas fa-check-double"></i> Completadas</a>
						    <a class="dropdown-item" href="{{url('admin/ordenespedido/2') }}"><i class="fas fa-times"></i> Rechazadas</a>
						    <a class="dropdown-item" href="{{url('admin/ordenespedido/trash') }}"><i class="fas fa-trash-alt"></i> Papelera</a>
						  </div>
					</div>

				</div>	

			@if(kvfj(Auth::user()->permisos, 'pedidos_agregar'))
			<a href="{{url('admin/ordenespedido/agregar') }}" class="btn btn-success btn-sm">
			<i class="fas fa-plus-circle"></i> Nueva orden
			</a>
			@endif

			<table class="table table-hover mtop16">
				<thead class="table-dark">
					<td style="text-align: center;">Código</td>
					<td style="text-align: center;">Responsable</td>				
					<td style="text-align: center;">Fecha registro</td>
					<td style="text-align: center;">Estado</td>
					<td></td>
					<td width="90"></td>
				</thead>
				<tbody>
					@foreach($input as $i)
					<tr>
						<td style="text-align: center;">ODP-{{ $i->codigo }} </td>	
						<td style="text-align: center;">{{substr($i->responsable,4)}} </td>
						<td style="text-align: center;">{{ $i->created_at->format('d/m/Y (H:i)') }} </td>
						<td style="text-align: center;" width="150"> 
							@if($i->status == '0')
							<div class="progress">
							  <div class="progress-bar progress-bar-striped bg-warning" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" data-placement="top" title="Pendiente"></div>
							</div>
							@endif							
							@if($i->status == '1')
							<div class="progress">
							  <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" data-placement="top" title="Completada"></div>
							</div>
							@endif
							@if($i->status == '2')
							<div class="progress">
							  <div class="progress-bar progress-bar-striped bg-danger" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" data-placement="top" title="Rechazadas"></div>
							</div>
							@endif
						</td>

						<td style="text-align: center;">
							<i class="far fa-comment-dots fa-2x" data-toggle="tooltip" data-placement="top" title="{{$i->descripcion}}"></i>
						</td>						

						<td>
							@if(kvfj(Auth::user()->permisos, 'pedido_detalle'))
								@if(is_null($i->deleted_at))
									<a href="{{url('admin/ordenespedido/'.$i->id.'/detalle') }}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Detalle">
										<i class="fas fa-info-circle"></i>
									</a>				
								@endif			
							@endif
							@if(kvfj(Auth::user()->permisos, 'pedidos_eliminar'))
								@if(is_null($i->deleted_at))
									<a href="#" data-path="admin/ordenespedido" data-action="delete" data-object="{{ $i->id }}" data-toggle="tooltip" data-placement="top" title="Anular" class="btn btn-danger btn-sm btn-deleted">
									<i class="fas fa-trash-alt"></i>
									</a> 
								@else
									<a href="{{ url('/admin/ordenespedido/'.$i->id.'/restore') }}" data-action="restore" data-path="admin/ordenespedido" data-object="{{ $i->id }}" data-toggle="tooltip" data-placement="top" title="Restaurar" class="btn btn-success btn-sm btn-deleted">
									<i class="fas fa-trash-restore"></i>
									</a> 
								@endif
							@endif	
											
						</td>
					</tr>
					@endforeach					
					<tr>
						<td colspan="7"> {!! $input->render() !!}</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection
