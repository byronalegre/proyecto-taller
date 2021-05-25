@extends ('admin.master')

@section ('title','Categorias')

@section('breadcrumb')
<li class="breadcrumb-item">
	<a href="{{url('/admin/categorias/0') }}"><i class="fas fa-tags"></i> Categorias</a>
</li>
@endsection


@section('content')

<div class="container-fluid">
	<div class="row">
	@if(kvfj(Auth::user()->permisos, 'categorias_agregar'))
		<div class="col-md-4">
			<div class="panel shadow">				
				<div class="header">
					<h2 class="title"><i class="fas fa-plus-circle"></i> Agregar categoria
					</h2>
				</div>				
				<div class="inside">					
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
						 	{!!Form::textarea('descripcion', null, ['class' => 'form-control', 'rows'=>13]) !!}
					    </div>

					{!!Form::submit('Guardar', ['class' => 'btn btn-success mtop16'])!!}

					{!!Form::close()!!}					
				</div>		
			</div>
		</div>
	@endif
		<div class="col-md-8 d-flex">
			<div class="panel shadow">
				<div class="header">
					<h2 class="title"><i class="fas fa-tags"></i> Categorias
					</h2>
				</div>

				<div class="inside">
					<div class="row mb-2">
						<div class="col-sm-2">
							<div class="dropend">
							  <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"> <h7></h7> </button>
	
							  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">						    
									@foreach(getSeccionArray() as $m => $k)				
										<li>
											<a class="dropdown-item" href="{{url('/admin/categorias/'.$m) }}" id="cats">
												{{ $k }}
											</a>
										</li>							
									@endforeach
							  </div>
							</div>
						</div>

						<div class="col-sm-6">
							<form class="d-flex">
								<div class="input-group">
									<span class="input-group-text"><i class="fas fa-search"></i></span>
									<input name="search" type="text" class="form-control form-control-sm w-50" placeholder="Ingrese su búsqueda" aria-label="Ingrese su búsqueda" aria-describedby="button-addon2">
									<button class="btn btn-outline-dark btn-sm" type="submit" id="button-addon2">Buscar</button>
								</div>
							</form>
						</div>
						<div class="col-sm-4">
							<form>
								<div class="input-group input-group-sm">
									<span class="input-group-text" id="basic-addon1">Mostrar</span>
									<input name="paginate" type="number" class="form-control" aria-describedby="basic-addon1" placeholder="{{session('paginate')}} elementos" min="1" >
								</div>
							</form>
						</div>
						
					</div>

					<table class="table table-hover" id="Datatable" style="width: 100%">
						<thead class="table-dark">
							<tr>
								<td hidden="true">ID</td>
								<td>Nombre</td>
								<td>Descripción</td>
								<td width="90"></td>
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
						</tbody>
					</table>
					@if($search)				
						{{$cats->appends(['search'=>$search])}}
						<p class="mtop16">cats
							Mostrando {{$cats->count()}} de {{ $cats->total() }} elemento(s).
						</p>	
					@else
						{{$cats->links()}}
						<p class="mtop16">
							Mostrando {{$cats->count()}} de {{ $cats->total() }} elemento(s).
						</p>
					@endif
				</div>
			</div>
		</div>
	</div>
</div>
@endsection