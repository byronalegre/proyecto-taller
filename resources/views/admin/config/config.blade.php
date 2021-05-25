@extends ('admin.master')

@section ('title','Configuración')


@section('breadcrumb')
<li class="breadcrumb-item">
	<a href="{{url('/admin/usuarios/all') }}"><i class="fas fa-wrench"></i> Configuración</a>
</li>
@endsection
 

 @section('content')

<div class="container-fluid">
	<div class="panel shadow">
		<div class="header">
			<h2 class="title"><i class="fas fa-wrench"></i> Configuración</h2>
		</div>

		<div class="inside">
			{!! Form::open(['url' => '/admin/config']) !!}
			<div class="row">
					<div class="col-md-3">
						<label for="title">Nombre de sistema:</label>
						<div class="input-group">
								<span class="input-group-text" id="basic-addon1">
									<i class="far fa-registered"></i>
								</span>
							{!!Form::text('name', config( 'settings.name' ), ['class' => 'form-control']) !!}
						</div>
					</div>				

					<div class="col-md-3">
						<label for="telefono">Teléfono de la entidad:</label>
						<div class="input-group">
								<span class="input-group-text" id="basic-addon1">
									<i class="fas fa-phone"></i>
								</span>
							{!!Form::number('telefono', config( 'settings.telefono' ), ['class' => 'form-control']) !!}
						</div>
					</div>	
			
					<div class="col-md-6">
						<label for="direccion">Dirección de la entidad:</label>
						<div class="input-group">
								<span class="input-group-text" id="basic-addon1">
									<i class="fas fa-map-marked-alt"></i>
								</span>
							{!!Form::text('direccion', config( 'settings.direccion' ), ['class' => 'form-control']) !!}
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