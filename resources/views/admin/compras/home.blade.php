@extends ('admin.master')

@section ('title','Compras')

@section('breadcrumb')
<li class="breadcrumb-item">
	<a href="{{url('/admin/compras/all') }}"><i class="fas fa-cart-plus"></i> Compras</a>
</li>
@endsection

@section('content')

<div class="container-fluid">
	<div class="panel shadow">
		<div class="header">
			<h2 class="title"><i class="fas fa-cart-plus"></i> Compras</h2>
		</div>
		<div class="inside">

				<div class="nav justify-content-end">				
					
					<div class="dropdown">
						  <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Filtrar </button>

						  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
						    <a class="dropdown-item" href="{{url('admin/compras/all') }}">Todos</a>
						    <a class="dropdown-item" href="{{url('admin/compras/trash') }}">Papelera</a>
						  </div>
					</div>

				</div>	

			@if(kvfj(Auth::user()->permisos, 'compras_agregar'))
			<a href="{{url('admin/compras/agregar') }}" class="btn btn-success btn-sm">
			<i class="fas fa-plus-circle"></i> Nueva compra
			</a>
			@endif

			<table class="table table-hover mtop16">
				<thead class="table-dark">
					<td style="text-align: center;">Código</td>
					<td style="text-align: center;">Proveedor</td>					
					<td style="text-align: center;">Fecha registro</td>
					<td>Descripción</td>
					<td width="110"></td>
				</thead>
				<tbody>
					@foreach($input as $i)
					<tr>
						<td style="text-align: center;">ODC-{{ $i->codigo }} </td>						
						<td style="text-align: center;">{{ $i->provs->name }} </td>
						<td style="text-align: center;">{{ $i->created_at->format('d/m/Y (H:i)') }} </td>	
						<td>{{ $i->descripcion }}</td>
						<td>
							@if(kvfj(Auth::user()->permisos, 'compra_detalle'))
								@if(is_null($i->deleted_at))
									<a href="{{url('admin/compras/'.$i->id.'/detalle') }}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Detalle">
										<i class="fas fa-info-circle"></i>
									</a>				
								@endif			
							@endif
							@if(kvfj(Auth::user()->permisos, 'compras_eliminar'))
								@if(is_null($i->deleted_at))
									<a href="#" data-path="admin/compras" data-action="delete" data-object="{{ $i->id }}" data-toggle="tooltip" data-placement="top" title="Anular" class="btn btn-danger btn-sm btn-deleted">
									<i class="fas fa-trash"></i>
									</a> 
								@else
									<a href="{{ url('/admin/compras/'.$i->id.'/restore') }}" data-action="restore" data-path="admin/compras" data-object="{{ $i->id }}" data-toggle="tooltip" data-placement="top" title="Restaurar" class="btn btn-success btn-sm btn-deleted">
									<i class="fas fa-trash-restore"></i>
									</a> 
								@endif
							@endif	
											
						</td>
					</tr>
					@endforeach					
					<tr>
						<td colspan="5"> {!! $input->render() !!}</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection
