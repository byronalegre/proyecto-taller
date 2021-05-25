@extends ('admin.master')

@section ('title','Completar tarea')


@section('breadcrumb')
<li class="breadcrumb-item">
	<a href="{{url('/admin/tareas/all') }}"><i class="fas fa-tasks"></i> Tareas</a>
</li>
<li class="breadcrumb-item">
	<a href="{{url('/admin/tareas/'.$t->id.'/detalle') }}"><i class="fas fa-info-circle"></i> Detalle tarea: {{$t->codigo}}</a>
</li>
<li class="breadcrumb-item">
	<a href="{{url('/admin/tareas/'.$t->id.'/complete') }}"><i class="fas fa-check"></i> Completar tarea</a>
</li>
@endsection
 

@section('content')

<div class="container-fluid">
	<div class="panel shadow">
		<div class="header">
			<h2 class="title"><i class="fas fa-check"></i> Completar tarea</h2>
		</div>
		<div class="inside">
			{!! Form::open(['url' => '/admin/tareas/'.$t->id.'/complete','files'=>true,'id'=>'formulario']) !!}	
				<div class="row">
					<div class="col-md-4">
							<label for="codigo">Código:</label>
							<div class="input-group">									
						   		<span class="input-group-text" id="basic-addon1">
						   			<i class="fas fa-barcode"></i>
						   		</span>								    
					    	{!!Form::text('codigo', $t->codigo, ['class' => 'form-control', 'id' => 'orden_id', 'disabled'] ) !!}
					    	</div>
					</div>

					{{-- <div class="col-md-2">
							<label for="status">Estado:</label>
							<div class="input-group">									
							   		<span class="input-group-text" id="basic-addon1">
							   			<i class="fas fa-hand-paper"></i>
							   		</span>								   
						    	{!!Form::select('status', ['0'=>'Pendiente','1'=>'Completada'], $t->status, ['class' =>'form-select']) !!}	
							</div>
					</div> --}}

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
						 	<textarea class="form-control" name="descripcion" rows="3" id="descripcion">{{$t->descripcion}}</textarea>
					    </div>
					</div>
				</div>

				<div class="row mtop16" style="justify-content: center;">
					<div class="col-md-6">
						<div class="card border-warning border-3" id="card_check" style="display: none;">	
							<div class="card-header">Detalle solicitud</div>						
							<div class="card-body p-0">								
								<table class="table mb-0" style="text-align: center;" id="tablaTarea">
									<thead class="bg-light">
										<td>Productos solicitados</td>
										{{-- <td>Cantidad requerida</td> --}}
										<td width="100">Incluido</td>
									</thead>
									<tbody>
										
									</tbody>
								</table>
							</div>
														
						</div>						
					</div>					
				</div>

				<div class="panel shadow">
					<div class="header mtop16">
						<h2 class="title">Agregar producto</h2>
					</div>
					<div class="inside">						
						<div class="row">
							<div class="col-md-5">
								<label for="producto">Producto:</label>
								<div class="input-group">								
								   		<span class="input-group-text">
								   			<i class="fas fa-boxes"></i>
								   		</span>							   
							  	 {{-- {!!Form::select('producto', $prods->pluck('name','id'), null, ['class' =>'form-select','id' => 'producto', 'placeholder'=>'Seleccione un item'] ) !!} --}}

							  	 <select name="producto" id="producto" class="form-select">
							  	 	<option value="" selected>Seleccione un item</option>
							  	 	
							  	 	@foreach($prods as $p)							  	 		
							  	 		<option value="{{$p->id}}">{{$p->name.' ['}}
							  	 			@if($p->reserve == '[]')
												{{ $p->cantidad }}
											@else						
							  	 				@foreach($array_r as $a)
													@if($p->id == $a['pieza_id'])
														@foreach($t->detalle as $ot)
															@if($p->id == $ot->pieza_id)
																{{ ($p->cantidad - $a['cantidad_req']) + $ot->cantidad_req}}
															@break(2)
															@endif
														@endforeach	

														@if($a['cantidad_req'] != 0)	
															{{ $p->cantidad - $a['cantidad_req'] }}
														@endif
													@endif
												@endforeach												
											@endif

							  	 		{{']'}}</option>
							  	 	@endforeach
							  	 	
							  	 </select>

							    </div>
							</div>
							<div class="col-md-5">
								<label for="cantidad_usada">Cantidad utilizada:</label>
								<div class="input-group">									
							   		<span class="input-group-text">
							   			<i class="fas fa-minus"></i>
							   		</span>	
							   		<input type="number" class="form-control" min="1" max="{{ $prods }}" name="cantidad_usada" id="cantidad_usada"> 
						    	</div>
							</div>

							<div class="col-md-1">	
								<button style="border-radius: 20px" id="agregar_item" class="btn btn-warning mtop16 shadow" data-toggle="tooltip" data-placement="top" title="Agregar">
									<i class="fas fa-plus"></i>
								</button>
							</div>	
							<div class="col-md-1">	
								<button style="border-radius: 20px" id="fila_hide" class="btn btn-primary mtop16 shadow" data-toggle="tooltip" data-placement="top" title="Mostrar detalle solicitud" type="button">
									<i class="fas fa-eye"></i>
								</button>
							</div>
						</div>
						<hr>
						<table class="table table-bordered mtop16" id="tabla">
							<thead class="table-secondary">
								<tr>
									<td>Producto</td>
									<td style="text-align: center;" >Cantidad utilizada</td>
									<td width="100"></td>
								</tr>
							</thead>
							<tbody>
							</tbody>
						{!! Form::text('productos', $t ,['class' => 'form-control', 'id'=>'productos', 'hidden'] ) !!}
						</table>						
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

