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
			<div class="btn-group btn-group w-100" role="group" id="grupo-btn">			

				@if(kvfj(Auth::user()->permisos, 'e_tareas'))		
						{{-- <a href="{{url('/admin/piezas/1')}}" type="button" class="btn text-white shadow info" data-toggle="tooltip" data-placement="top" title="Piezas activas" style="background-color: #AF6D32">
							<i class="fas fa-cogs fa-3x mtop16" data-toggle="tooltip" data-placement="top" title="Piezas activas"></i>
							<span class="big-count badge rounded-pill mtop16">
								{{$piezas_stock_min}}
							</span>
							<div class="more_info">+ info <i class="fas fa-arrow-circle-right"></i></div>
						</a> --}}

						<a href="{{url('/admin/tareas/0')}}" type="button" class="btn btn-warning text-white shadow info" data-toggle="tooltip" data-placement="top" title="Tareas pendientes">
							<i class="fas fa-clock fa-3x mtop16" data-toggle="tooltip" data-placement="top" title="Tareas pendientes"></i>
							<span class="big-count badge rounded-pill mtop16">
								{{$pendiente}}
							</span>
							<div class="more_info">+ info <i class="fas fa-arrow-circle-right"></i></div>
						</a>

						<a href="{{url('/admin/tareas/new')}}" type="button" class="btn text-white shadow info" data-toggle="tooltip" data-placement="top" title="Tareas Nuevas" style="background-color: #2E86C1">
							<i class="fas fa-notes-medical fa-3x mtop16" data-toggle="tooltip" data-placement="top" title="Tareas Nuevas"></i>
							<span class="big-count badge rounded-pill mtop16">
								{{$t_nuevas}}
							</span>
							<div class="more_info">+ info <i class="fas fa-arrow-circle-right"></i></div>
						</a>						
				@endif

				@if(kvfj(Auth::user()->permisos, 'e_compras')||kvfj(Auth::user()->permisos, 'e_tareas'))
						<a href="{{url('/admin/ordenespedido/new')}}" type="button" class="btn text-white shadow info" data-toggle="tooltip" data-placement="top" title="Ordenes de Pedido Nuevas" style="background-color: #AF7AC5">
							<i class="fas fa-hand-holding-medical fa-3x mtop16" data-toggle="tooltip" data-placement="top" title="Ordenes de Pedido Nuevas"></i>
							<span class="big-count badge rounded-pill mtop16">
								{{$op_nuevas}}
							</span>
							<div class="more_info">+ info <i class="fas fa-arrow-circle-right"></i></div>
						</a>

				@endif

				@if(kvfj(Auth::user()->permisos, 'e_compras') || kvfj(Auth::user()->permisos, 'e_tareas'))	
					@if(Auth::user()->role != 4)	
						<a href="{{url('/admin/ordenescompra/new')}}" type="button" class="btn text-white shadow info" data-toggle="tooltip" data-placement="top" title="Ordenes de Compra Nuevas" style="background-color: #E67E22">
							<i class="fas fa-cart-plus fa-3x mtop16" data-toggle="tooltip" data-placement="top" title="Ordenes de Compra Nuevas"></i>
							<span class="big-count badge rounded-pill mtop16">
								{{$oc_nuevas}}
							</span>
							<div class="more_info">+ info <i class="fas fa-arrow-circle-right"></i></div>
						</a>
					@endif
				@endif
				
				@if(kvfj(Auth::user()->permisos, 'e_compras'))
						<a href="{{url('/admin/remitos/new')}}" type="button" class="btn shadow info text-white" data-toggle="tooltip" data-placement="top" title="Remitos nuevos" style="background-color: #85C1E9">
							<i class="fas fa-donate fa-3x mtop16" data-toggle="tooltip" data-placement="top" title="Remitos nuevos"></i>
							<span class="big-count badge rounded-pill mtop16">
								{{$compras_mes}}
							</span>
							<div class="more_info">+ info <i class="fas fa-arrow-circle-right"></i></div>
						</a>

						<a type="button" class="btn btn-secondary shadow info" data-toggle="tooltip" data-placement="top" title="Gastos del último mes" @if(kvfj(Auth::user()->permisos, 'reporte_remitos_mes_pdf')) href="{{ route('reporte_remitos_mes_pdf') }}" target="_blank"@endif>
							<i class="fas fa-dollar-sign fa-3x mtop16" data-toggle="tooltip" data-placement="top" title="Gastos del último mes"></i>
							<span class="big-count badge rounded-pill mtop16">
								{{number_format($total, 2)}}						
							</span>
							@if(kvfj(Auth::user()->permisos, 'reporte_remitos_mes_pdf'))
								<div class="more_info">+ info <i class="fas fa-arrow-circle-right"></i></div>
							@endif
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
							       var data = google.visualization.arrayToDataTable([
							          ['Tipo', 'Cantidad'],
							          ['Pendientes: {{$pendiente}}', {{$pendiente}}],
							          ['Completadas: {{$completada}}', {{$completada}}],
							        ]);

							        var options = {
							          title: 'Total de Tareas del año {{now()->format('Y')}}: {{count($tareas)}}',
							          slices: {
									            0: { color: '#ffc107', offset: 0.02},
									            1: { color: '#198754', offset: 0.02 }
									          },
									  is3D: true
							        };

							        var chartPie1 = new google.visualization.PieChart(document.getElementById('piechart'));

							        chartPie1.draw(data, options);
							   } 
						  </script> 

						  <script type="text/javascript">
						      google.charts.load('current', {'packages':['corechart']});
						      google.charts.setOnLoadCallback(drawChart);
							   function drawChart() { 
							        var data2 = google.visualization.arrayToDataTable([
							          ['Piezas', 'Cantidad'],
							          ['Piezas con stock bajo: {{$piezas_stock_min}}', {{$piezas_stock_min}}],
							          ['Piezas con stock normal: {{$piezas_stock_normal}}', {{$piezas_stock_normal}}],
							          ['Piezas sin stock: {{$piezas_sin_stock}}', {{$piezas_sin_stock}}],
							        ]);

							        var options2 = {
							          title: 'Total de piezas: {{count($piezas)}}',
							          slices: {
									            0: { color: '#ffc107', offset: 0.02},
									            1: { color: '#198754', offset: 0.02 },
									            2: { color: 'red', offset: 0.02 }
									          },
									  is3D: true
							        };

							        var chartPie2 = new google.visualization.PieChart(document.getElementById('piechart2'));

							        chartPie2.draw(data2, options2);
						       	}		
					      </script>

					      <script type="text/javascript">
						      google.charts.load('current', {'packages':['corechart']});
						      google.charts.setOnLoadCallback(drawChart);	        

						        function drawChart() {
							        var data4 = google.visualization.arrayToDataTable([
								          ['Compras', 'Cantidad'],
								          ['Compras Pendientes: {{$c_pend}}', {{$c_pend}}],								         
								          ['Compras Completadas: {{$c_comp}}', {{$c_comp}}],
								          ['Compras Rechazadas: {{$c_rec}}', {{$c_rec}}],
								        ]);

							        var options4 = {
							          title: 'Estado de O. de Compra del último mes del año {{now()->format('Y')}}',
							          slices: {
									            0: { color: '#ffc107', offset: 0.02},
									            // 1: { color: '#0d6efd', offset: 0.02 },
									            1: { color: '#198754', offset: 0.02},
									            2: { color: 'red', offset: 0.02},
									          },
									  is3D: true
							        };

							        var chartPie3 = new google.visualization.PieChart(document.getElementById('piechart4'));

							        chartPie3.draw(data4, options4);
						       
						      }
						  </script>

						  <script type="text/javascript">
						      google.charts.load('current', {'packages':['bar']});
						      google.charts.setOnLoadCallback(drawChart);

						      function drawChart() {
						        @if(kvfj(Auth::user()->permisos, 'e_compras'))
							        var data3 = google.visualization.arrayToDataTable([
							          ['Compras', 'Cantidad'],
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
							          title: 'Total de remitos de compra por mes del año {{now()->format('Y')}}',
							          vAxis: {minValue: 0},
							          hAxis: {titleTextStyle: {color: 'black'}},							         
							          colors: ['grey'],
							          is3D: true
							          
							        };

							        var chart = new google.charts.Bar(document.getElementById('compra_anual'));

							        chart.draw(data3, google.charts.Bar.convertOptions(options3));
						        @endif
						      }
					   	  </script>
						   
					    @if(kvfj(Auth::user()->permisos, 'e_compras'))
					   		<div class="col-md-12" id="compra_anual" style="width: 1200px; height: 300px; min-width: 250px"></div>
					    @endif
					</div>

					<hr>

					<div class="row" style="justify-content: center;">
						@if(kvfj(Auth::user()->permisos, 'e_tareas'))	

							@if(count($piezas) == 0)							
								<div class="alert alert-dark w-50" style="text-align: center;">
								  No hay Piezas existentes
								</div>
							@else
								 <div class="row justify-content-center w-50">
									<div class="col-md-9">
									 	<div class="btn-group" role="group">
										  <button class="btn btn-sm btn-warning" type="button" data-bs-toggle="modal" data-bs-target="#bajo" aria-expanded="false" aria-controls="bajo">Stock Bajo</button>

										  <button class="btn btn-sm btn-success" type="button" data-bs-toggle="modal" data-bs-target="#normal" aria-expanded="false" aria-controls="normal">Stock Normal</button>

									 	  <button class="btn btn-sm btn-danger" type="button" data-bs-toggle="modal" data-bs-target="#sin" aria-expanded="false" aria-controls="sin">Sin Stock</button>

									 	  @if(kvfj(Auth::user()->permisos, 'piezas_pdf_stock'))
									 	  <a href="{{url('/admin/pdf-stock-piezas')}}" class="btn btn-sm btn-secondary" target="_blank">
									 	  	<i class="fas fa-arrow-right"></i> <i class="far fa-file-pdf"></i> PDF
									 	  </a>
									 	  @endif
										</div>
									</div>		

								{{-- STOCK BAJO --}}

								<div class="modal fade" id="bajo" tabindex="-1" aria-labelledby="bajo" aria-hidden="true">
								  <div class="modal-dialog">
								    <div class="modal-content">
								      <div class="modal-header bg-dark text-white">
								        <h5 class="modal-title" id="bajo">Listado de piezas y cantidades <span class="badge bg-warning text-dark">Stock bajo</span></h5>
								        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
								      </div>
								      <div class="modal-body p-0">
								      	@if($piezas_stock_min != 0)
								        <table class="table table-bordered mb-0" width="100%">
								        	<tbody>
								        		<thead class="table-secondary">
								        			<tr>
								        				<td>Nombre</td>
								        				<td style="text-align: right;">Cantidad Minima</td>
								        				<td style="text-align: right;">Cantidad</td>
								        			</tr>
								        		</thead>
								        		@foreach($piezas as $p)
										    		@if(($p->cantidad_min > $p->cantidad)&&($p->cantidad != 0))		
										    			<tr>
										    				<td>{{$p->name}}</td>
										    				<td style="text-align: right;">{{$p->cantidad_min}}</td>
										    				<td style="text-align: right;">{{$p->cantidad}}</td>
										    			</tr>
										    		@endif										    		
									    		@endforeach									    		
								        	</tbody>
								        </table>
								        @endif

								        @if($piezas_stock_min == 0)
							    			<div class="alert alert-danger mb-0">
											  No hay piezas con stock bajo
											</div>
							    		@endif
								      </div>
								      <div class="modal-footer">
								        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
								      </div>
								    </div>
								  </div>
								</div>

								{{-- STOCK NORMAL --}}

								<div class="modal fade" id="normal" tabindex="-1" aria-labelledby="normal" aria-hidden="true">
								  <div class="modal-dialog">
								    <div class="modal-content">
								      <div class="modal-header bg-dark text-white">
								        <h5 class="modal-title" id="normal">Listado de piezas y cantidades <span class="badge bg-success text-white">Stock normal</span></h5>
								        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
								      </div>
								      <div class="modal-body p-0">
								      	@if($piezas_stock_normal != 0)
								        <table class="table table-bordered mb-0" width="100%">
								        	<tbody>
								        		<thead class="table-secondary">
								        			<tr>
								        				<td>Nombre</td>
								        				<td style="text-align: right;">Cantidad Minima</td>
								        				<td style="text-align: right;">Cantidad</td>
								        			</tr>
								        		</thead>
								        		@foreach($piezas as $p)
										    		@if($p->cantidad_min <= $p->cantidad)
										    			<tr>
										    				<td>{{$p->name}}</td>
										    				<td style="text-align: right;">{{$p->cantidad_min}}</td>
										    				<td style="text-align: right;">{{$p->cantidad}}</td>
										    			</tr>
										    		@endif										    		
									    		@endforeach									    		
								        	</tbody>
								        </table>
								        @endif

								        @if($piezas_stock_normal == 0)
							    			<div class="alert alert-danger mb-0">
											  No hay piezas con stock normal
											</div>
							    		@endif	
								      </div>
								      <div class="modal-footer">
								        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
								      </div>
								    </div>
								  </div>
								</div>

								{{-- SIN STOCK --}}

								<div class="modal fade" id="sin" tabindex="-1" aria-labelledby="sin" aria-hidden="true">
								  <div class="modal-dialog">
								    <div class="modal-content">
								      <div class="modal-header bg-dark text-white">
								        <h5 class="modal-title" id="sin">Listado de piezas y cantidades <span class="badge bg-danger text-white">Sin Stock</span></h5>
								        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
								      </div>
								      <div class="modal-body p-0">
								      	@if($piezas_sin_stock != 0)
								        <table class="table table-bordered mb-0" width="100%">
								        	<tbody>
								        		<thead class="table-secondary">
								        			<tr>
								        				<td>Nombre</td>
								        				<td style="text-align: right;">Cantidad Minima</td>
								        				<td style="text-align: right;">Cantidad</td>
								        			</tr>
								        		</thead>
								        		@foreach($piezas as $p)
										    		@if($p->cantidad == 0)
										    			<tr>
										    				<td>{{$p->name}}</td>
										    				<td style="text-align: right;">{{$p->cantidad_min}}</td>
										    				<td style="text-align: right;">{{$p->cantidad}}</td>
										    			</tr>				    			
										    		@endif										    		
									    		@endforeach									    		
								        	</tbody>
								        </table>
								        @endif

								        @if($piezas_sin_stock == 0)
							    			<div class="alert alert-danger mb-0">
											  No hay piezas sin stock
											</div>
						    			@endif	
								      </div>
								      <div class="modal-footer">
								        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
								      </div>
								    </div>
								  </div>
								</div>
							</div>
							<div class="col-md-12" id="piechart2" style="width: 700px; height: 200px;"></div>

							@endif	

							@if(count($tareas) == 0)							
								<div class="alert alert-dark w-50" style="text-align: center;">
								  No hay <b>Tareas</b> existentes
								</div>
							@else									
						    	<div class="col-md-12" id="piechart" style="width: 700px; height: 200px;"></div>
							@endif

					    @endif

					    @if(kvfj(Auth::user()->permisos, 'e_compras'))
					    	@if(($c_pend == 0) && ($c_comp == 0)&& ($c_rec == 0))							
								<div class="alert alert-dark w-50" style="text-align: center;">
								  No existen <b>Ordenes de Compra</b> correspondientes al último mes
								</div>
							@else
								<div class="col-md-12" id="piechart4" style="width: 700px; height: 200px;"></div>
							@endif
					    @endif
					</div>
				<!--HASTA ACA-->
			</div>
		</div>
	@endif
@endif
</div>
@endsection
