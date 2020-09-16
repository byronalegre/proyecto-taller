@extends ('admin.master')

@section ('title','Tareas')

@section('breadcrumb')
<li class="breadcrumb-item">
	<a href="{{url('/admin/tareas/all') }}"><i class="fas fa-tasks"></i> Tareas</a>
</li>
@endsection
@section('content')

<div class="container-fluid">
	<div class="panel shadow">
		<div class="header">
			<h2 class="title"><i class="fas fa-tasks"></i> Tareas</h2>
		</div>
		<div class="inside">

				<div class="nav justify-content-end">				
					
					<div class="dropdown">
						  <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Filtrar </button>

						  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
						    <a class="dropdown-item" href="{{url('admin/tareas/all') }}">Todos</a>
						    <a class="dropdown-item" href="{{url('admin/tareas/1') }}">Completadas</a>
						    <a class="dropdown-item" href="{{url('admin/tareas/0') }}">Pendientes</a>
						    <a class="dropdown-item" href="{{url('admin/tareas/trash') }}">Papelera</a>
						  </div>
					</div>

				</div>	

			@if(kvfj(Auth::user()->permisos, 'tareas_agregar'))
			<a href="{{url('admin/tareas/agregar') }}" class="btn btn-success btn-sm">
			<i class="fas fa-plus-circle"></i> Nueva tarea
			</a>
			@endif

			<table class="table table-striped mtop16">
				<thead class="table-dark">
					<td style="text-align: center;">Código</td>
					<td style="text-align: center;">Tarea</td>					
					<td style="text-align: center;">Fecha solicitud</td>
					<td style="text-align: center;">Fecha programada</td>
					<td style="text-align: center;">Estado</td>
					<td width="110"></td>
				</thead>
				<tbody>
					@foreach($input as $i)
					<tr>
						<td style="text-align: center;">CNRO-{{ $i->codigo }} </td>						
						<td style="text-align: center;">{{ $i->work->name }} </td>
						<td style="text-align: center;">{{ $i->created_at->format('d/m/Y (H:i)') }} </td>
						<td style="text-align: center;">{{ date('d/m/Y',strtotime($i->fecha_prog))}} </td>
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
						</td>
						<td>
							@if(kvfj(Auth::user()->permisos, 'tarea_detalle'))
								@if(is_null($i->deleted_at))
									<a href="{{url('admin/tareas/'.$i->id.'/detalle') }}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Detalle">
										<i class="fas fa-info-circle"></i>
									</a>				
								@endif			
							@endif
							@if(kvfj(Auth::user()->permisos, 'tareas_eliminar'))
								@if(is_null($i->deleted_at))
									<a href="#" data-path="admin/tareas" data-action="delete" data-object="{{ $i->id }}" data-toggle="tooltip" data-placement="top" title="Anular" class="btn btn-danger btn-sm btn-deleted">
									<i class="fas fa-trash"></i>
									</a> 
								@else
									<a href="{{ url('/admin/tareas/'.$i->id.'/restore') }}" data-action="restore" data-path="admin/tareas" data-object="{{ $i->id }}" data-toggle="tooltip" data-placement="top" title="Restaurar" class="btn btn-success btn-sm btn-deleted">
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
