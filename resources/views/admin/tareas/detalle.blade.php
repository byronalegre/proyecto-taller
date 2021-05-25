@extends ('admin.master')

@section ('title','Tareas')

@section('breadcrumb')
<li class="breadcrumb-item">
	<a href="{{url('/admin/tareas/all') }}"><i class="fas fa-tasks"></i> Tareas</a>
</li>
<li class="breadcrumb-item">
	<a href="{{url('/admin/tareas/'.$t->id.'/detalle') }}"><i class="fas fa-info-circle"></i> Detalle tarea: {{$t->codigo}}</a>
</li>

@endsection

@section('content')

<div class="container-fluid" oncontextmenu="return false"><!-- ONCONTEXTMENU DESACTIVA F12-->
	<div class="panel shadow">
		<div class="header">
			<h2 class="title"><i class="fas fa-info-circle"></i> Detalle</h2>
		</div>
		<div class="inside">

			<div class="card text-center">
			  <div class="card-header">
			    <div>
					<b>CODIGO:</b>
					<a>{{$t->codigo}}</a>
				</div>
			  </div>

			  <div class="card-body">
			  	<div style="text-align: right;">	
					@if($t->status != '1')		
						@if(kvfj(Auth::user()->permisos, 'tareas_editar'))						
							<a class="btn btn-primary text-white btn-sm" href="{{url('admin/tareas/'.$t->id.'/edit') }}" data-toggle="tooltip" data-placement="top" title="Editar tarea">
							<i class="fas fa-edit"></i>
							</a>						
						@endif	
						@if(kvfj(Auth::user()->permisos, 'tareas_completar'))						
							<a class="btn btn-success text-white btn-sm" href="{{url('admin/tareas/'.$t->id.'/complete') }}" data-toggle="tooltip" data-placement="top" title="Completar tarea">
							<i class="fas fa-arrow-circle-right"></i>
							</a>						
						@endif
					@endif
					@if(kvfj(Auth::user()->permisos, 'detalle_tarea_pdf'))
						<a href="{{url('admin/tareas/'.$t->id.'/detalle/tarea_pdf')}}" data-toggle="tooltip" data-placement="top" title="Generar PDF" class="btn btn-danger btn-sm" target="_blank">
							<i class="far fa-file-pdf"></i>
							PDF
						</a>
					@endif
				 </div>
			    <h5 class="card-title">
			    	<div>
						<b>TAREA:</b>
						<a>{{$t->work->name}}</a>
					</div>
			    </h5>
			    <p class="card-text">
					<div>
						<b>FECHA SOLICITUD:</b>
						<a>{{$t->created_at->format('d/m/Y')}}</a>
					</div>
					<div>
						<b>FECHA PROGRAMADA:</b>
						<a>{{date('d/m/Y', strtotime($t->fecha_prog))}}</a>
					</div>
					<div>
						<b>DESCRIPCIÓN:</b>
						<a>{{($t->descripcion)}}</a>
					</div>
				</p>
			  </div>

			 	@if($t->status == '0')
				<div class="progress">
				  <div class="progress-bar progress-bar-striped bg-warning" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" data-placement="top" title="Pendiente">				  	
				  </div>
				</div>
				@endif

				@if($t->status == '1')
					<div class="progress">
					  <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" data-placement="top" title="Completada">				  	
					  </div>
					</div>
				@endif		
				
			  <div class="card-footer text-muted p-0">
			    <table class="table mtop16">
	                <thead class="table-dark">                	
	                    <tr>
		                    <td>PRODUCTO</td>		                    
		                    <td>CANTIDAD SOLICITADA</td>
		                    <td>CANTIDAD USADA</td>
	                    </tr>
	                </thead>
	                <tbody>
	                	@foreach($t->detalle as $value)
							<tr>
								<td>{{$value->prods[0]->name}}</td>
								<td>{{$value->cantidad_req}}</td>
								<td>{{$value->cantidad_usada}}</td>								
							</tr>
						@endforeach
	                </tbody>                
	            </table>
			  </div>

			</div>		
		</div>
	</div>
</div>
@endsection
