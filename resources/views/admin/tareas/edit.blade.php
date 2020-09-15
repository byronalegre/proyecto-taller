@extends ('admin.master')

@section ('title','Editar tarea')


@section('breadcrumb')
<li class="breadcrumb-item">
	<a href="{{url('/admin/tareas/all') }}"><i class="fas fa-tasks"></i> Tareas</a>
</li>
<li class="breadcrumb-item">
	<a href="{{url('/admin/tareas/'.$t->id.'/detalle') }}"><i class="fas fa-info-circle"></i> Detalle tarea: {{$t->codigo}}</a>
</li>
<li class="breadcrumb-item">
	<a href="{{url('/admin/tareas/'.$t->id.'/edit') }}"><i class="fas fa-edit"></i> Editar tarea</a>
</li>
@endsection
 

@section('content')

<div class="container-fluid">
	<div class="panel shadow">
		<div class="header">
			<h2 class="title"><i class="fas fa-edit"></i> Editar tarea</h2>
		</div>
		<div class="inside">
			{!! Form::open(['url' => '/admin/tareas/'.$t->id.'/edit','files'=>true,'id'=>'formulario']) !!}	
				<div class="row">
					<div class="col-md-4">
							<label for="tarea">Tarea:</label>
							<div class="input-group">								
							   		<span class="input-group-text" id="basic-addon1">
							   			<i class="fas fa-tasks"></i>
							   		</span>							   
						    	{!!Form::select('tarea', $tarea, $t->tarea_id, ['class' =>'form-select']) !!}
						    </div>
					</div>
					<div class="col-md-4">
							<label for="codigo">Código:</label>
								<div class="input-group">									
							   		<span class="input-group-text" id="basic-addon1">
							   			<i class="fas fa-barcode"></i>
							   		</span>								    
						    	{!!Form::text('codigo', $t->codigo, ['class' => 'form-control', 'disabled'] ) !!}
						    	</div>
					</div>
					<div class="col-md-4">
							<label for="status">Estado:</label>
								<div class="input-group">									
								   		<span class="input-group-text" id="basic-addon1">
								   			<i class="fas fa-hand-paper"></i>
								   		</span>								   
							    	{!!Form::select('status', ['0'=>'Pendiente','1'=>'Completada'], $t->status, ['class' =>'form-select']) !!}	
								</div>
					</div>
				</div>	
				<div class="row mtop16">
					<div class="col-md-4">
							<label for="fecha_programada">Fecha programada:</label>
								<div class="input-group">									
							   		<span class="input-group-text" id="basic-addon1">
							   			<i class="fas fa-calendar-day"></i>
							   		</span>								    
						    	{!!Form::date('fecha_programada', $t->fecha_prog, ['class' => 'form-control', 'disabled'] ) !!}
						    	</div>
					</div>
				</div>
				<div class="row mtop16">
					<div class="col-md-12">
						<label for="descripcion">Descripción:</label>
						<div class="input-group">
						 	<textarea class="form-control" name="descripcion" rows="3" id="descripcion">{{$t->descripcion}}
						 	</textarea>
					    </div>
					</div>
				</div>
										 
				
				<div class="row mtop16">
					<div class="col-md-12">
						{!! Form::submit('Guardar', ['class' => 'btn btn-success']) !!}
					</div>
				</div>
		</div>
			
		{!!Form::close() !!}
		</div>
	</div>
</div>
@endsection

