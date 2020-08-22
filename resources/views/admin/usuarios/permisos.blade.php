@extends ('admin.master')

@section ('title','Permisos de usuario')


@section('breadcrumb')
<li class="breadcrumb-item">
	<a href="{{url('/admin/usuarios/all') }}"><i class="fas fa-users"></i> Usuarios</a>
</li>
<li class="breadcrumb-item">
	<a href="{{url('/admin/usuarios/all') }}"><i class="fas fa-user-edit"></i> Permisos del usuario: {{$u->name}} {{ $u->lastname}}</a>
</li>
@endsection

@section('content')

	<div class="container-fluid">
		
		<div class="page-user">
			
			<form action="{{ url('/admin/usuarios/'.$u->id.'/permisos')}}" method="POST">

				@csrf

				<div class="row">
				
					@foreach(permisos_usuario() as $key=>$value)
					
						<div class="col-md-4 d-flex mtop16">
							<div class="panel shadow">

								<div class="header">
									<h2 class="title">{!! $value['icon'] !!} {!! $value['title'] !!} </h2>
								</div>

								<div class="inside">
									@foreach($value['keys'] as $k=>$v)
									<div class="form-check">
										<input class="form-check-input" type="checkbox" id="flexCheckDefault" value="true" name="{{$k}}" @if(kvfj($u->permisos, $k )) checked @endif>
										<label class="form-check-label" for="flexCheckDefault"> {{$v}} </label>
									</div>
									@endforeach
								</div>
							</div> 
						</div>	
					@endforeach
				</div>

				<div class="row mtop16">
					<div class="col-md-12">
						<div class="panel shadow">
							<div class="inside">
								<input style="width: auto" type="submit" value="Guardar" class="btn btn-success">
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
@endsection