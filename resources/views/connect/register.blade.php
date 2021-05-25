@extends('connect.master')

@section('title','Registrarse')

@section('content')

<div class="box shadow">
<div class="header shadow">
	<a href="{{ url('/')}} ">
		<img src="{{url('static/images/logo1.png') }}" width="70">
	</a>
</div>		
<div class="inside"> 

	{!! Form::open(['url' => '/register']) !!}
	<!--NOMBRE-->
	<label for="email"> Nombre</label>
	<div class="input-group">
		<div class="input-group-prepend">
			 <div class="input-group-text"><i class="fas fa-keyboard"></i></div>
		</div>
	{!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
	</div>
	<!--APELLIDO-->
	<label for="email" class="mtop16"> Apellido</label>
	<div class="input-group">
		<div class="input-group-prepend">
			 <div class="input-group-text"><i class="fas fa-keyboard"></i></div>
		</div>
	{!! Form::text('lastname', null, ['class' => 'form-control', 'required']) !!}
	</div>
	<!--CORREO-->
	<label for="email" class="mtop16"> Correo Electrónico</label>
	<div class="input-group">
		<div class="input-group-prepend">
			 <div class="input-group-text"><i class="fas fa-at"></i></div>
		</div>
	{!! Form::email('email', null, ['class' => 'form-control', 'required']) !!}
	</div>
	<!--CONTRA-->
	<label for="password" class="mtop16"> Contraseña</label>
	<div class="input-group">
		<div class="input-group-prepend">
			 <div class="input-group-text"><i class="fas fa-key"></i></div>
		</div>
	{!! Form::password('password', ['class' => 'form-control', 'required']) !!}
	</div>
	<!--REPETIR CONTRA-->
	<label for="cpassword" class="mtop16"> Confirmar contraseña</label>
	<div class="input-group">
		<div class="input-group-prepend">
			 <div class="input-group-text"><i class="fas fa-key"></i></div>
		</div>
	{!! Form::password('cpassword', ['class' => 'form-control', 'required']) !!}
	</div>

	{!! Form::submit('Registrarse', ['class' => 'btn btn-success mtop16']) !!}

	{!! Form::close() !!}
	
	

		@if (Session::has('message'))
				<div class="container">
					<div class=" mtop16 alert alert-{{ Session::get('typealert') }}" style="display:none;">
						{{ Session::get('message') }}
						@if ($errors->any())
							<ul>
								@foreach($errors->all() as $error)
								<li>
									{{$error}}
								</li>
								@endforeach
							</ul>
						@endif
							<script>
								$('.alert').slideDown();
								setTimeout(function(){ $('.alert').slideUp(); }, 10000);
							</script>
					</div>
				</div>
		@endif
				
		<div class="footer mtop16">
			<font size="4px"><a href="{{url('/login')}}">Ingresar</a></font>
		</div>
	</div>
</div>

@stop