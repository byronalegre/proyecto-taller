@extends ('admin.master')

@section ('title','Agregar proveedor')


@section('breadcrumb')
<li class="breadcrumb-item">
	<a href="{{url('admin/proveedores/all') }}"><i class="fas fa-truck"></i> Proveedores</a>
</li>
<li class="breadcrumb-item">
	<a href="{{url('/admin/proveedores/agregar') }}"><i class="fas fa-plus-circle"></i> Agregar proveedor</a>
</li>
@endsection
 

 @section('content')

<div class="container-fluid">
	<div class="panel shadow">
		<div class="header">
			<h2 class="title"><i class="fas fa-plus-circle"></i> Agregar proveedor</h2>
		</div>
		<div class="inside">
			{!! Form::open(['url' => '/admin/proveedores/agregar','files'=>true]) !!} 
			
				<div class="row">

					<div class="col-md-6">
						<label for="title">Nombre de proveedor:</label>
						<div class="input-group">
						   		<span class="input-group-text" id="basic-addon1">
						   			<i class="fas fa-keyboard"></i>
						   		</span>
					    	{!!Form::text('name', null, ['class' => 'form-control']) !!}
					    </div>
					</div>

					<div class="col-md-3">
							<label for="cuit">CUIT:</label>
								<div class="input-group">
								   		<span class="input-group-text" id="basic-addon1">
								   			<i class="far fa-id-card"></i>
								   		</span>
						    	{!!Form::number('cuit', null, ['class' => 'form-control', 'placeholder'=>'XXXXXXXXXXX'] ) !!}
						    	</div>
					</div>

					<div class="col-md-3">
						<label for="telefono">Teléfono:</label>
							<div class="input-group">
							   		<span class="input-group-text" id="basic-addon1">
							   			<i class="fas fa-phone-alt"></i>
							   		</span>
					    	{!!Form::number('telefono', null, ['class' => 'form-control', 'placeholder'=>'Min 7 - Max 15'] ) !!}
					    	</div>
					</div>

				</div>

				<div class="row mtop16">

					<div class="col-md-6">
						<label for="direccion">Dirección:</label>
						<div class="input-group">
						   		<span class="input-group-text" id="basic-addon1">
						   			<i class="fas fa-map-marked-alt"></i>
						   		</span>
					    	{!!Form::text('direccion', null, ['class' => 'form-control']) !!}
					    </div>
					</div>

					<div class="col-md-6">
						<label for="correo">Correo Eléctronico:</label>
						<div class="input-group">
						   		<span class="input-group-text" id="basic-addon1">
						   			<i class="fas fa-at"></i>
						   		</span>
					    	{!!Form::text('correo', null, ['class' => 'form-control']) !!}
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