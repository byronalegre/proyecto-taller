<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>@yield('title')</title>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="routeName" content="{{ Route::currentRouteName() }}">
	<!--<meta name="viewport" content="width=device-width, initial-scale=1, shirnk-to-fit=no">-->
	
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
	
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
	<link rel="stylesheet" href="{{ url('/static/css/style.css?v='.time()) }}">	
	<script src="https://kit.fontawesome.com/e86cf146da.js" crossorigin="anonymous"></script>
	<!--<script<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script></script>-->
	<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
	<!--<script src="{{url('/static/libs/ckeditor/ckeditor.js') }}" ></script>-->
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<!--<script src="{{ url('/static/js/site.js?v='.time()) }}"></script>-->


</head>
<body>

	<nav class="navbar navbar-expand-lg shadow">
	 	<div class="container-fluid">
		    <a class="navbar-brand" href="{{url('/')}}" ><img src="{{url('static/images/logo.png')}}" width="200" height="60" alt="" loading="lazy">
		    </a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
			≡
			</button>
			<div class="collapse navbar-collapse" id="navbarNav">
				<ul class="navbar-nav ml-auto">
					@if(Auth::guest())
					<li class="nav-item">
						<a href="{{ url('https://www.bionogoya.com.ar/#empresa') }}" class="nav-link"><i class="fas fa-info-circle"></i> Sobre nosotros</a>
					</li>
					<li class="nav-item">
						<a href="{{ url('/login') }}" class="btn btn-sm shadow"><i class="far fa-user-circle"></i> Ingresar</a>
					
						<a href="{{ url('/register') }}" class="btn btn-sm shadow"><i class="fas fa-user-circle"></i> Registrarse</a>
					</li>
					@else
					@if((Auth::user()->role == "1")||(Auth::user()->role == "2")||(Auth::user()->role == "3"))
					<li class="nav-item">
						<a href="{{ url('/admin') }}" class="nav-link"><i class="fas fa-user-tie"></i> Administración</a>
					</li>
					@endif

					<li class="nav-item link-user dropdown">
						<a href="#" class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false"><i class="far fa-user-circle"></i>
							 Hola: {{ Auth::user()->name }}
						</a>
							 <ul class="dropdown-menu dropdown-menu-right shadow" aria-labelledby="navbarDropdown">
					            <li><a class="dropdown-item" href="{{ url('/logout') }}"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</a></li>
					        </ul>
					</li>
					
					@endif
				</ul>
			</div>
		    
	  	</div>
	</nav>
					@if(Session::has('message'))
					<div class="container-fluid">
						<div class="alert alert-{{ Session::get('typealert') }} mtop16" style="display:none; margin-bottom: 16px; margin: 16px;">
							{{ Session::get('message') }}
							@if($errors->any())
								<ul>
									@foreach($errors->all() as $error)
									<li>
										{{ $error }}
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
				
				@section('content')
				@show
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>

</body>
</html>