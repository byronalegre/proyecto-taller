@extends ('admin.master')

@section ('title','Nueva compra')


@section('breadcrumb')
<li class="breadcrumb-item">
	<a href="{{url('/admin/compras/all') }}"><i class="fas fa-cart-plus"></i> Compras</a>
</li>
<li class="breadcrumb-item">
	<a href="{{url('/admin/compras/agregar') }}"><i class="fas fa-plus-circle"></i> Nueva compra</a>
</li>
@endsection
 

@section('content')

<div class="container-fluid">
	<div class="panel shadow">
		<div class="header">
			<h2 class="title"><i class="fas fa-plus-circle"></i> Nueva compra</h2>
		</div>
		<div class="inside">
			{!! Form::open(['url' => '/admin/compras/agregar','files'=>true,'id'=>'formulario']) !!}	
				<div class="row">
					<div class="col-md-4">
							<label for="proveedor">Proveedor:</label>
							<div class="input-group">								
							   		<span class="input-group-text" id="basic-addon1">
							   			<i class="fas fa-truck"></i>
							   		</span>							   
						    	{!!Form::select('proveedor', $provs, null, ['class' =>'form-select']) !!}
						    </div>
					</div>
					<div class="col-md-4">
							<label for="codigo">Código:</label>
								<div class="input-group">									
							   		<span class="input-group-text" id="basic-addon1">
							   			<i class="fas fa-barcode"></i>
							   		</span>								    
						    	{!!Form::text('codigo', null, ['class' => 'form-control', 'placeholder'=>'XXXX'] ) !!}
						    	</div>
					</div>

					<div class="col-md-4">
							<label for="status">Estado:</label>
								<div class="input-group">									
								   		<span class="input-group-text" id="basic-addon1">
								   			<i class="fas fa-hand-paper"></i>
								   		</span>								   
							    	{!!Form::select('status', ['0'=>'Pendiente','1'=>'Aprobado'],0, ['class' =>'form-select']) !!}	
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
							<div class="col-md-4">
								<label for="producto">Producto:</label>
									<div class="input-group">								
									   		<span class="input-group-text">
									   			<i class="fas fa-boxes"></i>
									   		</span>							   
								  	 {!!Form::select('producto', $prods, 0, ['class' =>'form-select','id' => 'producto'] ) !!}
								  	 </select>
								    </div>
							</div>
							<div class="col-md-3">
								<label for="cantidad">Cantidad:</label>
									<div class="input-group">									
								   		<span class="input-group-text">
								   			<i class="fas fa-plus"></i>
								   		</span>	
								   		<input type="number" class="form-control" min="1" name="cantidad" id="cantidad" required="true"> 
							    	</div>
							</div>
							<div class="col-md-3">
								<label for="precio">Precio unitario:</label>
									<div class="input-group">									
								   		<span class="input-group-text">
								   			<i class="fas fa-dollar-sign"></i>
								   		</span>								    
							    		<input type="number" class="form-control" min="1" name="precio" id="precio" required="true">
							    	</div>
							</div>
							<div class="col-md-2">	
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
									<td>Cantidad</td>
									<td>Precio unitario ($)</td>
									<td>Importe ($)</td>
									<td width="100"></td>
								</tr>
							</thead>
							<tbody>
							</tbody>
							<caption>
								<h6>								
								</h6>
							</caption>
						{!! Form::text('productos', 0 ,['class' => 'form-control', 'id'=>'productos', 'hidden'] ) !!}
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

