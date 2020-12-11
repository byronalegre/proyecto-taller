@extends ('admin.master')

@section ('title','Inicio')

@section('content')
 
<div class="container-fluid" oncontextmenu="return false" onkeydown="return false;" onmousedown="return false;">
@if(kvfj(Auth::user()->permisos, 'estadisticas_rapidas'))	
	<div class="panel shadow">
		<div class="header">
			<h2 class="title"><i class="fas fa-chart-line"></i> Estadísticas rápidas</h2>
		</div>
		<div class="inside">			
			<div class="btn-group btn-group-lg" role="group">			

				@if(kvfj(Auth::user()->permisos, 'e_tareas'))		
						<a href="{{url('/admin/piezas/1')}}" type="button" class="btn btn-primary shadow info" data-toggle="tooltip" data-placement="top" title="Piezas activas">
							<i class="fas fa-cogs fa-3x mtop16" data-toggle="tooltip" data-placement="top" title="Piezas activas"></i>
							<span class="big-count badge rounded-pill mtop16">
								{{$piezas_act}}
							</span>
						</a>
						<a href="{{url('/admin/tareas/0')}}" type="button" class="btn btn-success shadow info" data-toggle="tooltip" data-placement="top" title="Tareas pendientes">
							<i class="fas fa-clipboard-list fa-3x mtop16" data-toggle="tooltip" data-placement="top" title="Tareas pendientes"></i>
							<span class="big-count badge rounded-pill mtop16">
								{{$pendiente}}
							</span>
						</a>
				@endif

				@if(kvfj(Auth::user()->permisos, 'e_compras'))					
						<a href="{{url('/admin/compras/all')}}" type="button" class="btn btn-info shadow info" data-toggle="tooltip" data-placement="top" title="Compras realizadas este mes">
							<i class="fas fa-cart-plus fa-3x mtop16" data-toggle="tooltip" data-placement="top" title="Compras realizadas este mes"></i>
							<span class="big-count badge rounded-pill mtop16">
								{{$compras_mes}}
							</span>
						</a>

						<a type="button" class="btn btn-danger active shadow info" data-toggle="tooltip" data-placement="top" title="Gastos del último mes">
							<i class="fas fa-dollar-sign fa-3x mtop16" data-toggle="tooltip" data-placement="top" title="Gastos del último mes"></i>
							<span class="big-count badge rounded-pill mtop16">
								<input type="hidden" id="all_prods" value="{{$compras}}"> 						
								<h3 style="font-weight: bold">$ </h3>								
							</span>
						</a>
				@endif
			</div>
		</div>
	</div>
	@if(kvfj(Auth::user()->permisos, 'graficos'))
		<div class="panel shadow mtop16">
				<div class="header">
					<h2 class="title"><i class="fas fa-chart-pie"></i> Gráficos</h2>
				</div>
			<div class="inside">
				<div style="justify-content: center" class="row">
					<!--DESDE ACA LOS GRAFICOS-->
							<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
						    <script type="text/javascript">
						      google.charts.load('current', {'packages':['corechart']});
						      google.charts.setOnLoadCallback(drawChart);

						     function drawChart() {

						     	@if(kvfj(Auth::user()->permisos, 'e_tareas'))
							       var data = google.visualization.arrayToDataTable([
							          ['Tipo', 'Cantidad'],
							          ['Pendientes', {{$pendiente}}],
							          ['Completadas', {{$completada}}],
							        ]);

							        var options = {
							          title: 'Tareas total: {{count($tareas)}}',
							          slices: {
									            0: { color: '#21856d', offset: 0.1},
									            1: { color: '#212121' }
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
							          title: 'Piezas total: {{count($piezas)}}',
							          slices: {
									            0: { color: '#21856d', offset: 0.1},
									            1: { color: '#212121' }
									          },
									  is3D: true
							        };

							        var chart = new google.visualization.PieChart(document.getElementById('piechart2'));

							        chart.draw(data2, options2);
						        @endif					        
						        
						      }
						    </script>

						    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
						    <script type="text/javascript">
						      google.charts.load('current', {'packages':['bar']});
						      google.charts.setOnLoadCallback(drawChart);

						      function drawChart() {
						        @if(kvfj(Auth::user()->permisos, 'e_compras'))
						        var data3 = google.visualization.arrayToDataTable([
						          ['Compras', 'Cantidad del mes'],
						          ['Enero', {{$compra_1}}],
						          ['Febrero', {{$compra_2}}],
						          ['Marzo', {{$compra_3}}],
						          ['Abril', {{$compra_4}}],
						          ['Mayo', {{$compra_5}}],
						          ['Junio', {{$compra_6}}],
						          ['Julio', {{$compra_7}}],
						          ['Agosto', {{$compra_8}}],
						          ['Septiembre', {{$compra_9}}],
						          ['Octubre', {{$compra_10}}],
						          ['Noviembre', {{$compra_11}}],
						          ['Diciembre', {{$compra_12}}],

						        ]);

						        var options3 = {
						          /*animation:{
						          	startup: true,
							        duration: 1500,
							        easing: 'in',
							      },*/
						          title: 'Total de compras: {{count($compras)}}',
						          vAxis: {minValue: 0},
						          hAxis: {titleTextStyle: {color: '#21856d'}},							         
						          colors: ['#21856d'],
						          is3D: true
						          
						        };

						        var chart = new google.charts.Bar(document.getElementById('compra_anual'));

						        chart.draw(data3, google.charts.Bar.convertOptions(options3));
						        @endif
						      }
						    </script>
						   
						    @if(kvfj(Auth::user()->permisos, 'e_compras'))
						    <div class="col-md-12" id="compra_anual" style="width: 1000px; height: 300px; min-width: 250px"></div> 
						    @endif
						    <hr class="mtop16">
						    @if(kvfj(Auth::user()->permisos, 'e_tareas'))						    
						    <div class="col-md-3" id="piechart2" style="width: 500px; height: 300px;"></div>	
						    <div class="col-md-3" id="piechart" style="width: 500px; height: 300px;"></div>
						    @endif

						    
					<!--HASTA ACA-->
				</div>
			</div>
		</div>
	@endif
@endif
</div>
@endsection
