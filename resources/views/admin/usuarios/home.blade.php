@extends ('admin.master')

@section ('title','Usuarios')


@section('breadcrumb')
<li class="breadcrumb-item">
	<a href="{{url('/admin/usuarios/all') }}"><i class="fas fa-users"></i> Usuarios</a>
</li>
@endsection

@section('content')

<div class="container-fluid">
	<div class="panel shadow">
		<div class="header">
			<h2 class="title"><i class="fas fa-users"></i> Usuarios</h2>
		</div>
		
		<div class="inside">
			<div class="nav justify-content-end">
					<form class="d-flex mx-2">
						<div class="input-group">
							<span class="input-group-text"><i class="fas fa-search"></i></span>
							<input name="search" type="text" class="form-control form-control-sm w-50" placeholder="Ingrese su búsqueda" aria-label="Ingrese su búsqueda" aria-describedby="button-addon2">
							{{-- {!! Form::select('status', ['all'=>'Todos', '0'=>'Inactivos', '1'=>'Activos'], 'all', ['class'=>'form-select form-select-sm w-25']) !!} --}}
							<button class="btn btn-outline-dark btn-sm" type="submit" id="button-addon2">Buscar</button>
						</div>
					</form>
					@if(kvfj(Auth::user()->permisos, 'usuarios_ordenar'))
						<div class="dropdown mx-2">
							<button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"> Ordenar por </button>

							<div class="dropdown-menu" aria-labelledby="dropdownMenuButton" id="menu-usuarios">
								<li><h6 class="dropdown-header">ID</h6></li>
								<a class="dropdown-item" href="{{url('admin/usuarios/'.$status.'/id=asc') }}"><i class="fas fa-sort-amount-down-alt"></i> Ascendente</a>
								<a class="dropdown-item" href="{{url('admin/usuarios/'.$status.'/id=desc') }}"><i class="fas fa-sort-amount-down"></i> Descendente</a>
								<li><h6 class="dropdown-header">Nombre</h6></li>
								<a class="dropdown-item" href="{{url('admin/usuarios/'.$status.'/name=asc') }}"><i class="fas fa-sort-amount-down-alt"></i> Ascendente</a>
								<a class="dropdown-item" href="{{url('admin/usuarios/'.$status.'/name=desc') }}"><i class="fas fa-sort-amount-down"></i> Descendente</a>
								<li><h6 class="dropdown-header">Apellido</h6></li>
								<a class="dropdown-item" href="{{url('admin/usuarios/'.$status.'/lastname=asc') }}"><i class="fas fa-sort-amount-down-alt"></i> Ascendente</a>
								<a class="dropdown-item" href="{{url('admin/usuarios/'.$status.'/lastname=desc') }}"><i class="fas fa-sort-amount-down"></i> Descendente</a>
								<li><h6 class="dropdown-header">Correo electrónico</h6></li>
								<a class="dropdown-item" href="{{url('admin/usuarios/'.$status.'/email=asc') }}"><i class="fas fa-sort-amount-down-alt"></i> Ascendente</a>
								<a class="dropdown-item" href="{{url('admin/usuarios/'.$status.'/email=desc') }}"><i class="fas fa-sort-amount-down"></i> Descendente</a>
								<li><h6 class="dropdown-header">Rol</h6></li>
								<a class="dropdown-item" href="{{url('admin/usuarios/'.$status.'/role=asc') }}"><i class="fas fa-sort-amount-down-alt"></i> Ascendente</a>
								<a class="dropdown-item" href="{{url('admin/usuarios/'.$status.'/role=desc') }}"><i class="fas fa-sort-amount-down"></i> Descendente</a>
								<li><h6 class="dropdown-header">Estado</h6></li>
								<a class="dropdown-item" href="{{url('admin/usuarios/'.$status.'/status=asc') }}"><i class="fas fa-sort-amount-down-alt"></i> Ascendente</a>
								<a class="dropdown-item" href="{{url('admin/usuarios/'.$status.'/status=desc') }}"><i class="fas fa-sort-amount-down"></i> Descendente</a>
							</div> 					  
						</div>		
					@endif

					<div class="dropdown mx-2">
						 <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"> Filtrar </button>

						  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
						    <a class="dropdown-item" href="{{url('admin/usuarios/all') }}"><i class="fas fa-list"></i> Todos</a>
						    <a class="dropdown-item" href="{{url('admin/usuarios/1') }}"><i class="fas fa-user-check"></i> Habilitados</a>
						    <a class="dropdown-item" href="{{url('admin/usuarios/100') }}"><i class="fas fa-user-times"></i> Deshabilitados</a>
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
				@if(kvfj(Auth::user()->permisos, 'usuarios_register'))			
					<a href="{{url('admin/usuarios/register') }}" class="btn btn-success btn-sm">
						<i class="fas fa-plus-circle"></i> Registrar usuario
					</a>	
				@endif						
			</div> 

			<table class="table table-hover mtop16" id="Datatable" style="width:100%; text-align: center;">
				<thead class="table-dark">
					<tr>
						<td>ID</td>
						<td>Nombre</td>
						<td>Apellido</td>
						<td>Correo Electrónico</td>
						<td>Rol</td>
						<td>Estado</td>
						<td width="100"></td>
					</tr>
				</thead>
				<tbody>
					@foreach($users as $user)
					<tr>
						<td>{{ $user->id }} </td>
						<td>{{ $user->name }} </td>
						<td>{{ $user->lastname }} </td>
						<td>{{ $user->email }} </td>
						<td class="text">{{ getRoleUsuarioArray(null, $user->role)}}</td>
						<td class="text">{{ getStatusUsuarioArray(null, $user->status)}}</td>
						<td>
							@if(kvfj(Auth::user()->permisos, 'usuarios_editar'))
								<a class="btn btn-warning btn-sm" href="{{url('admin/usuarios/'.$user->id.'/edit') }}"data-toggle="tooltip" data-placement="top" title="Ver información y rol">
								<i class="fas fa-eye"></i>
								</a>
							@endif
							@if($user->role != '0')
								@if(kvfj(Auth::user()->permisos, 'usuarios_permisos'))
									<a class="btn btn-warning btn-sm" href="{{url('admin/usuarios/'.$user->id.'/permisos') }}"data-toggle="tooltip" data-placement="top" title="Permisos">
									<i class="fas fa-user-cog"></i>
									</a>
								@endif
							@endif
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
			@if($search)				
				{{$users->appends(['search'=>$search])}}
				<p class="mtop16">
					Mostrando {{$users->count()}} de {{ $users->total() }} elemento(s).
				</p>	
			@else
				{{$users->links()}}
				<p class="mtop16">
					Mostrando {{$users->count()}} de {{ $users->total() }} elemento(s).
				</p>
			@endif
		</div>
	</div>
</div>
@endsection