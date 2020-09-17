@extends ('admin.master')

@section ('title','Categorias')

@section('breadcrumb')
<li class="breadcrumb-item">
	<a href="{{url('/admin/categorias/agregar') }}"><i class="fas fa-tags"></i> Categorias</a>
</li>
@endsection


@section('content')

<div class="container-fluid">
	<div class="row">
		<div class="col-md-4 d-flex">
			<div class="panel shadow">
				<div class="header">
					<h2 class="title"><i class="fas fa-plus-circle"></i> Agregar categoria
					</h2>
				</div>
				<div class="inside">
					@if(kvfj(Auth::user()->permisos, 'categorias_agregar'))
					{!!Form::open(['url' => 'admin/categorias/agregar'])!!}
						<label for="title">Nombre de categoría:</label>
						<div class="input-group">							
						   		<span class="input-group-text" id="basic-addon1">
						   			<i class="fas fa-keyboard"></i>
						   		</span>						    
					    	{!!Form::text('name', null, ['class' => 'form-control']) !!}
					    </div>

					    <label for="seccion" class="mtop16">Sección:</label>
						<div class="input-group">							
						   		<span class="input-group-text" id="basic-addon1">
						   			<i class="fas fa-cubes"></i>
						   		</span>						    
					    	{!!Form::select('seccion', getSeccionArray(), 0, ['class' =>'form-select']) !!}
					    		
						</div>

					    <label for="descripcion" class="mtop16">Descripción:</label>
						<div class="input-group">
						 	{!!Form::textarea('descripcion', null, ['class' => 'form-control', 'rows'=>4]) !!}
					    </div>

					{!!Form::submit('Guardar', ['class' => 'btn btn-success mtop16'])!!}

					{!!Form::close()!!}
					@endif
				</div>
			
			</div>
		</div>

		<div class="col-md-8 d-flex">
			<div class="panel shadow">
				<div class="header">
					<h2 class="title"><i class="fas fa-tags"></i> Categorias
					</h2>
				</div>

				<div class="inside">
					
					<div class="nav">
						@foreach(getSeccionArray() as $m => $k)				
							<li class="breadcrumb-item">
								<a href="{{url('/admin/categorias/'.$m) }}">
									{{ $k }}
									<i class="fas fa-caret-down"></i>
								</a>
							</li>							
						@endforeach
					</div>

					<table class="table table-hover mtop16">
						<thead class="table-dark">
							<tr>
								<td hidden="true">ID</td>
								<td>Nombre</td>
								<td>Descripción</td>
								<td width="100px"></td>
							</tr>
						</thead>
						<tbody>
							@foreach($cats as $cat)
								<tr>
									<td hidden="true">{{ $cat->id}}</td>
									<td>{{ $cat->name}}</td>
									<td>{{ $cat->descripcion }}</td>
									
									<td>
										@if(kvfj(Auth::user()->permisos, 'categorias_editar'))
										<a class="btn btn-primary btn-sm" href="{{url('admin/categorias/'.$cat->id.'/edit') }}"data-toggle="tooltip" data-placement="top" title="Editar">
										<i class="fas fa-edit"></i>
										</a>
										@endif
										@if(kvfj(Auth::user()->permisos, 'categorias_eliminar'))
										<a class="btn btn-danger btn-sm" href="{{url('admin/categorias/'.$cat->id.'/delete') }}"data-toggle="tooltip" data-placement="top" title="Eliminar">
										<i class="fas fa-times"></i>
										</a>
										@endif
									</td>
								</tr>
							@endforeach
							<tr>
								<td colspan="4">{!! $cats->render() !!}</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection