<div class="sidebar shadow">
	<div class="section-top">
			
			<div class="icon">
				<a href="{{ url('/logout') }}"><i data-toggle="tooltip" data-placement="top" title="Cerrar sesión" class="fas fa-sign-out-alt"></i></a>
			</div>

			<div class="logo">
				
				<img src="{{url('static/images/logo1.png') }}" alt="img-fluid">
			
			</div>	
	
			<div class="user">
				<span class="subtitle" style="font-weight:bold;">Hola: {{Auth::user()->name }} {{ Auth::user()->lastname }} 
				<i class="fas fa-laugh"></i></span>
				
				<div class="email">
					{{ Auth::user()->email }}
				</div>
			
			</div>
	</div>
	
	<div class="main">
		<ul>
			@if(kvfj(Auth::user()->permisos, 'Panel_controller'))
			<li>
				<a href="{{ url('/admin') }} " class="lk-Panel_controller"><i class="fas fa-home"></i> Inicio</a>
			</li>
			@endif
			
			@if(kvfj(Auth::user()->permisos, 'piezas'))
			<li>
				<a href="{{ url('/admin/piezas/1') }} " class="lk-piezas lk-piezas_agregar lk-piezas_editar lk-piezas_buscar lk-piezas_eliminar"><i class="fas fa-cogs"></i> Piezas</a>
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

			@if(kvfj(Auth::user()->permisos, 'usuarios_list'))
			<li>
				<a href="{{ url('/admin/usuarios/all') }} " class="lk-usuarios_list lk-usuarios_editar lk-usuarios_suspend lk-usuarios_permisos lk-usuarios_buscar"><i class="fas fa-users"></i> Usuarios</a>
			
			</li>
			@endif
			
			@if(kvfj(Auth::user()->permisos, 'compras'))
			<li>
				<a href="{{ url('/admin/compras/all') }}" class="lk-compras lk-compras_agregar lk-compra_detalle lk-compras_eliminar"><i class="fas fa-cart-plus"></i> Compras</a>
			</li>
			@endif

			@if(kvfj(Auth::user()->permisos, 'backup'))
			<li>
				<a href="{{ url('/admin/backup') }}" class="lk-backup"><i class="fas fa-database"></i> Backup</a>
			</li>
			@endif
		</ul>
	</div>
</div>