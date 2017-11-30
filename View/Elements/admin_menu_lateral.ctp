<div class="page-sidebar">
	<ul class="x-navigation x-navigation-custom">
		<li class="xn-logo">
			<?= $this->Html->link(
				'<span class="fa fa-dashboard"></span> <span class="x-navigation-control">Backend Zs Motor</span>',
				array('controller' => 'compras', 'action' => 'dashboard'),
				array('escape' => false)
			); ?>
			<a href="#" class="x-navigation-control"></a>
		</li>
		<li class="xn-title"></li>
		<li class="<?= ($this->Html->menuActivo(array('controller' => 'compras', 'action' => 'dashboard')) ? 'active' : ''); ?>">
			<?= $this->Html->link(
				'<span class="fa fa-dashboard"></span> <span class="xn-text">Dashboard</span>',
				array('controller' => 'compras', 'action' => 'dashboard'),
				array('escape' => false)
			); ?>
		</li>
		<li class="xn-openable <?= (
			(
				$this->Html->menuActivo(array('controller' => 'marcas')) ||
				$this->Html->menuActivo(array('controller' => 'compras', 'action' => 'index')) ||
				$this->Html->menuActivo(array('controller' => 'productos')) 
			)
			? 'active' : ''
		); ?>">
			<a href="#"><span class="fa fa-th-list"></span> <span class="xn-text">Ecommerce</span></a>
			<ul>
				<li class="<?= ($this->Html->menuActivo(array('controller' => 'marcas')) ? 'active' : ''); ?>">
					<?= $this->Html->link(
						'<span class="glyphicon glyphicon-tags"></span> <span class="xn-text">Marcas</span>',
						array('controller' => 'marcas', 'action' => 'index'),
						array('escape' => false)
					); ?>
				</li>
				<li class="<?= ($this->Html->menuActivo(array('controller' => 'compras', 'action' => 'index')) ? 'active' : ''); ?>">
					<?= $this->Html->link(
						'<span class="glyphicon glyphicon-barcode"></span> <span class="xn-text">Compras</span>',
						array('controller' => 'compras', 'action' => 'index'),
						array('escape' => false)
					); ?>
				</li>
				<li class="<?= ($this->Html->menuActivo(array('controller' => 'productos')) ? 'active' : ''); ?>">
					<?= $this->Html->link(
						'<span class="glyphicon glyphicon-barcode"></span> <span class="xn-text">Productos</span>',
						array('controller' => 'productos', 'action' => 'index'),
						array('escape' => false)
					); ?>
				</li>
			</ul>
		</li>
		<li class="xn-openable <?= (
			(
				$this->Html->menuActivo(array('controller' => 'clientes')) ||
				$this->Html->menuActivo(array('controller' => 'noticias', 'action' => 'index')) ||
				$this->Html->menuActivo(array('controller' => 'servicios')) ||
				$this->Html->menuActivo(array('controller' => 'configuraciones')) ||
				$this->Html->menuActivo(array('controller' => 'encargado_sucursales')) ||
				$this->Html->menuActivo(array('controller' => 'sucursales')) 
			)
			? 'active' : ''
		); ?>">
			<a href="#"><span class="fa fa-th-list"></span> <span class="xn-text">Configuracion</span></a>
			<ul>
				<li class="<?= ($this->Html->menuActivo(array('controller' => 'clientes')) ? 'active' : ''); ?>">
					<?= $this->Html->link(
						'<span class="glyphicon glyphicon-piggy-bank"></span> <span class="xn-text">Clientes</span>',
						array('controller' => 'clientes', 'action' => 'index'),
						array('escape' => false)
					); ?>
				</li>
				<li class="<?= ($this->Html->menuActivo(array('controller' => 'noticias', 'action' => 'index')) ? 'active' : ''); ?>">
					<?= $this->Html->link(
						'<span class="glyphicon glyphicon-picture"></span> <span class="xn-text">Noticias</span>',
						array('controller' => 'noticias', 'action' => 'index'),
						array('escape' => false)
					); ?>
				</li>
				<li class="<?= ($this->Html->menuActivo(array('controller' => 'servicios')) ? 'active' : ''); ?>">
					<?= $this->Html->link(
						'<span class="glyphicon glyphicon-cutlery"></span> <span class="xn-text">Servicios</span>',
						array('controller' => 'servicios', 'action' => 'index'),
						array('escape' => false)
					); ?>
				</li>
				<li class="<?= ($this->Html->menuActivo(array('controller' => 'sucursales')) ? 'active' : ''); ?>">
					<?= $this->Html->link(
						'<span class="glyphicon glyphicon-pushpin"></span> <span class="xn-text">Sucursales</span>',
						array('controller' => 'sucursales', 'action' => 'index'),
						array('escape' => false)
					); ?>
				</li>
				<li class="<?= ($this->Html->menuActivo(array('controller' => 'encargado_sucursales')) ? 'active' : ''); ?>">
					<?= $this->Html->link(
						'<span class="fa fa-user"></span> <span class="xn-text">Encargados</span>',
						array('controller' => 'encargado_sucursales', 'action' => 'index'),
						array('escape' => false)
					); ?>
				</li>
				<li class="<?= ($this->Html->menuActivo(array('controller' => 'categorias')) ? 'active' : ''); ?>">
					<?= $this->Html->link(
						'<span class="fa fa-th-list"></span> <span class="xn-text">Menú accesorios categorías</span>',
						array('controller' => 'categorias', 'action' => 'index'),
						array('escape' => false)
					); ?>
				</li>
				<li class="<?= ($this->Html->menuActivo(array('controller' => 'configuraciones')) ? 'active' : ''); ?>">
					<?= $this->Html->link(
						'<span class="fa fa-cog xn-title"></span> <span class="xn-text">Configuraciones</span>',
						array('controller' => 'configuraciones', 'action' => 'index'),
						array('escape' => false)
					); ?>
				</li>
			</ul>
		</li>
		
		<li class="<?= ($this->Html->menuActivo(array('controller' => 'vehiculos' , 'action' => 'carga_masiva')) ? 'active' : ''); ?>">
			<?= $this->Html->link(
				'<span class="fa fa-car"></span> <span class="xn-text">Vehiculos Especificaciones</span>',
				array('controller' => 'vehiculos', 'action' => 'index'),
				array('escape' => false)
			); ?>
		</li>
			
		<li class="xn-openable <?= (
				(
					$this->Html->menuActivo(array('controller' => 'usuarios')) ||
					$this->Html->menuActivo(array('controller' => 'direcciones')) ||
					$this->Html->menuActivo(array('controller' => 'tipo_direcciones'))
				)
				? 'active' : ''
			); ?>">
			<a href="#"><span class="fa fa-user"></span> <span class="xn-text">Usuarios</span></a>
			<ul>
				<li class="<?= ($this->Html->menuActivo(array('controller' => 'usuarios')) ? 'active' : ''); ?>">
					<?= $this->Html->link(
						'<span class="fa fa-user"></span> <span class="xn-text">Usuarios</span>',
						array('controller' => 'usuarios', 'action' => 'index'),
						array('escape' => false)
					); ?>
				</li>
				<li class="<?= ($this->Html->menuActivo(array('controller' => 'direcciones', 'action' => 'index')) ? 'active' : ''); ?>">
					<?= $this->Html->link(
						'<span class="glyphicon glyphicon-map-marker"></span> <span class="xn-text">Direcciones</span>',
						array('controller' => 'direcciones', 'action' => 'index'),
						array('escape' => false)
					); ?>
				</li>
				<li class="<?= ($this->Html->menuActivo(array('controller' => 'tipo_direcciones')) ? 'active' : ''); ?>">
					<?= $this->Html->link(
						'<span class="glyphicon glyphicon-map-marker"></span> <span class="xn-text">Tipo direccinoes</span>',
						array('controller' => 'tipo_direcciones', 'action' => 'index'),
						array('escape' => false)
					); ?>
				</li>
			</ul>
		</li>
		<li class="xn-openable <?= (
				(
					$this->Html->menuActivo(array('controller' => 'banners')) ||
					$this->Html->menuActivo(array('controller' => 'banners', 'action' => 'cuadroshome'))
				)
				? 'active' : ''
			); ?>">
			<a href="#"><span class="fa fa-picture-o "></span> <span class="xn-text">Banners</span></a>
			<ul>
				<li class="<?= ($this->Html->menuActivo(array('controller' => 'banners', 'action' => 'index')) ? 'active' : ''); ?>">
					<?= $this->Html->link(
						'<span class="fa fa-picture-o "></span> <span class="xn-text">Banners</span>',
						array('controller' => 'banners', 'action' => 'index'),
						array('escape' => false)
					); ?>
				</li>
				<li class="<?= ($this->Html->menuActivo(array('controller' => 'banners', 'action' => 'cuadroshome')) ? 'active' : ''); ?>">
					<?= $this->Html->link(
						'<span class="fa fa-picture-o"></span> <span class="xn-text">Cuadros categorías home</span>',
						array('controller' => 'banners', 'action' => 'cuadroshome'),
						array('escape' => false)
					); ?>
				</li>
			</ul>
		</li>
		
		<li class="<?= ($this->Html->menuActivo(array('controller' => 'administradores')) ? 'active' : ''); ?>">
			<?= $this->Html->link(
				'<span class="fa fa-user"></span> <span class="xn-text">Administradores</span>',
				array('controller' => 'administradores', 'action' => 'index'),
				array('escape' => false)
			); ?>
		</li>
			
	</ul>
</div>
