@extends ('admin.master')

@section ('title','Inicio')

@section('content')
<div class="container-fluid">
	@if(kvfj(Auth::user()->permisos, 'estadisticas_rapidas'))
	
	<div class="panel shadow">
		<div class="header">
			<h2 class="title"><i class="fas fa-chart-line"></i> Estadísticas rápidas</h2>
		</div>
		<div class="inside">
			<div class="row">
				<div class="col-md-3">
					<div class="panel shadow">
						<div class="header">
							<h2 class="title">Usuarios registrados</h2>
						</div>
						<div class="inside">
							<div class="row">
								<div class="col-md-2">
									<i style="color: #005403" class="fas fa-users fa-2x"></i> 
								</div>
								<div class="col-md-10">
									<div class="big-count"> {{$users}}</div>
								</div>
							</div>
							
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="panel shadow">
						<div class="header">
							<h2 class="title">Piezas en lista</h2>
						</div>
						<div class="inside">
							<div class="row">
								<div class="col-md-2">
									<i style="color: #005403" class="fas fa-cogs fa-2x"></i>
								</div>
								<div class="col-md-10">
									<div class="big-count"> {{ $products }}</div>
								</div>
							</div>
							
						</div>
					</div>
				</div>
				@if(kvfj(Auth::user()->permisos, 'facturado'))
				<div class="col-md-3">
					<div class="panel shadow">
						<div class="header">
							<h2 class="title">Pedidos hoy</h2>
						</div>
						<div class="inside">
							<div class="row">
								<div class="col-md-2">
									<i style="color: #005403" class="fas fa-receipt fa-2x"></i>
								</div>
								<div class="col-md-10">
									<div class="big-count"> 155</div>
								</div>
							</div>
							
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="panel shadow">
						<div class="header">
							<h2 class="title">Facturado hoy</h2>
						</div>
						<div class="inside">
							<div class="row">
								<div class="col-md-2">
									<i style="color: #005403" class="fas fa-cash-register fa-2x"></i>
								</div>
								<div class="col-md-10">
									<div class="big-count">$9999999999</div>
								</div>
							</div>
							
						</div>
					</div>
				</div>
				@endif
			</div>
		</div>
	</div>
	@endif
</div>
@endsection