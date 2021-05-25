<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>{{config('settings.name')}} - @yield('title')</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="routeName" content="{{ Route::currentRouteName() }}">
	<link rel="icon" type="image/png" href="{{ url('/static/images/mini.ico')}}"/>

	{{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous"> --}}
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
	
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
	<link rel="stylesheet" href="{{ url('/static/css/admin.css?v='.time()) }}">	
	<script src="https://kit.fontawesome.com/3f442a97b6.js" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

	<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
	<script src="{{url('/static/libs/ckeditor/ckeditor.js') }}" ></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<script src="{{ url('/static/js/admin.js?v='.time()) }}"></script>

	{{-- DATATABLE --}}
	{{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap5.min.css">
	<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js"></script>
	<script src="https://cdn.datatables.net/responsive/2.2.6/js/dataTables.responsive.min.js"></script> --}}
	{{-- <script>
		$(document).ready(function() {
		    $('#Datatable').DataTable({
		    	//"scrollX": true,
		    	"order": [[ 0, "desc" ]],
		    	"language":{
	        	"url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
	    		},
	    		// "paging": false
	    		"pageLength": 10,
      			"lengthMenu": [10, 50, 100, 200, 300, 400, 500]
		    });	   
		});		
	</script> --}}
	{{-- HASTA ACA --}}
	
	<script>
		$(document).ready(function(){
			  $('[data-toggle="tooltip"]').tooltip();
		});
	</script>

</head>
<body>

	<div class="wrapper">
		<div class="col1" id="sidebar">					
			  @include('admin.sidebar')							
		</div>
		<div class="col2" id="cuerpo"> 	
			<nav class="navbar navbar-expand-lg shadow-lg">	
				<div class="container-fluid justify-content-end" id="navCuenta">	
					<button class="navbar-toggler" onclick="abrir()">
					≡
					</button>							
					<ul class="navbar-nav ml-auto">					

						<div class="dropdown nav-item">
						  <button class="btn btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user-astronaut"></i> {{Auth::user()->name." ".Auth::user()->lastname}} 
						  </button>

						  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
						    @if(kvfj(Auth::user()->permisos, 'micuenta_editar'))
								<li>
									<a href="{{ url('/admin/micuenta/edit') }}">
									 <i class="far fa-user-circle"></i> Mi cuenta
									</a>
								</li>																
							@endif
							<li>
								<a href="#" data-bs-toggle="modal" data-bs-target="#salir"><i class="fas fa-sign-out-alt" style="color:red"></i> Cerrar sesión
								</a>								
							</li>
						  </div>
						</div>
					</ul>
				</div>
			</nav>
			<div class="page">
				<div class="container-fluid">
					<nav aria-label="breadcrumb" class="shadow-lg">	
						<ol class="breadcrumb">
							<li class="breadcrumb-item">
								<a href="{{url('/admin') }}">
									<i class="fas fa-home"></i> Inicio
								</a>
							</li>
							@section('breadcrumb')
							@show
						</ol>
					</nav>
					{{-- AVISO CIERRE SESION --}}
					<div class="modal fade" id="salir" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
					  <div class="modal-dialog modal-dialog-centered">
					    <div class="modal-content">
					      <div class="modal-header">
					        <h5 class="modal-title" id="exampleModalLabel">¿Desea cerrar sesión?</h5>
					        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					      </div>
					      <div class="modal-footer">
					        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
					        <a href="{{ url('/logout') }}" class="btn btn-danger">Si
							</a>
					      </div>
					    </div>
					  </div>
					</div>

				</div>

				@if(Session::has('message'))
					<div class="container">
						<div class="alert alert-{{ Session::get('typealert') }} mtop16">
							{{ Session::get('message') }}
							@if($errors->any())
								<ul>
									@foreach($errors->all() as $error)
									<li style="margin-left: 16px">
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
				<a href="javascript: history.go(-1)" class="btn btn-dark btn-sm m-3">Atrás</a>
			</div>
		</div>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>

	{{-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js" integrity="sha384-KsvD1yqQ1/1+IA7gi3P0tyJcT3vR+NdBTt13hSJ2lnve8agRGXTTyNaBYmCR/Nwi" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js" integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG" crossorigin="anonymous"></script> --}}

	<div class="footer shadow-lg" id="footer">
	  Desarrollado por Agustin Alegre & Mariano Wasinger con motivo académico para la carrera Lic. en Sistemas de Información | FCyT | UADER. ©
	</div>
</body>
	
</html>