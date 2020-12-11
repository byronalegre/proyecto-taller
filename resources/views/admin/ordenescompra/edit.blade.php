@extends ('admin.master')

@section ('title','Editar Orden de Compra')


@section('breadcrumb')
<li class="breadcrumb-item">
	<a href="{{url('/admin/ordenescompra/') }}"><i class="fas fa-cart-plus"></i> Ordenes de Compra</a>
</li>
<li class="breadcrumb-item">
	<a href="{{url('/admin/ordenescompra/'.$oc->id.'/detalle') }}"><i class="fas fa-info-circle"></i> Detalle Orden de Compra: {{$oc->codigo}}</a>
</li>
<li class="breadcrumb-item">
	<a href="{{url('/admin/ordenescompra/'.$oc->id.'/edit') }}"><i class="fas fa-edit"></i> Editar Orden de Compra</a>
</li>
@endsection
 

@section('content')

<div class="container-fluid">
	<div class="panel shadow">
		<div class="header">
			<h2 class="title"><i class="fas fa-edit"></i> Editar Orden de Compra</h2>
		</div>
		<div class="inside">
			{!! Form::open(['url' => '/admin/ordenescompra/'.$oc->id.'/edit','files'=>true,'id'=>'formulario']) !!}	
				<div class="row">
					
					<div class="col-md-4">
							<label for="codigo">Código:</label>
								<div class="input-group">									
							   		<span class="input-group-text" id="basic-addon1">
							   			<i class="fas fa-barcode"></i>
							   		</span>								    
						    	{!!Form::text('codigo', $oc->codigo, ['class' => 'form-control', 'disabled'] ) !!}
						    	</div>
					</div>
					<div class="col-md-4">
							<label for="proveedor">Proveedor:</label>
								<div class="input-group">									
								   		<span class="input-group-text" id="basic-addon1">
								   			<i class="fas fa-hand-paper"></i>
								   		</span>								   
							    	{!!Form::select('proveedor', $provs ,$oc->proveedor_id,  ['class' =>'form-select', 'disabled']) !!}	
								</div>
					</div>
					<div class="col-md-4">
							<label for="status">Estado:</label>
								<div class="input-group">									
								   		<span class="input-group-text" id="basic-addon1">
								   			<i class="fas fa-hand-paper"></i>
								   		</span>								   
							    	{!!Form::select('status', ['0'=>'Pendiente','1'=>'Aprobada', '2'=>'Completada', '3'=>'Rechazada'], $oc->status, ['class' =>'form-select']) !!}	
								</div>
					</div>
				</div>	
				<div class="row mtop16">
					<div class="col-md-12">
						<label for="descripcion">Descripción:</label>
						<div class="input-group">
						 	<textarea class="form-control" name="descripcion" rows="3" id="descripcion">{{$oc->descripcion}}
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

