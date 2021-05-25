@extends ('admin.master')

@section ('title','Historial de cambios')

@section('breadcrumb')
<li class="breadcrumb-item">
	<a href="{{url('/admin/piezas/1') }}"><i class="fas fa-cog"></i> Piezas</a>
</li>
<li class="breadcrumb-item">
	<a href="{{url('/admin/piezas/'.$id.'/detalle') }}"><i class="fas fa-info-circle"></i> Detalle pieza </a>
</li>
<li class="breadcrumb-item">
	<a href="{{url('/admin/piezas/'.$id.'/detalle/historia_cambio') }}"><i class="fas fa-history"></i> Historial de cambios</a>
</li>
@endsection

@section('content')

<div class="container-fluid">
	@if($log->total() != 0)
		<div class="panel shadow">
				<div class="header">
					<h2 class="title"><i class="fas fa-history"></i> Historial de cambios</h2>
				</div>										
				<div class="inside">	
					<div class="row mb-2">
						<div class="col-sm-3">
							<form>
								<div class="input-group input-group-sm">
									<span class="input-group-text" id="basic-addon1">Mostrar</span>
									<input name="paginate" type="number" class="form-control" aria-describedby="basic-addon1" placeholder="{{session('paginate')}} elementos" min="1" >
								</div>
							</form>
						</div>	
					</div>			
					<table style="text-align: center;" class="table table-hover" id="Datatable">
						<thead class="table-dark">			
							<td>Responsable</td>
							<td>Fecha Edición</td>
							<td></td>
						</thead>
						<tbody>
							@foreach($log as $l)
								<tr>
									<td>{{ $l->user->name.' '.$l->user->lastname }}</td>							
									<td>{{ $l->created_at->format('d/m/Y') }}</td>
									<td>
										@if(kvfj(Auth::user()->permisos, 'historia_detalle'))
											@if(is_null($l->deleted_at))
												<a href="{{url('admin/piezas/'.$id.'/detalle/historia_cambio/'.$l->id.'/detalle') }}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Detalle">
													<i class="fas fa-info-circle"></i>
												</a>				
											@endif			
										@endif
									</td>
								</tr>
							@endforeach								
						</tbody>
					</table>
				{{$log->links()}}
				<p class="mtop16">
					Mostrando {{$log->count()}} de {{ $log->total() }} elemento(s).
				</p>
			</div>
		</div>
	@else
		<div class="panel shadow mtop16">
			<div class="header">
				<h2 class="title"><i class="fas fa-chart-line"></i> Gráfico de línea</h2>
			</div>
			
			<div class="inside">
				<div class="alert alert-dark" style="text-align: center;">
					No existe información sobre cambios.
				</div>
			</div>
		</div>
	@endif
</div>
@endsection

