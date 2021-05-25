@extends ('admin.master')

@section ('title','Editar categoria')

@section('breadcrumb')
<li class="breadcrumb-item">
	<a href="{{url('/admin/categorias/agregar') }}"><i class="fas fa-tags"></i> Categorias</a>
</li>
<li class="breadcrumb-item">
	<a href="{{url('/admin/categorias/agregar') }}"><i class="fas fa-edit"></i> Editar categoría</a>
</li>
@endsection


@section('content')

<div class="container-fluid">
	<div class="row">
		<div class="col-md-4">
			<div class="panel shadow">
				<div class="header">
					<h2 class="title"><i class="fas fa-edit"></i>Editar categoria
					</h2>
				</div>
				<div class="inside">
					{!!Form::open(['url' => 'admin/categorias/'.$cat->id.'/edit'])!!}
						<label for="title">Nombre de categoría:</label>
						<div class="input-group">							
						   		<span class="input-group-text" id="basic-addon1">
						   			<i class="fas fa-keyboard"></i>
						   		</span>						    
					    	{!!Form::text('name', $cat->name, ['class' => 'form-control']) !!}
					    </div>

					    <label for="seccion" class="mtop16">Sección:</label>
						<div class="input-group">							
						   		<span class="input-group-text" id="basic-addon1">
						   			<i class="fas fa-cubes"></i>
						   		</span>						    
					    	{!!Form::select('seccion', getSeccionArray(), $cat->seccion, ['class' =>'form-select']) !!}
					    		
						</div>

					    <label for="descripcion" class="mtop16">Descripción:</label>
						<div class="input-group">
						 	{!!Form::textarea('descripcion', $cat->descripcion, ['class' => 'form-control', 'rows'=>4]) !!}
					    </div>

					{!!Form::submit('Guardar', ['class' => 'btn btn-success mtop16'])!!}

					{!!Form::close()!!}
				</div>
			
			</div>
		</div>

	</div>

</div>
@endsection