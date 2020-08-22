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
				<div class="col-md-3 d-flex">
					<a href="{{url('/admin/usuarios/0')}}" type="button" class="btn btn-dark shadow">
						<i class="fas fa-users fa-2x mtop16"></i>
							Usuarios registrados 
						<span class="big-count badge rounded-pill bg-secondary mtop16">
							{{$u_reg}}
						</span>
					</a>
				</div>
				<div class="col-md-3 d-flex">
					<a href="{{url('/admin/piezas/1')}}" type="button" class="btn btn-dark shadow">
						<i class="fas fa-cogs fa-2x mtop16"></i>
							Piezas activas 
						<span class="big-count badge rounded-pill bg-secondary mtop16">
							{{$piezas_act}}
						</span>
					</a>
				</div>
				@if(kvfj(Auth::user()->permisos, 'facturado'))
				
					<div class="col-md-3 d-flex">
						<a href="{{url('/admin/compras')}}" type="button" class="btn btn-dark shadow">
							<i class="fas fa-receipt fa-2x mtop16"></i>
								Compras realizadas 
							<span class="big-count badge rounded-pill bg-secondary mtop16">
								{{count($compras)}}
							</span>
						</a>
					</div>

					<div class="col-md-3 d-flex">
						<a type="button" class="btn btn-dark shadow">
							<i class="fas fa-cash-register fa-2x mtop16"></i>
								Gasto 
							<span class="big-count badge rounded-pill bg-secondary mtop16">

								<input type="hidden" id="all_prods" value="{{$compras}}"> 						
								<h5>$ </h5>								
							</span>
						</a>
					</div>
				@endif
			</div>
			</div>
		</div>
			<div class="panel shadow mtop16">
				<div class="header">
					<h2 class="title"><i class="fas fa-chart-pie"></i> Gráficos</h2>
				</div>
			<div class="inside">
				<div class="row">
						<!--DESDE ACA LOS GRAFICOS-->
								<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
							    <script type="text/javascript">
							      google.charts.load('current', {'packages':['corechart']});
							      google.charts.setOnLoadCallback(drawChart);

							      function drawChart() {

							        var data = google.visualization.arrayToDataTable([
							          ['Tipo', 'Cantidad'],
							          ['Usuarios registrados',     {{$u_reg}}],
							          ['Usuarios suspendidos',     {{$u_susp}}],
							        ]);

							        var options = {
							          title: 'Usuarios total: {{$users}}',
							          slices: {
									            0: { color: '#21856d', offset: 0.1},
									            1: { color: 'grey' }
									          },
									  is3D: true
							        };

							        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

							        chart.draw(data, options);
							      
							        var data2 = google.visualization.arrayToDataTable([
							          ['Piezas', 'Cantidad'],
							          ['Piezas activas',     {{$piezas_act}}],
							          ['Piezas inactivas',     {{$piezas_inact}}],
							        ]);

							        var options2 = {
							          title: 'Piezas total: {{$piezas}}',
							          slices: {
									            0: { color: '#21856d', offset: 0.1},
									            1: { color: 'grey' }
									          },
									  is3D: true
							        };

							        var chart = new google.visualization.PieChart(document.getElementById('piechart2'));

							        chart.draw(data2, options2);
							      }
							    </script>
							    <div id="piechart" style="width: 500px; height: 250px;"></div>
							    <div id="piechart2" style="width: 500px; height: 250px;"></div>	
						<!--HASTA ACA-->
					</div>
				</div>
		</div>
	
	@endif
</div>
@endsection
