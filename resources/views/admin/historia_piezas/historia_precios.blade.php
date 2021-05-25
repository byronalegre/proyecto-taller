@extends ('admin.master')

@section ('title','Historial de precios')

@section('breadcrumb')
<li class="breadcrumb-item">
	<a href="{{url('/admin/piezas/1') }}"><i class="fas fa-cog"></i> Piezas</a>
</li>
<li class="breadcrumb-item">
	<a href="{{url('/admin/piezas/'.$id.'/detalle') }}"><i class="fas fa-info-circle"></i> Detalle pieza </a>
</li>
<li class="breadcrumb-item">
	<a href="{{url('/admin/piezas/'.$id.'/detalle/historia_precio') }}"><i class="fas fa-dollar-sign"></i> Historial de precios</a>
</li>
@endsection

@section('content')

<div class="container-fluid">
	@if($precio->total() != 0)
		<div class="panel shadow">
			<div class="header">
				<h2 class="title"><i class="fas fa-dollar-sign"></i> Historial de precios</h2>
			</div>										
			<div class="inside">	
				<div class="row mb-2">
					<div class="col-sm-3">
						<form>
							<div class="input-group input-group-sm">
								<span class="input-group-text" id="basic-addon1">Mostrar</span>
								<input name="paginate" type="number" class="form-control" aria-describedby="basic-addon1" placeholder="{{session('paginate')}} elementos" min="1" >
							</div>
						</form>
					</div>	
				</div>		
				
				<table class="table table-hover" id="Datatable" style="width:100%; text-align: center;">
					<thead class="table-dark">	
						<td hidden="true">ID</td>				
						<td>Fecha</td>	
						<td>Precio ($)</td>
					</thead>
					<tbody>
						@foreach($precio as $p)
							<tr>
								<td hidden="true">{{ $p->id }}</td>
								<td>{{ $p->created_at->format('d/m/Y') }}</td>
								<td>$ {{ $p->precio }}</td>						
							</tr>
						@endforeach
							
					</tbody>
				</table>					
				{{$precio->links()}}
				<p class="mtop16">
					Mostrando {{$precio->count()}} de {{ $precio->total() }} elemento(s).
				</p>
			</div>
		</div>
		
		<div class="panel shadow mtop16">
			<div class="header">
				<h2 class="title"><i class="fas fa-chart-line"></i> Gráfico de línea</h2>
			</div>
			
			<div class="inside">
				<div class="row" style="justify-content: center;">
					<div id="curve_chart" style="width: 1000px; height: 500px"></div>
				</div>			
			</div>
		</div>
	@else
		<div class="panel shadow mtop16">
			<div class="header">
				<h2 class="title"><i class="fas fa-chart-line"></i> Gráfico de línea</h2>
			</div>
			
			<div class="inside">
				<div class="alert alert-dark" style="text-align: center;">
					No existe información sobre precios.
				</div>
			</div>
		</div>
	@endif
</div>

 
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
  google.charts.load('current', {'packages':['line'], 'language': 'es'});
  google.charts.setOnLoadCallback(drawChart);

  

  function drawChart() {
  	var url = base + '/admin/' + 'md/api/load/'+{{$id}}+'/precios';

	http.open('GET', url, true);
	http.setRequestHeader('X-CSRF-TOKEN', csrfToken);
	http.send();
	http.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			
			var datos = this.responseText;
			
			datos = JSON.parse(datos);
			
			var data = new google.visualization.DataTable();

			data.addColumn('date', 'Fecha');
			data.addColumn('number', 'Precio($)');
			var dataChart = [];

			$.each(datos, function(i,v){
		    dataChart.push([new Date(v.created_at), parseFloat(v.precio)]);
			})
		    
		    data.addRows(dataChart);

			var options = {				
			  title: 'Variación de precio ($) en el tiempo',
		      curveType: 'function',
		      legend: { position: 'bottom' },				
	       	  hAxis: { format: 'd/M/Y'},
		    };

		    var chart = new google.charts.Line(document.getElementById('curve_chart'));
		    chart.draw(data, google.charts.Line.convertOptions(options));

		    // chart.draw(data, options);
		}
	};        
  }
</script>
@endsection

