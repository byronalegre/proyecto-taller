@extends ('admin.master')

@section ('title','Tareas')

@section('breadcrumb')
<li class="breadcrumb-item">
	<a href="{{url('/admin/tareas/all') }}"><i class="fas fa-cart-plus"></i> Tareas</a>
</li>
<li class="breadcrumb-item">
	<a href="{{url('/admin/tareas/'.$t->id.'/detalle') }}"><i class="fas fa-info-circle"></i> Detalle tarea: {{$t->codigo}}</a>
</li>

@endsection

@section('content')

<div class="container-fluid">
	<div class="panel shadow">
		<div class="header">
			<h2 class="title"><i class="fas fa-info-circle"></i> Detalle</h2>
		</div>
		<div class="inside">
			<div style="text-align: right">	
				@if($t->status != '1')		
					@if(kvfj(Auth::user()->permisos, 'tareas_editar'))
						@if(is_null($t->deleted_at))
							<a class="btn btn-primary btn-sm" href="{{url('admin/tareas/'.$t->id.'/edit') }}"data-toggle="tooltip" data-placement="top" title="Editar">
							<i class="fas fa-edit"></i>
							</a>
						@endif
					@endif
				@endif
				@if(kvfj(Auth::user()->permisos, 'detalle_tarea_pdf'))
					<a href="{{url('admin/tareas/'.$t->id.'/detalle/tarea_pdf')}}" data-toggle="tooltip" data-placement="top" title="Generar PDF" class="btn btn-danger btn-sm">
						PDF <i class="far fa-file-pdf"></i>
					</a>
				@endif
			</div>
			
			<div class="mtop16">
				<b>TAREA:</b>
				<a>{{$t->work->name}}</a>
			</div>
			<div>
				<b>CODIGO:</b>
				<a>ODT-{{$t->codigo}}</a>
			</div>
			<hr>
			<div>
				<b>FECHA SOLICITUD:</b>
				<a>{{$t->created_at->format('d/m/Y')}}</a>
			</div>
			<div>
				<b>FECHA PROGRAMADA:</b>
				<a>{{date('d/m/Y', strtotime($t->fecha_prog))}}</a>
			</div>
			<hr>
			<div>
				<b>DESCRIPCIÓN:</b>
				<a>{{($t->descripcion)}}</a>
			</div>
			<hr>
			@if($t->status == '0')
				<div class="progress mtop16">
				  <div class="progress-bar progress-bar-striped bg-warning" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" data-placement="top" title="Pendiente">				  	
				  </div>
				</div>
			@endif
			@if($t->status == '1')
				<div class="progress mtop16">
				  <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" data-placement="top" title="Completada">				  	
				  </div>
				</div>
			@endif											

			<table class="table mtop16">
                <thead class="table-dark">                	
                    <tr>
	                    <td>PRODUCTO</td>
	                    <td>CANTIDAD</td>
                    </tr>
                </thead>
                <tbody>
                	@foreach($a as $value)
						<tr>
							<td>{{$value['producto']}}</td>
							<td>{{$value['cantidad']}}</td>
						</tr>
					@endforeach
                </tbody>                
            </table>
		</div>
	</div>
</div>
@endsection
