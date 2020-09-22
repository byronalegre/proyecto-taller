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
			<div class="btn-group btn-group-lg" role="group">				
				@if(kvfj(Auth::user()->permisos, 'e_admin'))	
						<a href="{{url('/admin/usuarios/all')}}" type="button" class="btn btn-primary shadow info" data-toggle="tooltip" data-placement="top" title="Usuarios">
							<i class="fas fa-users fa-4x mtop16" data-toggle="tooltip" data-placement="top" title="Usuarios"></i>
							<span class="big-count badge rounded-pill bg-dark mtop16">
								{{count($users)}}							    
							</span>
						</a>
				@endif	

				@if(kvfj(Auth::user()->permisos, 'e_tareas'))		
						<a href="{{url('/admin/piezas/1')}}" type="button" class="btn btn-success shadow info" data-toggle="tooltip" data-placement="top" title="Piezas activas">
							<i class="fas fa-cogs fa-4x mtop16" data-toggle="tooltip" data-placement="top" title="Piezas activas"></i>
							<span class="big-count badge rounded-pill bg-dark mtop16">
								{{$piezas_act}}
							</span>
						</a>
						<a href="{{url('/admin/tareas/0')}}" type="button" class="btn btn-secondary shadow info" data-toggle="tooltip" data-placement="top" title="Tareas pendientes">
							<i class="fas fa-clipboard-list fa-4x mtop16" data-toggle="tooltip" data-placement="top" title="Tareas pendientes"></i>
							<span class="big-count badge rounded-pill bg-dark mtop16">
								{{$pendiente}}
							</span>
						</a>
				@endif

				@if(kvfj(Auth::user()->permisos, 'e_compras'))					
						<a href="{{url('/admin/compras/all')}}" type="button" class="btn btn-info shadow info" data-toggle="tooltip" data-placement="top" title="Compras realizadas">
							<i class="fas fa-cart-plus fa-4x mtop16" data-toggle="tooltip" data-placement="top" title="Compras realizadas"></i>
							<span class="big-count badge rounded-pill bg-dark mtop16">
								{{count($compras)}}
							</span>
						</a>

						<a type="button" class="btn btn-danger active shadow info" data-toggle="tooltip" data-placement="top" title="Gastos del último mes">
							<i class="fas fa-dollar-sign fa-4x mtop16" data-toggle="tooltip" data-placement="top" title="Gastos del último mes"></i>
							<span class="big-count badge rounded-pill bg-dark mtop16">
								<input type="hidden" id="all_prods" value="{{$compras}}"> 						
								<h5>$ </h5>								
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
				<div class="row">
					<!--DESDE ACA LOS GRAFICOS-->
							<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
						    <script type="text/javascript">
						      google.charts.load('current', {'packages':['corechart']});
						      google.charts.setOnLoadCallback(drawChart);

						     function drawChart() {
						     	@if(kvfj(Auth::user()->permisos, 'e_admin'))
						         var data = google.visualization.arrayToDataTable([
						          ['Tipo', 'Cantidad'],
						          ['Usuarios activos',    {{$u_reg}} ],
						          ['Usuarios suspendidos',    {{$u_susp}} ],
						        ]);

						        var options = {
						          title: 'Usuarios total: {{count($users)}}',
						          slices: {
								            0: { color: '#21856d', offset: 0.1},
								            1: { color: '#212121' }
								          },
								  is3D: true
						        };

						        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

						        chart.draw(data, options);
						      @endif
						      @if(kvfj(Auth::user()->permisos, 'e_tareas'))
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
						        @if(kvfj(Auth::user()->permisos, 'e_compras'))
						        var data3 = google.visualization.arrayToDataTable([
						          ['Compras', 'Cantidad por año'],
						          ['2019',     {{$compra_19}}],
						          ['2020',     {{$compra_20	}}],
						          ['2021',     {{$compra_21}}],
						          ['2022',     {{$compra_22}}]
						        ]);

						        var options3 = {
						          animation:{
						          	startup: true,
							        duration: 1500,
							        easing: 'in',
							      },
						          title: 'Total de compras: {{count($compras)}}',
						          vAxis: {minValue: 0},
						          hAxis: {titleTextStyle: {color: '#21856d'}},							         
						          colors: ['#21856d'],
						         /* chartArea:{
						          	backgroundColor: '212121'
						          },*/
						          is3D: true
						          
						        };

						        var chart = new google.visualization.AreaChart(document.getElementById('compra_anual'));

						        chart.draw(data3, options3);
						        @endif
						      }
						    </script>
						   
						    @if(kvfj(Auth::user()->permisos, 'e_compras'))
						    <div id="compra_anual" style="width: 1000px; height: 300px; min-width: 250px"></div>		    
						    <hr>
						    @endif
						    @if(kvfj(Auth::user()->permisos, 'e_admin'))
						    <div id="piechart" style="width: 500px; height: 250px;"></div>
						   	@endif
						   	@if(kvfj(Auth::user()->permisos, 'e_tareas'))
						    <div id="piechart2" style="width: 500px; height: 250px;"></div>	
						    @endif
					<!--HASTA ACA-->
				</div>
			</div>
		</div>
	@endif
@endif
</div>
@endsection
