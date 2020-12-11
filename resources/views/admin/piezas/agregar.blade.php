@extends ('admin.master')

@section ('title','Agregar pieza')


@section('breadcrumb')
<li class="breadcrumb-item">
	<a href="{{url('/admin/piezas/1') }}"><i class="fas fa-cog"></i> Piezas</a>
</li>
<li class="breadcrumb-item">
	<a href="{{url('/admin/piezas/agregar') }}"><i class="fas fa-plus-circle"></i> Agregar pieza</a>
</li>
@endsection
 

 @section('content')

<div class="container-fluid">
	<div class="panel shadow">
		<div class="header">
			<h2 class="title"><i class="fas fa-plus-circle"></i> Agregar pieza</h2>
		</div>
		<div class="inside">
			{!! Form::open(['url' => '/admin/piezas/agregar','files'=>true]) !!} 
			
				<div class="row">
					<div class="col-md-6">
						<label for="title">Nombre de pieza:</label>
						<div class="input-group">							
						   	<span class="input-group-text" id="basic-addon1">
						   		<i class="fas fa-keyboard"></i>
						   	</span>						    
					    	{!!Form::text('name', null, ['class' => 'form-control']) !!}
					    </div>
					</div>
					<div class="col-md-3">
							<label for="codigo">Código:</label>
								<div class="input-group">									
							   		<span class="input-group-text" id="basic-addon1">
							   			<i class="fas fa-barcode"></i>
							   		</span>								    
						    	{!!Form::text('codigo', null, ['class' => 'form-control', 'placeholder'=>'XXX-XXXX'] ) !!}
						    	</div>
					</div>
					<div class="col-md-3">
						<label for="img">Imagen:</label>
						<div class="form-file">
							{!!Form::file('img', ['class' => 'form-file-input', 'id'=>'formFile', 'accept'=> 'image/*']) !!}
							<label class="form-file-label" for="formFile">
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
						    	{!!Form::number('cantidad-min', 0, ['class' => 'form-control', 'min' => '0.0'] ) !!}
						    	</div>
						</div>
						
						<div class="col-md-3">
							<label for="cantidad">Cantidad:</label>
								<div class="input-group">									
								   		<span class="input-group-text" id="basic-addon1">
								   			<i class="fas fa-boxes"></i>
								   		</span>								    
						    	{!!Form::number('cantidad', 0, ['class' => 'form-control', 'min' => '0.0'] ) !!}
						    	</div>
						</div>
						
						<div class="col-md-3">
								<label for="title">Marca:</label>
								<div class="input-group">								
								   		<span class="input-group-text" id="basic-addon1">
								   			<i class="far fa-copyright"></i>
								   		</span>							   
							    	{!!Form::select('marca', $marca, 0, ['class' =>'form-select']) !!}
							    </div>
						</div>	

					<div class="col-md-3">
						<label for="categoria">Categoría:</label>
						<div class="input-group">							
						   		<span class="input-group-text" id="basic-addon1">
						   			<i class="fas fa-tag"></i>
						   		</span>						    
					    	{!!Form::select('categoria', $cats, 0, ['class' =>'form-select']) !!}				    		
						</div>
					</div>				
							
				</div>

				<div class="row mtop16">
					<div class="col-md-3">
							<label for="deposito">Número de depósito:</label>
							<div class="input-group">									
							   		<span class="input-group-text" id="basic-addon1">
							   			<i class="fas fa-map-marker-alt"></i>
							   		</span>								   
						    	{!!Form::select('deposito', ['1'=>'1','2'=>'2'], 1, ['class' =>'form-select']) !!}
							</div>
					</div>	

					<div class="col-md-3">
							<label for="status">Estado:</label>
							<div class="input-group">									
							   		<span class="input-group-text" id="basic-addon1">
							   			<i class="fas fa-eye"></i>
							   		</span>								   
						    	{!!Form::select('status', ['0'=>'Invisible','1'=>'Visible'],0, ['class' =>'form-select']) !!}							    		
							</div>
					</div>
				</div>
				<!--
				<div class="row mtop16">
					<div class="col-md-12">
							<label>Composición:</label>
							<div class="input-group">
								@foreach($all as $p)
									<div class="form-check form-check-inline">
										<input class="form-check-input" type="radio" id="flexCheckDefault" value="true">
										<label class="form-check-label" for="flexCheckDefault">{{$p->name}}</label>
									</div>
								@endforeach
							</div>
					</div>
				</div>
				-->
				<hr>
				<div class="row mtop16">
					<div class="col-md-12">
						<label for="content">Descripción:</label>
						{!!Form::textarea('content', null, ['class' => 'form-control', 'id' => 'editor'] ) !!}
					</div>
				</div>

				<div class="row mtop16" >
					<div class="col-md-12">
						{!! Form::submit('Guardar', ['class' => 'btn btn-success']) !!}
					</div>
				</div>
		</div>
			
			{!!Form::close() !!}
		</div>
	</div>
@endsection