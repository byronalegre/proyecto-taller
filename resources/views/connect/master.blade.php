<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>@yield('title')</title>
		
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

		<link rel="stylesheet" href="{{url('/static/css/connect.css?v='.time())}}">
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

		<script src="https://kit.fontawesome.com/e86cf146da.js" crossorigin="anonymous"></script>

	</head>
	<body>
				<!--@if(Session::has('message'))
					<div class="container">
						<div class="alert alert-{{ Session::get('typealert') }} mtop16" style="display:none; margin-bottom: 16px;">
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
				@endif-->

				@section('content')	
				@show
	</body>
</html>