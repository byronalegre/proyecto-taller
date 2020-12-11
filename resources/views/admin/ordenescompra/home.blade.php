@extends ('admin.master')

@section ('title','Ordenes de Compra')

@section('breadcrumb')
<li class="breadcrumb-item">
	<a href="{{url('/admin/ordenescompra/all') }}"><i class="fas fas fa-cart-plus"></i> Ordenes de Compra</a>
</li>
@endsection

@section('content')

<div class="container-fluid">
	<div class="panel shadow">
		<div class="header">
			<h2 class="title"><i class="fas fa-cart-plus"></i> Ordenes de Compra</h2>
		</div>
		<div class="inside">

				<div class="nav justify-content-end">				
					
					<div class="dropdown">
						  <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Filtrar </button>

						  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
						    <a class="dropdown-item" href="{{url('admin/ordenescompra/all') }}"><i class="fas fa-list"></i> Todos</a>
						    <a class="dropdown-item" href="{{url('admin/ordenescompra/0') }}"><i class="far fa-clock"></i> Pendientes</a>
						    <a class="dropdown-item" href="{{url('admin/ordenescompra/1') }}"><i class="fas fa-check"></i> Aprobadas</a>
						    <a class="dropdown-item" href="{{url('admin/ordenescompra/2') }}"><i class="fas fa-check-double"></i> Completadas</a>
						    <a class="dropdown-item" href="{{url('admin/ordenescompra/3') }}"><i class="fas fa-times"></i> Rechazadas</a>
						    <a class="dropdown-item" href="{{url('admin/ordenescompra/trash') }}"><i class="fas fa-trash-alt"></i> Papelera</a>
						  </div>
					</div>

				</div>	

			@if(kvfj(Auth::user()->permisos, 'compras_agregar'))
			<a href="{{url('admin/ordenescompra/agregar') }}" class="btn btn-success btn-sm">
			<i class="fas fa-plus-circle"></i> Nueva orden
			</a>
			@endif

			<table class="table table-hover mtop16">
				<thead class="table-dark">
					<td style="text-align: center;">Código</td>
					<td style="text-align: center;">Proveedor</td>	
					<td style="text-align: center;">Responsable</td>				
					<td style="text-align: center;">Fecha registro</td>
					<td style="text-align: center;">Estado</td>
					<td></td>
					<td width="90"></td>
				</thead>
				<tbody>
					@foreach($input as $i)
					<tr>
						<td style="text-align: center;">ODC-{{ $i->codigo }} </td>						
						<td style="text-align: center;">{{ $i->provs->name }} </td>
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
							  <div class="progress-bar progress-bar-striped bg-primary" role="progressbar" style="width: 75%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" data-placement="top" title="Aprobada"></div>
							</div>
							@endif
							@if($i->status == '2')
							<div class="progress">
							  <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" data-placement="top" title="Completada"></div>
							</div>
							@endif
							@if($i->status == '3')
							<div class="progress">
							  <div class="progress-bar progress-bar-striped bg-danger" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" data-placement="top" title="Rechazada"></div>
							</div>
							@endif
						</td>

						<td style="text-align: center;">
							<i class="far fa-comment-dots fa-2x" data-toggle="tooltip" data-placement="top" title="{{$i->descripcion}}"></i>
						</td>						

						<td>
							@if(kvfj(Auth::user()->permisos, 'compra_detalle'))
								@if(is_null($i->deleted_at))
									<a href="{{url('admin/ordenescompra/'.$i->id.'/detalle') }}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Detalle">
										<i class="fas fa-info-circle"></i>
									</a>				
								@endif			
							@endif
							@if(kvfj(Auth::user()->permisos, 'compras_eliminar'))
								@if(is_null($i->deleted_at))
									<a href="#" data-path="admin/ordenescompra" data-action="delete" data-object="{{ $i->id }}" data-toggle="tooltip" data-placement="top" title="Anular" class="btn btn-danger btn-sm btn-deleted">
									<i class="fas fa-trash-alt"></i>
									</a> 
								@else
									<a href="{{ url('/admin/ordenescompra/'.$i->id.'/restore') }}" data-action="restore" data-path="admin/ordenescompra" data-object="{{ $i->id }}" data-toggle="tooltip" data-placement="top" title="Restaurar" class="btn btn-success btn-sm btn-deleted">
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
