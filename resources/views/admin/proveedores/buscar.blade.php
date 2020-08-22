@extends ('admin.master')

@section ('title','Proveedores')

@section('breadcrumb')
<li class="breadcrumb-item">
	<a href="{{url('/admin/proveedores/all') }}"><i class="fas fa-truck"></i> Proveedores</a>
</li>
@endsection

@section('content')

<div class="container-fluid">
	<div class="panel shadow">
		<div class="header">
			<h2 class="title"><i class="fas fa-truck"></i> Proveedores</h2>
		</div>
		
		<div class="inside">
			<div class="nav justify-content-end">
						@if(kvfj(Auth::user()->permisos, 'proveedores_buscar'))
						<div class="form-inline">
					
							{!! Form::open(['url' => '/admin/proveedores/buscar']) !!}
							
							<div class="row">
								<div style="padding: 0px" class="col-md-5">
									{!! Form::text('buscar', null, ['class' => 'form-control form-control-sm','placeholder' => 'Ingrese su búsqueda']) !!}
								</div>	
								<div class="col-md-4">
									{!! Form::select('filtro',['0'=>'ID','1'=>'Nombre','2'=>'CUIT','3'=>'Dirección','4'=>'Teléfono'], 0,['class'=>'form-select form-select-sm']) !!}
								</div>
								<div style="padding: 0px" class="col-md-2">
									{!! Form::submit('Buscar', ['class'=> 'btn btn-outline-dark btn-sm']) !!}
								</div>
							</div>
							{!! Form::close() !!}
						
						</div>
						@endif
		
							
						
						<div class="dropdown">
							  <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Filtrar </button>

							  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
							    <a class="dropdown-item" href="{{url('admin/proveedores/all') }}">Todos</a>
							    <a class="dropdown-item" href="{{url('admin/proveedores/trash') }}">Papelera</a>

							  </div>
						</div>
		</div>	

			<div class="btns">
				@if(kvfj(Auth::user()->permisos, 'proveedores_agregar'))
					<a href="{{url('admin/proveedores/agregar') }}" class="btn btn-success btn-sm">
						<i class="fas fa-plus-circle"></i> Agregar proveedor
					</a>
				@endif
				@if(kvfj(Auth::user()->permisos, 'proveedores_pdf'))
					<a data-toggle="tooltip" data-placement="top" title="Generar PDF" href="{{ route('proveedores_pdf') }}" class="btn btn-sm btn-danger">
	           			<i data-toggle="tooltip" data-placement="top" title="Generar PDF" class="far fa-file-pdf"></i>
	       			</a>
	       		@endif
			</div>

			<table class="table table-striped mtop16">
				<thead class="table-dark">
					<td>ID</td>
					<td>Nombre</td>
					<td>CUIT</td>
					<td>Dirección</td>
					<td>Teléfono</td>
					<td>Correo Electrónico</td>
					<td width="110"></td>
				</thead>
				<tbody>
					
					@foreach($provs as $p)
					<tr>
						<td>{{ $p->id }} </td>
						<td>{{ $p->name }} </td>
						<td>{{ $p->cuit }} </td>
						<td>{{ $p->direccion }} </td>
						<td>{{ $p->telefono }} </td>
						<td>{{ $p->correo }} </td>
						<td>
							@if(kvfj(Auth::user()->permisos, 'proveedores_editar'))
								@if(is_null($p->deleted_at))
									<a class="btn btn-primary btn-sm" href="{{url('admin/proveedores/'.$p->id.'/edit') }}"data-toggle="tooltip" data-path="admin/piezas" data-action="delete" data-object="{{ $p->id }}" data-placement="top" title="Editar">
									<i class="fas fa-edit"></i>
									</a>
								@endif
							@endif
								
							@if(kvfj(Auth::user()->permisos, 'proveedores_eliminar'))
								@if(is_null($p->deleted_at))
									<a href="#" data-path="admin/proveedores" data-action="delete" data-object="{{ $p->id }}" data-toggle="tooltip" data-placement="top" title="Eliminar" class="btn btn-danger btn-sm btn-deleted">
									<i class="fas fa-trash"></i>
									</a> 
								@else
									<a href="{{ url('/admin/proveedores/'.$p->id.'/restore') }}" data-action="restore" data-path="admin/proveedores" data-object="{{ $p->id }}" data-toggle="tooltip" data-placement="top" title="Restaurar" class="btn btn-success btn-sm btn-deleted">
									<i class="fas fa-trash-restore"></i>
									</a> 
								@endif
							@endif
						</td>
					</tr>

					@endforeach
						
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection
