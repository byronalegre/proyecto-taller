@extends('connect.master')

@section('title','Login')

@section('content')
<div class="box shadow">
	<div class="header shadow">
		<a href="{{ url('/')}}">
			<img style="width:250px; height:80px;" src="{{url('static/images/logo.png') }}">
		</a>
	</div>		
	<div class="inside"> 
		{!! Form::open(['url' => '/login']) !!}
		<label for="email"> Correo Electrónico</label>
		<div class="input-group">
			<div class="input-group-prepend">
				 <div class="input-group-text"><i class="fas fa-at"></i></div>
			</div>
		{!! Form::email('email', null, ['class' => 'form-control']) !!}
		</div>

		<label for="password" class="mtop16"> Contraseña</label>
		<div class="input-group">
			<div class="input-group-prepend">
				 <div class="input-group-text"><i class="fas fa-key"></i></div>
			</div>
		{!! Form::password('password', ['class' => 'form-control']) !!}
		</div>

		{!! Form::submit('Ingresar', ['class' => 'btn btn-success mtop16']) !!}

		{!! Form::close()!!}
		
	
		@if(Session::has('message'))
				<div class="container">
					<div class=" mtop16 alert alert-{{ Session::get('typealert') }}" style="display:none;">
						{{ Session::get('message') }}
						@if($errors->any())
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
			<font size="4px"><a href="{{url('/register')}}">Registrarse</a></font>
			<a style="margin-left: 20px; margin-right: 20px;"> | </a>
			<font size="4px"><a href="{{url('/recover')}}"> Recuperar contraseña</a></font>
		</div>
	</div>

</div>
@stop