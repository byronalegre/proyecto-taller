@extends ('admin.master')

@section ('title','Proveedores')

@section('breadcrumb')
<li class="breadcrumb-item">
	<a href="{{url('admin/proveedores/all') }}"><i class="fas fa-truck"></i> Proveedores</a>
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

				<form class="d-flex mx-2">
					<div class="input-group">
						<span class="input-group-text"><i class="fas fa-search"></i></span>
						<input name="search" type="text" class="form-control form-control-sm w-50" placeholder="Ingrese su búsqueda" aria-label="Ingrese su búsqueda" aria-describedby="button-addon2">
						<button class="btn btn-outline-dark btn-sm" type="submit" id="button-addon2">Buscar</button>
					</div>
				</form>
				@if(kvfj(Auth::user()->permisos, 'proveedores_ordenar'))
					<div class="dropdown mx-2">
						<button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"> Ordenar por </button>

						<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
						<li><h6 class="dropdown-header">Nombre</h6></li>
						<a class="dropdown-item" href="{{url('admin/proveedores/'.$status.'/name=asc') }}"><i class="fas fa-sort-amount-down-alt"></i> Ascendente</a>
						<a class="dropdown-item" href="{{url('admin/proveedores/'.$status.'/name=desc') }}"><i class="fas fa-sort-amount-down"></i> Descendente</a>
						<li><h6 class="dropdown-header">CUIT</h6></li>
						<a class="dropdown-item" href="{{url('admin/proveedores/'.$status.'/cuit=asc') }}"><i class="fas fa-sort-amount-down-alt"></i> Ascendente</a>
						<a class="dropdown-item" href="{{url('admin/proveedores/'.$status.'/cuit=desc') }}"><i class="fas fa-sort-amount-down"></i> Descendente</a>
						<li><h6 class="dropdown-header">Dirección</h6></li>
						<a class="dropdown-item" href="{{url('admin/proveedores/'.$status.'/direccion=asc') }}"><i class="fas fa-sort-amount-down-alt"></i> Ascendente</a>
						<a class="dropdown-item" href="{{url('admin/proveedores/'.$status.'/direccion=desc') }}"><i class="fas fa-sort-amount-down"></i> Descendente</a>
						<li><h6 class="dropdown-header">Teléfono</h6></li>
						<a class="dropdown-item" href="{{url('admin/proveedores/'.$status.'/telefono=asc') }}"><i class="fas fa-sort-amount-down-alt"></i> Ascendente</a>
						<a class="dropdown-item" href="{{url('admin/proveedores/'.$status.'/telefono=desc') }}"><i class="fas fa-sort-amount-down"></i> Descendente</a>
						<li><h6 class="dropdown-header">Correo electrónico</h6></li>
						<a class="dropdown-item" href="{{url('admin/proveedores/'.$status.'/correo=asc') }}"><i class="fas fa-sort-amount-down-alt"></i> Ascendente</a>
						<a class="dropdown-item" href="{{url('admin/proveedores/'.$status.'/correo=desc') }}"><i class="fas fa-sort-amount-down"></i> Descendente</a>
						</div> 					  
					</div>
				@endif
				<div class="dropdown mx-2">
					<button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"> Filtrar </button>
					<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
						<a class="dropdown-item" href="{{url('admin/proveedores/all') }}"><i class="fas fa-list"></i> Todos</a>
						<a class="dropdown-item" href="{{url('admin/proveedores/trash') }}"><i class="fas fa-trash-alt"></i> Papelera</a>
					</div>
				</div>

				<div class="col-sm-2">
					<form>
						<div class="input-group input-group-sm">
							<span class="input-group-text" id="basic-addon1">Mostrar</span>
							<input name="paginate" type="number" class="form-control" aria-describedby="basic-addon1" placeholder="{{session('paginate')}} elementos" min="1" >
						</div>
					</form>
				</div>
			</div>
				
		<div class="btns mb-2">
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

			<table class="table table-hover mtop16" id="Datatable" style="width: 100%; text-align: center;">
				<thead class="table-dark">
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
				</tbody>
			</table>
			@if($search)				
				{{$provs->appends(['search'=>$search])}}
				<p class="mtop16">
					Mostrando {{$provs->count()}} de {{ $provs->total() }} elemento(s).
				</p>	
			@else
				{{$provs->links()}}
				<p class="mtop16">
					Mostrando {{$provs->count()}} de {{ $provs->total() }} elemento(s).
				</p>
			@endif
		</div>
	</div>
</div>
@endsection
