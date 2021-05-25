@extends ('admin.master')

@section ('title','Detalle historial')


@section('breadcrumb')
<li class="breadcrumb-item">
	<a href="{{url('/admin/piezas/1') }}"><i class="fas fa-cog"></i> Piezas</a>
</li>
<li class="breadcrumb-item">
	<a href="{{url('/admin/piezas/'.$log->pieza_id.'/detalle') }}"><i class="fas fa-info-circle"></i> Detalle pieza </a>
</li>
<li class="breadcrumb-item">
	<a href="{{url('/admin/piezas/'.$log->pieza_id.'/detalle/historia_cambio') }}"><i class="fas fa-history"></i> Historial de cambios</a>
</li>
<li class="breadcrumb-item">
	<a href="{{url('/admin/piezas/'.$log->pieza_id.'/detalle/historia_cambio/'.$log->id.'/detalle') }}"><i class="fas fa-info-circle"></i> Detalle historial</a>
</li>
@endsection

@section('content')

<div class="container-fluid">
	<div class="panel shadow">
			<div class="header">
				<h2 class="title"><i class="fas fa-info-circle"></i> Detalle historial</h2>
			</div>	
			<div class="inside">
				<div style="justify-content: center;" class="row">
					<div class="col-md-4 mt-auto mb-auto">
						<div class="card bg-dark" style="width: 18rem;">
						  <div class="card-header text-white">
						    Valores anteriores
						  </div>
						  <ul class="list-group list-group-flush">
						 	@foreach(json_decode($log->old_values,true) as $key=>$o)								
								@switch($key)
									@case('codigo')
								        <li class="list-group-item"><strong>Código: </strong>{{$o}}</li>
								        @break
								    @case('status')
								        <li class="list-group-item"><strong>Estado: </strong>@if($o == 0) Inactivo @else Activo @endif</li>
								        @break
								    @case('name')
								        <li class="list-group-item"><strong>Nombre: </strong>{{$o}}</li>
								        @break
								    @case('categoria_id')
								        <li class="list-group-item"><strong>Categoría: </strong>{{$cat[$o]}}</li>
								        @break
								    @case('cantidad')
								        <li class="list-group-item"><strong>Cantidad: </strong>{{$o}}</li>
								       	@break
								    @case('cantidad_min')
								        <li class="list-group-item"><strong>Cantidad mínima: </strong>{{$o}}</li>
								        @break
								    @case('marca')
								        <li class="list-group-item"><strong>Marca: </strong>{{$cat[$o]}}</li>
								        @break
								    @case('deposito')
								        <li class="list-group-item"><strong>Depósito: </strong>{{$o}}</li>
								        @break
								    @case('image')
								       <li class="list-group-item"><strong>Nombre imagen: </strong>{{$o}}</li>
								        @break
								@endswitch					
							@endforeach
						</ul>	
						</div>
					</div>
					<div class="col-md-2 mt-auto mb-auto">
						<i class="fas fa-exchange-alt fa-4x"></i>
					</div>
					<div class="col-md-4 mt-auto mb-auto">
						<div class="card bg-success" style="width: 18rem;">
						  <div class="card-header text-white">
						    Valores nuevos
						  </div>
						  <ul class="list-group list-group-flush">
						 	@foreach(json_decode($log->new_values,true) as $key=>$o)								
								@switch($key)
									@case('codigo')
								        <li class="list-group-item"><strong>Código: </strong>{{$o}}</li>
								        @break
								    @case('status')
								        <li class="list-group-item"><strong>Estado: </strong>@if($o == 0) Inactivo @else Activo @endif</li>
								        @break
								    @case('name')
								        <li class="list-group-item"><strong>Nombre: </strong>{{$o}}</li>
								        @break
								    @case('categoria_id')
								        <li class="list-group-item"><strong>Categoría: </strong>{{$cat[$o]}}</li>
								        @break
								    @case('cantidad')
								        <li class="list-group-item"><strong>Cantidad: </strong>{{$o}}</li>
								       	@break
								    @case('cantidad_min')
								        <li class="list-group-item"><strong>Cantidad mínima: </strong>{{$o}}</li>
								        @break
								    @case('marca')
								        <li class="list-group-item"><strong>Marca: </strong>{{$cat[$o]}}</li>
								        @break
								    @case('deposito')
								        <li class="list-group-item"><strong>Depósito: </strong>{{$o}}</li>
								        @break
								    @case('image')
								       <li class="list-group-item"><strong>Nombre imagen: </strong>{{$o}}</li>
								        @break
								@endswitch					
							@endforeach
						</ul>	
						</div>
					</div>
				</div>
		</div>
	</div>
</div>
@endsection