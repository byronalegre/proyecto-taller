@extends ('admin.master')

@section ('title','Piezas')


@section('breadcrumb')
<li class="breadcrumb-item">
	<a href="{{url('/admin/piezas/1/name=asc') }}"><i class="fas fa-cog"></i> Piezas</a>
</li>
@endsection

@section('content')

<div class="container-fluid">
	<div class="panel shadow">
			<div class="header">
				<h2 class="title"><i class="fas fa-cog"></i> Piezas</h2>
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
					@if(kvfj(Auth::user()->permisos, 'piezas_ordenar'))
						<div class="dropdown mx-2">
							<button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"> Ordenar por </button>

							<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
							<li><h6 class="dropdown-header">Nombre</h6></li>
							<a class="dropdown-item" href="{{url('admin/piezas/'.$status.'/name=asc') }}"><i class="fas fa-sort-amount-down-alt"></i> Ascendente</a>
							<a class="dropdown-item" href="{{url('admin/piezas/'.$status.'/name=desc') }}"><i class="fas fa-sort-amount-down"></i> Descendente</a>
							<li><h6 class="dropdown-header">Código</h6></li>
							<a class="dropdown-item" href="{{url('admin/piezas/'.$status.'/codigo=asc') }}"><i class="fas fa-sort-amount-down-alt"></i> Ascendente</a>
							<a class="dropdown-item" href="{{url('admin/piezas/'.$status.'/codigo=desc') }}"><i class="fas fa-sort-amount-down"></i> Descendente</a>
							<li><h6 class="dropdown-header">Depósito</h6></li>
							<a class="dropdown-item" href="{{url('admin/piezas/'.$status.'/deposito=asc') }}"><i class="fas fa-sort-amount-down-alt"></i> Ascendente</a>
							<a class="dropdown-item" href="{{url('admin/piezas/'.$status.'/deposito=desc') }}"><i class="fas fa-sort-amount-down"></i> Descendente</a>
							<li><h6 class="dropdown-header">Cantidad</h6></li>
							<a class="dropdown-item" href="{{url('admin/piezas/'.$status.'/cantidad=asc') }}"><i class="fas fa-sort-amount-down-alt"></i> Ascendente</a>
							<a class="dropdown-item" href="{{url('admin/piezas/'.$status.'/cantidad=desc') }}"><i class="fas fa-sort-amount-down"></i> Descendente</a>
							</div> 					  
						</div>
					@endif
					<div class="dropdown mx-2">
						  <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"> Filtrar </button>

						  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
						    <a class="dropdown-item" href="{{url('admin/piezas/all') }}"><i class="fas fa-list"></i> Todos</a>
						    <a class="dropdown-item" href="{{url('admin/piezas/1') }}"><i class="fas fa-check"></i> Activos</a>
						    <a class="dropdown-item" href="{{url('admin/piezas/0') }}"><i class="fas fa-times"></i> Inactivos</a>
						    <a class="dropdown-item" href="{{url('admin/piezas/trash') }}"><i class="fas fa-trash-alt"></i> Papelera</a>
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
				
				<div class="btns my-2">	
					@if(kvfj(Auth::user()->permisos, 'piezas_agregar'))
						<a href="{{url('admin/piezas/agregar') }}" class="btn btn-success btn-sm">
							<i class="fas fa-plus-circle"></i> Agregar pieza
						</a>
					@endif
					@if(kvfj(Auth::user()->permisos, 'piezas_pdf'))
					<a data-toggle="tooltip" data-placement="top" title="Generar PDF" href="{{ route('piezas_pdf') }}" class="btn btn-sm btn-danger" target="_blank">
	           			<i data-toggle="tooltip" data-placement="top" title="Generar PDF" class="far fa-file-pdf"></i>
	           			PDF 
	       			</a>
	       			@endif
				</div>				
			
			<table class="table table-hover" id="Datatable" style="width:100%; text-align: center;">
				<thead class="table-dark">
					<td hidden="true">ID</td>
					<td></td>
					<td>Nombre</td>
					<td>Código</td>
					<td>Depósito</td>
					<td>Categoría</td>
					<td>Cantidad</td>
					<td>Reservadas</td>
					<td width="90"></td>
					<td width="auto"></td>
				</thead>
				<tbody>
					@foreach($piezas as $p)
						<tr @if (($p->cantidad < $p->cantidad_min) && ($p->cantidad != 0))
								class="table-warning" 
							@elseif ($p->cantidad == 0)
								class="table-danger" 
							@endif>

							<td hidden="true">{{ $p->id }}</td>
							<td width="64">
								<a href="{{ url('/uploads/'.$p->file_path.'/'.$p->image) }}" data-fancybox="gallery">
									<img src="{{ url('/uploads/'.$p->file_path.'/t_'.$p->image) }}" width="64">
								</a>
							</td>
							<td>{{ $p->name }}</td>
							<td>{{ $p->codigo }}</td>
							<td>{{ $p->deposito }}</td>
							<td>{{ $p->cat->name }}</td>
							<td>{{ $p->cantidad }}</td>
							
								@if($p->reserve == '[]')
									<td><span class="badge bg-dark"> Sin reservas</span></td>
								@else
									@foreach($aux as $a)
										@if($p->id == $a['pieza_id'])
											@if($a['cantidad_req'] != 0)
												<td>{{ $a['cantidad_req'] }}</td>
											@endif
										@endif
									@endforeach
								@endif
							
							<td>
								@if(kvfj(Auth::user()->permisos, 'pieza_detalle'))
									@if(is_null($p->deleted_at))
										<a class="btn btn-primary btn-sm" href="{{url('admin/piezas/'.$p->id.'/detalle') }}" data-toggle="tooltip" data-placement="top" title="Detalle">
										<i class="fas fa-info-circle"></i>
										</a>
									@endif
								@endif

								@if(kvfj(Auth::user()->permisos, 'piezas_eliminar'))
									@if(is_null($p->deleted_at))
										<a href="#" data-path="admin/piezas" data-action="delete" data-object="{{ $p->id }}" data-toggle="tooltip" data-placement="top" title="Eliminar" class="btn btn-danger btn-sm btn-deleted">
										<i class="fas fa-trash-alt"></i>
										</a> 
									@else
										<a href="{{ url('/admin/piezas/'.$p->id.'/restore') }}" data-action="restore" data-path="admin/piezas" data-object="{{ $p->id }}" data-toggle="tooltip" data-placement="top" title="Restaurar" class="btn btn-success btn-sm btn-deleted">
										<i class="fas fa-trash-restore"></i>
										</a> 
									@endif
								@endif								
							</td>
							<td style="text-align: center; padding-right: 0px; padding-left: 0px;">
								@if (($p->cantidad < $p->cantidad_min) && ($p->cantidad != 0))
									<span class="badge bg-warning text-dark"> Alerta Stock</span>
								@endif
								@if ($p->cantidad == 0)
									<span class="badge bg-danger text-dark"> Alerta Stock</span>
								@endif
								<br>
								@if($p->status == '0') 
									<span class="badge bg-dark">
										<i class="fas fa-eye-slash" data-toggle="tooltip" data-placement="top" title="Inactivo"></i>
									</span>
								@endif
							</td>
						</tr>
					@endforeach				
				</tbody>
			</table>
			@if($search)				
				{{$piezas->appends(['search'=>$search])}}
				<p class="mtop16">
					Mostrando {{$piezas->count()}} de {{ $piezas->total() }} elemento(s).
				</p>	
			@else
				{{$piezas->links()}}
				<p class="mtop16">
					Mostrando {{$piezas->count()}} de {{ $piezas->total() }} elemento(s).
				</p>
			@endif
		</div>
	</div>
</div>
@endsection