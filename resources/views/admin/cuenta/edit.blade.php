@extends('admin.master')

@section('title','Mi cuenta')

@section('breadcrumb')
<li class="breadcrumb-item">
	<a href="{{url('/admin/micuenta/edit') }}"><i class="fas fa-user-circle"></i> Mi cuenta</a>
</li>
@endsection

@section('content')
<div class="container-fluid">		
				<div class="row">					
					<div class="col-md-6 d-flex">						
						<div class="panel shadow">
							<div class="header">
							<h2 class="title"><i class="fas fa-list"></i> Información básica</h2>
							</div>
							<div class="inside">
								{!! Form::open(['url' => '/admin/micuenta/edit/info','files'=>true]) !!} 

								<label for="title">Nombre/s:</label>
								<div class="input-group">							
								   	<span class="input-group-text" id="basic-addon1">
								   		<i class="fas fa-keyboard"></i>
								   	</span>						    
							    	{!!Form::text('name', Auth::user()->name, ['class' => 'form-control']) !!}
							    </div>
							
								<label for="title" class="mtop16">Apellido/s:</label>
								<div class="input-group">							
								   	<span class="input-group-text" id="basic-addon1">
								   		<i class="fas fa-keyboard"></i>
								   	</span>						    
							    	{!!Form::text('lastname', Auth::user()->lastname, ['class' => 'form-control']) !!}
							    </div>
							
								<label for="email" class="mtop16"> Correo Electrónico:</label>
								<div class="input-group">
									<span class="input-group-text" id="basic-addon1">
										 <i class="fas fa-at"></i>
									</span>
								{!! Form::email('email', Auth::user()->email, ['class' => 'form-control', 'disabled']) !!}
								</div>

								<div class="col-md-2 mtop16">
								{!! Form::submit('Guardar', ['class' => 'btn btn-success']) !!}
								</div>

							</div>
							{!!Form::close() !!}
						</div>				
					</div>

				<div class="col-md-6 d-flex">
					<div class="panel shadow">						 
						<div class="header">
						<h2 class="title"><i class="fas fa-lock"></i> Cambio de contraseña</h2>
						</div>

						<div class="inside">
							{!! Form::open(['url' => '/admin/micuenta/edit/password','files'=>true]) !!}

							<label for="old_password"> Contraseña actual:</label>
							<div class="input-group">
								<span class="input-group-text" id="basic-addon1">
									 <i class="fas fa-key"></i>
								</span>
							{!! Form::password('old_password', ['class' => 'form-control']) !!}
							</div>
							<label for="password" class="mtop16"> Contraseña nueva:</label>
							<div class="input-group">
								<span class="input-group-text" id="basic-addon1">
									 <i class="fas fa-key"></i>
								</span>
							{!! Form::password('password', ['class' => 'form-control']) !!}
							</div>
							<label for="cpassword" class="mtop16"> Confirmar contraseña:</label>
							<div class="input-group">
								<span class="input-group-text" id="basic-addon1">
									 <i class="fas fa-key"></i>
								</span>
							{!! Form::password('cpassword', ['class' => 'form-control']) !!}
							</div>

							<div class="col-md-2 mtop16">
							{!! Form::submit('Cambiar', ['class' => 'btn btn-success']) !!}
							</div>

						</div>
						{!!Form::close() !!}
					</div>
				</div>
			</div>
</div>

@endsection