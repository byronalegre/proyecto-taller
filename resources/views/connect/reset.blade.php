@extends('connect.master')

@section('title','Recuperar Contraseña')

@section('content')
<div class="box shadow">
	<div class="header shadow">
		<a href="{{ url('/')}} ">
			<img style="width:250px;" src="{{url('static/images/logo.png') }}">
		</a>
	</div>		
	<div class="inside"> 
		{!! Form::open(['url' => '/reset']) !!}
		<label for="email"> Correo Electrónico</label>
		<div class="input-group">
			<div class="input-group-prepend">
				 <div class="input-group-text"><i class="fas fa-at"></i></div>
			</div>
		{!! Form::email('email', $email, ['class' => 'form-control', 'required']) !!}
		</div>
		
		<label for="code" class="mtop16"> Código</label>
		<div class="input-group">
			<div class="input-group-prepend">
				 <div class="input-group-text"><i class="fas fa-keyboard"></i></div>
			</div>
		{!! Form::number('code', null, ['class' => 'form-control', 'required']) !!}
		</div>

		{!! Form::submit('Enviar contraseña', ['class' => 'btn btn-success mtop16']) !!}

		{!! Form::close()!!}
		
	
		@if(Session::has('message'))
				<div class="container">
					<div class="mtop16 alert alert-{{ Session::get('typealert') }}" style="display:none;">
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

	</div>
</div>

@stop