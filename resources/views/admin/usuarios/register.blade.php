@extends ('admin.master')

@section ('title','Registrar usuario')


@section('breadcrumb')
<li class="breadcrumb-item">
	<a href="{{url('/admin/usuarios/all') }}"><i class="fas fa-users"></i> Usuarios</a>
</li>
<li class="breadcrumb-item">
	<a href="{{url('/admin/usuarios/register') }}"><i class="fas fa-plus-circle"></i> Registrar usuario</a>
</li>
@endsection
 

 @section('content')

<div class="container-fluid">
	<div class="panel shadow">

		<div class="header">
			<h2 class="title"><i class="fas fa-plus-circle"></i> Registrar usuario</h2>
		</div>

		<div class="inside">
			{!! Form::open(['url' => '/admin/usuarios/register']) !!}
			<div class="row">

					<div class="col-md-6">
						<label for="title">Nombre:</label>
						<div class="input-group">
						   		<span class="input-group-text" id="basic-addon1">
						   			<i class="fas fa-keyboard"></i>
						   		</span>
					    	{!!Form::text('name', null, ['class' => 'form-control']) !!}
					    </div>
					</div>

					<div class="col-md-6">
							<label for="cuit">Apellido:</label>
								<div class="input-group">
								   		<span class="input-group-text" id="basic-addon1">
								   			<i class="fas fa-keyboard"></i>
								   		</span>
						    	{!! Form::text('lastname', null, ['class' => 'form-control']) !!}
						    	</div>
					</div>					
				</div>

				<div class="row mtop16">

					<div class="col-md-6">
						<label for="email">Correo Eléctronico:</label>
						<div class="input-group">
						   		<span class="input-group-text" id="basic-addon1">
						   			<i class="fas fa-at"></i>
						   		</span>
					    	{!!Form::text('email', null, ['class' => 'form-control']) !!}
					    </div>
					</div>	

					<div class="col-md-6">
						<label for="password">Contraseña:</label>
						<div class="input-group">
						   		<span class="input-group-text" id="basic-addon1">
						   			<i class="fas fa-key"></i>
						   		</span>
					    	{!!Form::password('password', ['class' => 'form-control']) !!}
					    </div>
					</div>	
				</div>

				<div class="row mtop16" >
					<div class="col-md-12">
						{!! Form::submit('Guardar', ['class' => 'btn btn-success']) !!}
					</div>
				</div>
		</div>			
		{!!Form::close() !!}		
	</div>
</div>
@endsection