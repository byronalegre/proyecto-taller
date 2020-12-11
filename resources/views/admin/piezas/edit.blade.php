@extends ('admin.master')

@section ('title','Editar pieza')


@section('breadcrumb')
<li class="breadcrumb-item">
	<a href="{{url('/admin/piezas/1') }}"><i class="fas fa-cog"></i> Piezas</a>
</li>
<li class="breadcrumb-item">
	<a href="{{url('/admin/piezas/1') }}"><i class="fas fa-edit"></i> Editar pieza</a>
</li>
@endsection
 

 @section('content')

<div class="container-fluid">
	<div class="row">
				<div class="col-md-9">
					
					<div class="panel shadow">
						<div class="header">
							<h2 class="title"><i class="fas fa-edit"></i> Editar pieza</h2>
						</div>
						<div class="inside">
							{!! Form::open(['url' => 'admin/piezas/'.$p->id.'/edit','files'=>true]) !!} 
							
								<div class="row">
									<div class="col-md-6">
										<label for="title">Nombre de pieza:</label>	
										<div class="input-group">										
										   	<span class="input-group-text" id="basic-addon1">
										   		<i class="fas fa-keyboard"></i>
										   	</span>								    
									    	{!!Form::text('name', $p->name, ['class' => 'form-control']) !!}
									    </div>			    
									</div>
									<div class="col-md-3">
											<label for="codigo">Código:</label>
											<div class="input-group">													
											   		<span class="input-group-text" id="basic-addon1">
											   			<i class="fas fa-barcode"></i>
											   		</span>												   
									    	{!!Form::text('codigo', $p->codigo, ['class' => 'form-control'] ) !!}
									    	</div>
									</div>

									<div class="col-md-3">
										<label for="img">Imagen:</label>
										<div class="form-file">
											{!!Form::file('img', ['class' => 'form-file-input', 'id'=>'formFile', 'accept'=> 'image/*']) !!}
											<label class="form-file-label" for="customFile">
										    <span class="form-file-text">Selecciona una imagen</span>
										    <span class="form-file-button">Elegir</span>
										  	</label>
										</div>
									</div>

								</div>

								<div class="row mtop16">
										<div class="col-md-3">
											<label for="cantidad-min">Cantidad mínima:</label>
											<div class="input-group">													
											   		<span class="input-group-text" id="basic-addon1">
											   			<i class="fas fa-exclamation-triangle"></i>
											   		</span>												   
									    	{!!Form::number('cantidad-min', $p->cantidad_min, ['class' => 'form-control', 'min' => '0'] ) !!}
									    	</div>
										</div>
										<div class="col-md-3">
											<label for="cantidad">Cantidad:</label>
											<div class="input-group">													
											   		<span class="input-group-text" id="basic-addon1">
											   			<i class="fas fa-boxes"></i>
											   		</span>												   
									    	{!!Form::number('cantidad', $p->cantidad, ['class' => 'form-control', 'min' => '0'] ) !!}
									    	</div>
										</div>
										<div class="col-md-3">
											<label for="marca">Marca:</label>
											<div class="input-group">											
											   		<span class="input-group-text" id="basic-addon1">
											   			<i class="far fa-copyright"></i>
											   		</span>											   
										    	{!!Form::select('marca', $marca, $p->categoria_id, ['class' =>'form-select']) !!}
										    </div>
										</div>
										
										<div class="col-md-3">
										<label for="categoria">Categoría:</label>
										<div class="input-group">												
										   		<span class="input-group-text" id="basic-addon1">
										   			<i class="fas fa-tag"></i>
										   		</span>											   
									    	{!!Form::select('categoria', $cats, $p->categoria_id, ['class' =>'form-select']) !!}										    		
										</div>
										</div>									
											
								</div>

								<div class="row mtop16">
									<div class="col-md-3">
											<label for="deposito">Depósito N°:</label>
											<div class="input-group">									
											   		<span class="input-group-text" id="basic-addon1">
											   			<i class="fas fa-map-marker-alt"></i>
											   		</span>								   
										    	{!!Form::select('deposito', ['1'=>'1','2'=>'2'], $p->deposito, ['class' =>'form-select']) !!}							    		
											</div>
									</div>
									<div class="col-md-3">
											<label for="status">Estado:</label>
											<div class="input-group">													
											   		<span class="input-group-text" id="basic-addon1">
											   			<i class="fas fa-eye"></i>
											   		</span>												   
										    	{!!Form::select('status', ['0'=>'Invisible','1'=>'Visible'],$p->status, ['class' =>'form-select']) !!}					    		
											</div>
									</div>
								</div>
								<hr>
								<div class="row mtop16">
									<div class="col-md-12">
										<label for="content">Descripción:</label>
										{!!Form::textarea('content', $p->content, ['class' => 'form-control', 'id' => 'editor'] ) !!}
									</div>
								</div>

								<div class="row mtop16" >
									<div class="col-md-12">
										{!! Form::submit('Guardar', ['class' => 'btn btn-success']) !!}
									</div>
								</div>						
							
							{!!Form::close() !!}
						</div>
					</div>
				</div>
	
		
				<div class="col-md-3">
					<div class="panel shadow">
						<div class="header">
							<h2 class="title"><i class="fas fa-image"></i> Imagen</h2>
						</div>
						<div class="inside">
								<img src="{{ url('/uploads/'.$p->file_path.'/'.$p->image) }}" class="img-fluid">
						</div>
					</div>
				</div>
	</div>
</div>

@endsection