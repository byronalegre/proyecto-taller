@extends ('admin.master')

@section ('title','Piezas')


@section('breadcrumb')
<li class="breadcrumb-item">
	<a href="{{url('/admin/piezas/1') }}"><i class="fas fa-cogs"></i> Piezas</a>
</li>
@endsection

@section('content')

<div class="container-fluid">
	<div class="panel shadow">
			<div class="header">
				<h2 class="title"><i class="fas fa-cogs"></i> Piezas</h2>
			</div>										
			<div class="inside">
				<div class="nav justify-content-end">
					@if(kvfj(Auth::user()->permisos, 'piezas_buscar'))					
						{!! Form::open(['url' => '/admin/piezas/buscar']) !!}
							<div class="input-group  mb-3">
								  {!! Form::text('buscar', null, ['class' => 'form-control form-control-sm','placeholder' => 'Buscar por']) !!}
								  {!! Form::select('filtro',['0'=>'ID','1'=>'Nombre','2'=>'Código','3'=>'Depósito'], 0,['class'=>'form-select form-select-sm']) !!}
								  {!! Form::submit('Buscar', ['class'=> 'btn btn-outline-dark btn-sm']) !!}
							</div>
						{!! Form::close() !!}
					@endif							
								
					<div class="dropdown pl-3">
						  <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Filtrar </button>

						  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
						    <a class="dropdown-item" href="{{url('admin/piezas/all') }}">Todos</a>
						    <a class="dropdown-item" href="{{url('admin/piezas/1') }}">Activos</a>
						    <a class="dropdown-item" href="{{url('admin/piezas/0') }}">Inactivos</a>
						    <a class="dropdown-item" href="{{url('admin/piezas/trash') }}">Papelera</a>

						  </div>
					</div>
				</div>		
				
				<div class="btns">	
					@if(kvfj(Auth::user()->permisos, 'piezas_agregar'))
						<a href="{{url('admin/piezas/agregar') }}" class="btn btn-success btn-sm">
							<i class="fas fa-plus-circle"></i> Agregar pieza
						</a>
					@endif
					@if(kvfj(Auth::user()->permisos, 'piezas_pdf'))
					<a data-toggle="tooltip" data-placement="top" title="Generar PDF" href="{{ route('piezas_pdf') }}" class="btn btn-sm btn-danger">PDF 
	           			<i data-toggle="tooltip" data-placement="top" title="Generar PDF" class="far fa-file-pdf"></i>
	       			</a>
	       			@endif
				</div> 
				
			
			<table class="table table-hover mtop16">
				<thead class="table-dark">
					<td>ID</td>
					<td></td>
					<td>Nombre</td>
					<td>Código</td>
					<td>Depósito</td>
					<td>Categoría</td>
					<td>Mínimo</td>
					<td>Cantidad</td>
					<td>Marca</td>
					<td width="90"></td>
					<td width="auto"></td>
				</thead>
				<tbody>
					@foreach($piezas as $p)
						<tr @if ($p->cantidad < $p->cantidad_min)
								class="table-warning" 
							@endif>

							<td width="50">{{ $p->id }}</td>
							<td width="64">
								<a href="{{ url('/uploads/'.$p->file_path.'/'.$p->image) }}" data-fancybox="gallery">
									<img src="{{ url('/uploads/'.$p->file_path.'/t_'.$p->image) }}" width="64">
								</a>
							</td>
							<td>{{ $p->name }}</td>
							<td>{{ $p->codigo }}</td>
							<td style="text-align: center">{{ $p->deposito }}</td>
							<td>{{ $p->cat->name }}</td>
							<td>{{ $p->cantidad_min }}</td>
							<td>{{ $p->cantidad }}</td>
							<td>{{ $p->mark->name }}</td>
							<td>
								@if(kvfj(Auth::user()->permisos, 'piezas_editar'))
									@if(is_null($p->deleted_at))
										<a class="btn btn-primary btn-sm" href="{{url('admin/piezas/'.$p->id.'/edit') }}"data-toggle="tooltip" data-placement="top" title="Editar">
										<i class="fas fa-edit"></i>
										</a>
									@endif
								@endif

								@if(kvfj(Auth::user()->permisos, 'piezas_eliminar'))
									@if(is_null($p->deleted_at))
										<a href="#" data-path="admin/piezas" data-action="delete" data-object="{{ $p->id }}" data-toggle="tooltip" data-placement="top" title="Eliminar" class="btn btn-danger btn-sm btn-deleted">
										<i class="fas fa-trash"></i>
										</a> 
									@else
										<a href="{{ url('/admin/piezas/'.$p->id.'/restore') }}" data-action="restore" data-path="admin/piezas" data-object="{{ $p->id }}" data-toggle="tooltip" data-placement="top" title="Restaurar" class="btn btn-success btn-sm btn-deleted">
										<i class="fas fa-trash-restore"></i>
										</a> 
									@endif
								@endif								
							</td>
							<td>
								@if ($p->cantidad < $p->cantidad_min)
									<p><i data-toggle="tooltip" title="Alerta stock" class="fas fa-exclamation-triangle fa-2x"></i></p>
								@endif
							</td>
						</tr>
					@endforeach
					<tr>
						<td colspan="11"> {!! $piezas->render() !!}</td>
					</tr>
						
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection