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
			<ul class="nav justify-content-end">
				@if(kvfj(Auth::user()->permisos, 'usuarios_buscar'))
						<div class="form-inline">
					
							{!! Form::open(['url' => '/admin/usuarios/buscar']) !!}
							
							<div class="row">
								<div style="padding: 0px" class="col-md-5">
									{!! Form::text('buscar', null, ['class' => 'form-control form-control-sm','placeholder' => 'Ingrese su búsqueda']) !!}
								</div>	
								<div class="col-md-4">
									{!! Form::select('filtro',['0'=>'ID','1'=>'Nombre','2'=>'Apellido'], 0,['class'=>'form-select form-select-sm']) !!}
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
						    <a class="dropdown-item" href="{{url('admin/usuarios/all') }}">Todos</a>
						    <a class="dropdown-item" href="{{url('admin/usuarios/0') }}">Registrados</a>
						    <a class="dropdown-item" href="{{url('admin/usuarios/1') }}">Activos</a>
						    <a class="dropdown-item" href="{{url('admin/usuarios/100') }}">Suspendidos</a>

						  </div>
					</div>
				
			</ul>

			<table class="table mtop16">
				<thead class="table-dark">
					<tr>
						<td>ID</td>
						<td>Nombre</td>
						<td>Apellido</td>
						<td>Email</td>
						<td>Rol</td>
						<td>Estado</td>
						<td width="110"></td>
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
							<a class="btn btn-warning btn-sm" href="{{url('admin/usuarios/'.$user->id.'/edit') }}"data-toggle="tooltip" data-placement="top" title="Ver">
							<i class="fas fa-eye"></i>
							</a>
							@endif
							@if(kvfj(Auth::user()->permisos, 'usuarios_permisos'))
							<a class="btn btn-warning btn-sm" href="{{url('admin/usuarios/'.$user->id.'/permisos') }}"data-toggle="tooltip" data-placement="top" title="Permisos">
							<i class="fas fa-user-cog"></i>
							</a>
							@endif
						</td>
					</tr>

					@endforeach

					<tr>
						<td colspan="8">{!! $users->render() !!}</td>
					</tr>

				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection