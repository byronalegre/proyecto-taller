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
						{!! Form::open(['url' => '/admin/proveedores/buscar']) !!}
							<div class="input-group mb-3">
								  {!! Form::text('buscar', null, ['class' => 'form-control form-control-sm','placeholder' => 'Buscar por']) !!}
								  {!! Form::select('filtro',['0'=>'ID','1'=>'Nombre','2'=>'CUIT','3'=>'Dirección','4'=>'Teléfono'], 0,['class'=>'form-select form-select-sm']) !!}
								  {!! Form::submit('Buscar', ['class'=> 'btn btn-outline-dark btn-sm']) !!}
							</div>
						{!! Form::close() !!}
					@endif	
							
					<div class="dropdown pl-3">
						  <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Filtrar </button>

						  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
						    <a class="dropdown-item" href="{{url('admin/proveedores/all') }}"><i class="fas fa-list"></i> Todos</a>
						    <a class="dropdown-item" href="{{url('admin/proveedores/trash') }}"><i class="fas fa-trash-alt"></i> Papelera</a>

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
				<a data-toggle="tooltip" data-placement="top" title="Generar PDF" href="{{ route('proveedores_pdf') }}" class="btn btn-sm btn-danger" target="_blank">
           			<i data-toggle="tooltip" data-placement="top" title="Generar PDF" class="far fa-file-pdf"></i>
           			PDF 
       			</a>
       		@endif
		</div>

			<table class="table table-hover mtop16">
				<thead class="table-dark">
					<td>ID</td>
					<td>Nombre</td>
					<td>CUIT</td>
					<td>Dirección</td>
					<td>Teléfono</td>
					<td>Correo Electrónico</td>
					<td width="90"></td>
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
											<i class="fas fa-trash-alt"></i>
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
					<tr>
						<td colspan="8"> {!! $provs->render() !!}</td>
					</tr>
						
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection
