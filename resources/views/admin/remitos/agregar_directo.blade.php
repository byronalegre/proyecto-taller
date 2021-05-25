@extends ('admin.master')

@section ('title','Nuevo remito')


@section('breadcrumb')
<li class="breadcrumb-item">
	<a href="{{url('/admin/remitos/all') }}"><i class="fas fas fa-file-invoice-dollar"></i> Remitos</a>
</li>
<li class="breadcrumb-item">
	<a href="{{url('/admin/remitos/agregar/'.$id) }}"><i class="fas fa-plus-circle"></i> Nuevo remito</a>
</li>
@endsection
 

@section('content')

<div class="container-fluid" oncontextmenu="return false"><!-- ONCONTEXTMENU DESACTIVA F12-->
	<div class="panel shadow">
		<div class="header">
			<h2 class="title"><i class="fas fa-plus-circle"></i> Nuevo remito</h2>
		</div>
		<div class="inside">
			{!! Form::open(['url' => '/admin/remitos/agregar/'.$id,'files'=>true,'id'=>'formulario']) !!}	
				<div class="row">
					<div class="col-md-6">
							<label for="orden_id">Corresponde a Orden de Compra:</label>
							<div class="input-group">								
							   		<span class="input-group-text" id="basic-addon1">
							   			<i class="fas fa-hashtag"></i>
							   		</span>							   
						    	{!!Form::text('orden_id', $orden->codigo, ['class' =>'form-control', 'id'=>'orden_id', 'readOnly']) !!}
						    </div>
					</div>
					
					<div class="col-md-6">
							<label for="proveedor">Proveedor:</label>
							<div class="input-group">								
							   		<span class="input-group-text" id="basic-addon1">
							   			<i class="fas fa-truck"></i>
							   		</span>							   
						    	{!!Form::select('proveedor', $provs, $orden->proveedor_id, ['class' =>'form-select']) !!}
						    </div>
					</div>
										
					<div class="col-md-12">
						<label for="descripcion" class="mtop16">Descripción:</label>
						<div class="input-group">
						 	<textarea class="form-control" name="descripcion" rows="3" id="descripcion"></textarea>
					    </div>
					</div>
				</div>
				<hr>
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
								  	 {!!Form::select('producto', $prods, null, ['class' =>'form-select','id' => 'producto', 'placeholder'=>'Seleccione un item'] ) !!}
								  	 </select>
								    </div>
							</div>
							<div class="col-md-3">
								<label for="cantidad">Cantidad:</label>
									<div class="input-group">									
								   		<span class="input-group-text">
								   			<i class="fas fa-plus"></i>
								   		</span>	
								   		<input type="number" class="form-control" min="1" name="cantidad" id="cantidad"> 
							    	</div>
							</div>
							<div class="col-md-3">
								<label for="precio">Precio unitario:</label>
									<div class="input-group">									
								   		<span class="input-group-text">
								   			<i class="fas fa-dollar-sign"></i>
								   		</span>								    
							    		<input type="number" class="form-control" min="1" name="precio" id="precio" step="any">
							    	</div>
							</div>
							<div class="col-md-1">	
								<button style="border-radius: 20px" id="agregar" class="btn btn-warning mtop16 shadow" data-toggle="tooltip" data-placement="top" title="Agregar">
									<i class="fas fa-plus"></i>
								</button>
							</div>	
						</div>
						<hr>
						<table class="table table-bordered mtop16">
							<thead class="table-secondary">
								<tr>
									<td>Producto</td>
									<td style="text-align: right;">Cantidad</td>
									<td style="text-align: right;">Precio unitario ($)</td>
									<td style="text-align: right;">Importe ($)</td>
									<td width="100"></td>
								</tr>
							</thead>
							<tbody>
							</tbody>
							<caption>
								<h5>								
								</h5>
							</caption>
						{!! Form::text('productos', $orden ,['class' => 'form-control', 'id'=>'productos', 'hidden'] ) !!}
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

