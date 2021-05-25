@extends ('admin.master')

@section ('title','Detalle pieza')

@section('breadcrumb')
<li class="breadcrumb-item">
	<a href="{{url('/admin/piezas/1') }}"><i class="fas fa-cog"></i> Piezas</a>
</li>
<li class="breadcrumb-item">
	<a href="{{url('/admin/piezas/'.$p->id.'/detalle')}}"><i class="fas fa-info-circle"></i> Detalle pieza</a>
</li>
@endsection

@section('content')

<div class="container-fluid">
	<div class="panel shadow">
		<div class="header">
			<h2 class="title"><i class="fas fa-info-circle"></i> Detalle pieza</h2>
		</div>
		<div class="inside">		

		  <div class="card">			  	
			  <div class="row m-2">
			    <div class="col-md-4 m-auto">
			    	<img src="{{ url('/uploads/'.$p->file_path.'/'.$p->image) }}" class="img-fluid w-80">
			    </div>

			    <div class="col-md-8">

			      <div class="card-body">

			      	<div style="text-align: right;">
			      		@if(kvfj(Auth::user()->permisos, 'piezas_editar'))
							@if(is_null($p->deleted_at))
								<a class="btn btn-primary btn-sm" href="{{url('admin/piezas/'.$p->id.'/edit') }}" data-toggle="tooltip" data-placement="top" title="Editar">
								<i class="fas fa-edit"></i>
								</a>
							@endif
						@endif						
		       			@if(kvfj(Auth::user()->permisos, 'historia'))
							<a  class="btn btn-sm btn-secondary text-white" href="{{url('admin/piezas/'.$p->id.'/detalle/historia_cambio') }}"data-toggle="tooltip" data-placement="top" title="Historial de cambios">
								<i class="fas fa-history"></i>
							</a>
						@endif
						@if(kvfj(Auth::user()->permisos, 'historia_precio'))
							<a class="btn btn-sm text-white" href="{{url('admin/piezas/'.$p->id.'/detalle/historia_precio')}}" data-toggle="tooltip" data-placement="top" title="Historial de precios" style="background-color: #239B56">
								<i class="fas fa-dollar-sign"></i>
							</a>
						@endif
			      	</div>			      	

			        <h5 class="card-title">{{ $p->name }}</h5>

			        <p class="card-text">

			        	<table class="table">

			        		<tr>
			        			<td><strong>ID</strong></td>
			        			<td> {{$p->id}} </td>
			        		</tr>
			        		<tr>
			        			<td><strong>Código</strong></td>
			        			<td> {{$p->codigo}} </td>
			        		</tr>
			        		<tr>
			        			<td><strong>Estado</strong></td>
			        			<td> 
			        				@if($p->status == 0)
			        					Inactiva
			        				@endif
			        				@if($p->status == 1)
			        					Activa
			        				@endif
			        			</td>
			        		</tr>
			        		<tr>
			        			<td><strong>Categoría</strong></td>
			        			<td> {{$p->cat->name}} </td>
			        		</tr>
			        		<tr>
			        			<td><strong>Cantidad mínima</strong></td>
			        			<td> {{$p->cantidad_min}} </td>
			        		</tr>
			        		<tr>
			        			<td><strong>Cantidad</strong></td>
			        			<td> {{$p->cantidad}} </td>
			        		</tr>
			        		<tr>
			        			<td><strong>Marca</strong></td>
			        			<td> {{$p->mark->name}} </td>
			        		</tr>
			        		<tr>
			        			<td><strong>Depósito</strong></td>
			        			<td> {{$p->deposito}} </td>
			        		</tr>
			        	</table>
			        </p>
			        <p class="card-text">
			        	{!!Form::textarea('content', $p->content, ['class' => 'form-control', 'id' => 'editor', 'readonly', 'rows'=>3] ) !!}
			        </p>
			      </div>
			    </div>
			  </div>
			</div>
		</div>
	</div>
</div>
@endsection
