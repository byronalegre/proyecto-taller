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
							<label for="codigo">Código:</label>
							<div class="input-group">									
						   		<span class="input-group-text" id="basic-addon1">
						   			<i class="fas fa-barcode"></i>
						   		</span>								    
					    	{!!Form::text('codigo', $t->codigo, ['class' => 'form-control', 'id' => 'orden_id', 'disabled'] ) !!}
					    	</div>
					</div>

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

				<div class="panel shadow">
					<div class="header mtop16">
						<h2 class="title">Agregar producto</h2>
					</div>
					<div class="inside">						
						<div class="row">
							<div class="col-md-7">
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
							<div class="col-md-3">
								<label for="cantidad">Cantidad solicitada:</label>
								<div class="input-group">									
							   		<span class="input-group-text">
							   			<i class="fas fa-minus"></i>
							   		</span>	
							   		<input type="number" class="form-control" min="1" max="{{ $prods }}" name="cantidad" id="cantidad"> 
						    	</div>
							</div>

							<div class="col-md-1">	
								<button style="border-radius: 20px" id="agregar_item" class="btn btn-warning mtop16 shadow" data-toggle="tooltip" data-placement="top" title="Agregar">
									<i class="fas fa-plus"></i>
								</button>
							</div>
							@if(kvfj(Auth::user()->permisos, 'piezas'))
							<div class="col-md-1">	
								<button type="button" class="btn btn-primary mtop16" data-bs-toggle="modal" data-bs-target="#exampleModal">
								  <i class="fas fa-bars" data-toggle="tooltip" title="Ver listado de piezas"></i>
								</button>

								<!-- Modal -->
								<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
								  <div class="modal-dialog modal-lg">
								    <div class="modal-content">
								      <div class="modal-header bg-dark text-white">
								        <h5 class="modal-title" id="exampleModalLabel">Listado de piezas y cantidades</h5>
								        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
								      </div>
								      <div class="modal-body p-0">
								        <table class="table table-bordered table-hover mb-0" width="100%">
								        	<tbody>
								        		<thead class="table-secondary">
								        			<tr>
								        				<td>Nombre</td>
								        				<td style="text-align: right;">Cantidad Minima</td>
								        				<td style="text-align: right;">Cantidad</td>
								        				<td style="text-align: right;">Reservadas</td>
								        			</tr>
								        		</thead>
								        		@foreach($prods as $a)									        			
									        		@if(($a->cantidad_min > $a->cantidad)&&($a->cantidad != 0))							        		
										        		<tr class="table-warning">								        			
										        			<td>{{$a->name}}</td>
										        			<td style="text-align: right;">{{$a->cantidad_min}}</td>
										        			<td style="text-align: right;">{{$a->cantidad}}</td>
										        			@if($a->reserve == '[]')
																<td style="text-align: right;">-</td>
															@else
																@foreach($array_r as $i)
																	@if($a->id == $i['pieza_id'])
																		@if($i['cantidad_req'] != 0)
																			<td style="text-align: right;">{{ $i['cantidad_req'] }}</td>
																		@endif
																	@endif
																@endforeach
															@endif
										        		</tr>
									        		@endif
									        		@if($a->cantidad == 0)							        		
										        		<tr class="table-danger">								        			
										        			<td>{{$a->name}}</td>
										        			<td style="text-align: right;">{{$a->cantidad_min}}</td>
										        			<td style="text-align: right;">{{$a->cantidad}}</td>
										        			@if($a->reserve == '[]')
																<td style="text-align: right;">-</td>
															@else
																@foreach($array_r as $i)
																	@if($a->id == $i['pieza_id'])
																		@if($i['cantidad_req'] != 0)
																			<td style="text-align: right;">{{ $i['cantidad_req'] }}</td>
																		@endif
																	@endif
																@endforeach
															@endif
										        		</tr>
									        		@endif
									        		@if($a->cantidad_min <= $a->cantidad)
									        			<tr>								        			
										        			<td>{{$a->name}}</td>
										        			<td style="text-align: right;">{{$a->cantidad_min}}</td>
										        			<td style="text-align: right;">{{$a->cantidad}}</td>
										        			@if($a->reserve == '[]')
																<td style="text-align: right;">-</td>
															@else
																@foreach($array_r as $i)
																	@if($a->id == $i['pieza_id'])
																		@if($i['cantidad_req'] != 0)
																			<td style="text-align: right;">{{ $i['cantidad_req'] }}</td>
																		@endif
																	@endif
																@endforeach
															@endif
										        		</tr>
										        	@endif
								        		@endforeach
								        	</tbody>

								        	<caption class="text-warning mx-2 p-0" style="text-align: right;">Bajo Stock <button disabled="true" class="btn btn-warning"></button></caption>
								        	<caption class="text-danger mx-2 p-0" style="text-align: right;">Sin Stock <button disabled="true" class="btn btn-danger"></button></caption>
								        	
								        </table>
								      </div>
								      <div class="modal-footer">
								        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
								      </div>
								    </div>
								  </div>
								</div>
							</div>
							@endif	
						</div>
						<hr>
						<table class="table table-bordered mtop16" id="tabla">
							<thead class="table-secondary">
								<tr>
									<td>Producto</td>
									<td style="text-align: center;">Cantidad solicitada</td>
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

