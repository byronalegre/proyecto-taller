<div class="sidebar shadow-lg">
	<div class="section-top">
			<button type="button" class="close">
			  <span aria-hidden="true" onclick="cerrar()">&times;</span>
			</button>

			<div class="icon">
				<a href="{{ url('/logout') }}"><i data-toggle="tooltip" data-placement="top" title="Cerrar sesión" class="fas fa-sign-out-alt"></i>
				</a>
			</div>

			<div class="logo">				
				<img src="{{url('static/images/logo1.png') }}" alt="img-fluid" width="50">			
			</div>	
	
			<div class="user">
				<h6><span class="badge bg-dark" style="width: 100%">
					Hola: {{Auth::user()->name }} {{ Auth::user()->lastname }}
					<i class="fas fa-laugh"></i>
				</span>
				</h6>
				<h6><span class="badge bg-secondary" style="width: 100%">
					{{ getRoleUsuarioArray(null, Auth::user()->role) }}
				</span>
				</h6>
			
			</div>
	</div>
	
	<div class="main">
		<ul>
			@if(kvfj(Auth::user()->permisos, 'inicio'))
			<li>
				<a href="{{ url('/admin') }} " class="lk-inicio"><i class="fas fa-home"></i> Inicio</a>
			</li>
			@endif
			
			@if(kvfj(Auth::user()->permisos, 'piezas'))
			<li>
				<a href="{{ url('/admin/piezas/1') }} " class="lk-piezas lk-piezas_agregar lk-piezas_editar lk-piezas_buscar lk-piezas_eliminar"><i class="fas fa-cog"></i> Piezas</a>
			</li>
			@endif

			@if(kvfj(Auth::user()->permisos, 'categorias'))
			<li>
				<a href="{{ url('/admin/categorias/0') }} " class="lk-categorias lk-categorias_agregar lk-categorias_editar lk-categorias_eliminar"><i class="fas fa-tags"></i> Categorías</a>
			</li>
			@endif			

			@if(kvfj(Auth::user()->permisos, 'proveedores'))
			<li>
				<a href="{{ url('/admin/proveedores/all') }}" class="lk-proveedores lk-proveedores_agregar lk-proveedores_editar lk-proveedores_eliminar lk-proveedores_buscar"><i class="fas fa-truck"></i> Proveedores</a>
			</li>
			@endif
			
			@if(kvfj(Auth::user()->permisos, 'compras'))
			<li>
				<a href="{{ url('/admin/ordenescompra/all') }}" class="lk-compras lk-compras_agregar lk-compras_editar lk-compra_detalle lk-compras_eliminar"><i class="fas fa-cart-plus"></i> Ordenes de Compra</a>
			</li>
			@endif			

			@if(kvfj(Auth::user()->permisos, 'pedidos'))
			<li>
				<a href="{{ url('/admin/ordenespedido/all') }}" class="lk-pedidos lk-pedidos_agregar lk-pedidos_editar lk-pedido_detalle lk-pedidos_eliminar"><i class="fas fa-file-invoice"></i> Ordenes de Pedido</a>
			</li>
			@endif
			
			@if(kvfj(Auth::user()->permisos, 'remitos'))
			<li>
				<a href="{{ url('/admin/compras/all') }}" class="lk-remitos lk-remitos_agregar lk-remito_detalle lk-remitos_eliminar"><i class="fas fa-file-invoice-dollar"></i> Remitos</a>
			</li>
			@endif

			@if(kvfj(Auth::user()->permisos, 'tareas'))
			<li>
				<a href="{{ url('/admin/tareas/all') }}" class="lk-tareas lk-tareas_agregar lk-tareas_eliminar lk-tarea_detalle lk-tareas_editar"><i class="fas fa-tasks"></i> Tareas</a>
			</li>
			@endif

			@if(kvfj(Auth::user()->permisos, 'usuarios_list'))
			<li>
				<a href="{{ url('/admin/usuarios/all') }} " class="lk-usuarios_list lk-usuarios_editar lk-usuarios_suspend lk-usuarios_permisos lk-usuarios_buscar lk-usuarios_register"><i class="fas fa-users"></i> Usuarios</a>			
			</li>
			@endif

			@if(kvfj(Auth::user()->permisos, 'backup'))
			<li>
				<a href="{{ url('/admin/backup') }}" class="lk-backup"><i class="fas fa-database"></i> BackUp's</a>
			</li>
			@endif
			
			@if(kvfj(Auth::user()->permisos, 'config'))
			<li>
				<a href="{{ url('/admin/config') }}" class="lk-config"><i class="fas fa-wrench"></i> Configuración</a>
			</li>
			@endif

			<li>
				<a href= "{{url('https://github.com/byronalegre/proyecto-taller')}}" ><i class="far fa-question-circle"></i> Ayuda</a>
			</li>
		</ul>
	</div>
</div>