@extends ('admin.master')

@section ('title','Ver usuario')


@section('breadcrumb')
<li class="breadcrumb-item">
	<a href="{{url('/admin/usuarios/all') }}"><i class="fas fa-users"></i> Usuarios</a>
</li>
<li class="breadcrumb-item">
	<a href="{{url('/admin/usuarios/all') }}"><i class="fas fa-user-edit"></i> Editar usuario</a>
</li>
@endsection

@section('content')

<div class="container-fluid">
	<div class="page-user">
		<div class="row">
			<div class="col-md-4">
				<div class="panel shadow">
					<div class="header">
						<h2 class="title"><i class="fas fa-user-circle"></i> Información</h2>
					</div>
					<div class="inside">
						<div class="info">
							<span class="title"><i class="fas fa-id-card"></i> Nombre y apellido:</span>
							<span class="text">{{ $u->name }} {{ $u->lastname}}</span>
							<span class="title"><i class="far fa-envelope"></i> Correo Electrónico:</span>
							<span class="text">{{ $u->email}}</span>
							<span class="title"><i class="far fa-calendar-alt"></i> Fecha de registro:</span>
							<span class="text">{{ $u->created_at}}</span>
							<span class="title"><i class="fas fa-user-tag"></i> Rol:</span>
							<span class="text">{{ getRoleUsuarioArray(null, $u->role)}}</span>
							<span class="title"><i class="fas fa-user-tie"></i> Estado:</span>
							<span class="text">{{ getStatusUsuarioArray(null, $u->status)}}</span>
						</div>

						<div>	
							@if(kvfj(Auth::user()->permisos, 'usuarios_suspend'))
								@if($u->status == "100")
									<a href="{{ url('admin/usuarios/'.$u->id.'/suspend')}}" class="btn btn-success"> Activar usuario
									</a>
								@else	
									<a href="{{ url('admin/usuarios/'.$u->id.'/suspend')}}" class="btn btn-danger"> Suspender usuario
									</a>
								@endif
							@endif
						</div>
					</div>
				</div> 
			</div>

			<div class="col-md-8">
				<div class="panel shadow">
					<div class="header">
						<h2 class="title"><i class="fas fa-user-edit"></i> Editar rol</h2>
					</div>
					<div class="inside">
						
						@if(kvfj(Auth::user()->permisos, 'usuarios_editar'))
							{!! Form::open(['url'=>'/admin/usuarios/'.$u->id.'/edit']) !!}
								
								<div class="col-md-6">
									<div class="input-group">
									   		<span class="input-group-text" id="basic-addon1">
									   			<i class="fas fa-tag"></i>
									   		</span>
								    	{!!Form::select('rol_user', getRoleUsuarioArray('list', null), $u->role, ['class' =>'form-select']) !!}	
									</div>
								</div>

								<div class="col-md-2 mtop16">
									{!! Form::submit('Guardar', ['class'=>'btn btn-success']) !!}
								</div>

							{!! Form::close() !!}
						@endif
					</div>
				</div> 
			</div>
		</div>
	</div>	
</div>
@endsection