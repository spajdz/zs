<header class="row">
	<nav class="navbar navbar-default" role="navigation">
		<div class="row">
			<div class="col-xs-2 visible-xs">
				<button type="button" class="navbar-toggle toggle-menu menu-left push-body jPushMenuBtn" data-toggle="collapse" data-target="#menu-lateral">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>
			<div class="col-md-3 col-xs-8">
				<?= $this->Html->link(
					$this->Html->image('logo-zs-motors.png', array('class' => 'img-responsive')),
					'/',
					array('class' => 'navbar-brand', 'escape' => false)
				); ?>
			</div>
			<div class="col-xs-2 visible-xs no-padding">
				<?= $this->Html->link(
					'<i class="fa fa-shopping-cart"></i>',
					array('controller' => 'productos', 'action' => 'carro'),
					array('escape' => false, 'class' => 'carro')
				); ?>
			</div>
			<div class="col-md-9 col-xs-12 hidden-xs no-padding inherit">
				<div class="row top-menu">
					<div class="col-md-6 col-md-push-6 col-xs-12 icon-menu">
						<ul class="nav navbar-nav navbar-left">
							<li class="hidden-xs">
								<?= $this->Html->link(
									sprintf('
										<i class="fa fa-shopping-cart"></i>
										<p class="label label-info">%s (<span class="js-carro-total-items items">%d</span>)</p>
										<span class="js-carro-total-dinero dinero">$%s</span>',
										'Carro',
										($estado_carro['Cantidad'] ? $estado_carro['Cantidad'] : 0),
										($estado_carro['Subtotal'] ? number_format($estado_carro['Subtotal'], 0, null, '.') : 0)
									),
									array('controller' => 'productos', 'action' => 'carro'),
									array('escape' => false, 'class' => 'carro')
								); ?>
							</li>
							<? if ( ! AuthComponent::user() ) : ?>
							<li>	
								<?= $this->Html->link(
									'<i class="fa fa-user"></i> <span>Iniciar sesión</span>',
									'/',
									array('escape' => false, 'class' => 'bienvenido clearfix dropdown-toggle', 'data-toggle' => 'dropdown')
								); ?>
								<ul class="login dropdown-menu">
					                <?= $this->Form->create('Usuario', array(
					                          'url' => array('controller' => 'usuarios', 'action' => 'login'),                        
					                          'class' => 'form-horizontal',
					                          'inputDefaults' => array('label' => false,'div' => false)
					                          )
					                    ); ?>                      
					                  <?= $this->Form->input('email', array('placeholder' => 'Email')); ?><br />
					                  <?= $this->Form->input('clave', array('autocomplete' => 'new-password', 'type' => 'password', 'placeholder' => 'Contraseña')); ?><br/>
					                  <?= $this->Form->button('Entrar', array('class' => 'btn btn-default', 'div' => false)); ?>                  
					                  <?= $this->Html->link('Regístrate ', array('controller' => 'usuarios', 'action' => 'add'), array('class' => 'btn btn-default registro', 'div' => false)); ?>
					                  <?= $this->Html->link('Recuperar contraseña', array('controller' => 'usuarios', 'action' => 'add'), array('class' => 'contra')); ?></br>                    
					                <?= $this->Form->end(); ?>
					            </ul>
							</li>
							<? else : ?>
							<li class="dropdown">
								<?= $this->Html->link(
									sprintf('<i class="fa fa-user"></i> <span>Hola<br>%s</span>', AuthComponent::user('nombre')),
									'#',
									array('escape' => false, 'class' => 'bienvenido clearfix')
								); ?>
								<ul class="dropdown-menu mi-menu">
									<li>
										<?= $this->Html->link(
											'Cerrar sesion',
											array('controller' => 'usuarios', 'action' => 'logout'),
											array('escape' => false, 'class' => 'logout')
										); ?>
									</li>
									<li><?= $this->Html->link('Mis compras', array('controller' => 'compras', 'action' => 'index')); ?></li>
									<li><?= $this->Html->link('Mis datos', array('controller' => 'usuarios', 'action' => 'edit')); ?></li>
									<li><?= $this->Html->link('Mis direcciones', array('controller' => 'direcciones', 'action' => 'edit')); ?></li>
								</ul>
							</li>
							<? endif; ?>
						</ul>
					</div>
					<div class="col-md-5 col-md-pull-6 col-md-offset-1 col-xs-10 col-xs-offset-1">
						<?= $this->Form->create('Producto', array('url' => array('action' => 'buscar'), 'inputDefaults' => array('div' => false, 'label' => false))); ?>
							<?= $this->Form->input('criterio', array('class' => 'form-control', 'placeholder' => 'Buscar...')); ?>
							<button type="submit"><i class="fa fa-search lupa"></i></button>
						<?= $this->Form->end(); ?>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="collapse navbar-collapse cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="menu-lateral">
				<div class="row top-menu visible-xs">
					<div class="col-md-6 col-md-push-6 col-xs-12 icon-menu">
						<ul class="nav navbar-nav navbar-left">
							<li class="hidden-xs">
								<?= $this->Html->link(
									sprintf('
										<i class="fa fa-shopping-cart"></i>
										<p class="label label-info">%s (<span class="js-carro-total-items items">%d</span>)</p>
										<span class="js-carro-total-dinero dinero">$%s</span>',
										'Carro',
										($estado_carro['Cantidad'] ? $estado_carro['Cantidad'] : 0),
										($estado_carro['Subtotal'] ? number_format($estado_carro['Subtotal'], 0, null, '.') : 0)
									),
									array('controller' => 'productos', 'action' => 'carro'),
									array('escape' => false, 'class' => 'carro')
								); ?>
							</li>
							<? if ( ! AuthComponent::user() ) : ?>
							<li>
								<?= $this->Html->link(
									'<i class="fa fa-user"></i> <span>Iniciar sesión</span>',
									array('controller' => 'usuarios', 'action' => 'login'),
									array('escape' => false, 'class' => 'bienvenido clearfix')
								); ?>
								<?= $this->Html->link(
									'Regístrate',
									array('controller' => 'usuarios', 'action' => 'add'),
									array('escape' => false, 'class' => 'registrate2')
								); ?>
							</li>
							<? else : ?>
							<li class="dropdown">
								<?= $this->Html->link(
									sprintf('<i class="fa fa-user"></i> <span>Hola<br>%s</span>', AuthComponent::user('nombre')),
									'#',
									array('escape' => false, 'class' => 'bienvenido clearfix')
								); ?>
								<ul class="dropdown-menu mi-menu">
									<li>
										<?= $this->Html->link(
											'Cerrar sesion',
											array('controller' => 'usuarios', 'action' => 'logout'),
											array('escape' => false, 'class' => 'logout')
										); ?>
									</li>
									<li><?= $this->Html->link('Mis compras', array('controller' => 'compras', 'action' => 'index')); ?></li>
									<!--
									<li><?= $this->Html->link('Seguimiento compras', array('controller' => 'compras', 'action' => 'seguimiento')); ?></li>
									-->
									<li><?= $this->Html->link('Mis datos', array('controller' => 'usuarios', 'action' => 'edit')); ?></li>
									<li><?= $this->Html->link('Mis direcciones', array('controller' => 'direcciones', 'action' => 'edit')); ?></li>
								</ul>
							</li>
							<? endif; ?>
						</ul>
					</div>
					<div class="col-md-5 col-md-pull-6 col-md-offset-1 col-xs-10 col-xs-offset-1">
						<?= $this->Form->create('Producto', array('url' => array('action' => 'buscar'), 'inputDefaults' => array('div' => false, 'label' => false))); ?>
							<?= $this->Form->input('criterio', array('class' => 'form-control', 'placeholder' => 'Buscar...')); ?>
							<button type="submit"><i class="fa fa-search lupa"></i></button>
						<?= $this->Form->end(); ?>
					</div>
				</div>
				<div class="alto">
					<div class="body-ul">
						<ul class="nav navbar-nav navbar-right no-padding menu-principal">
							<li class="menu05">
								<?= $this->Html->link(
									'Neumáticos',
									array('controller' => 'productos', 'action' => 'index', 'neumaticos'),
									array('escape' => false)
								); ?>
							</li>
							<li class="menu05">
								<?= $this->Html->link(
									'Llantas',
									array('controller' => 'productos', 'action' => 'index', 'llantas'),
									array('escape' => false)
								); ?>
							</li>
							<li class="dropdown menu01">
								<?= $this->Html->link(
									'Accesorios',
									array('controller' => 'productos', 'action' => 'index', 'accesorios'),
									array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown', 'escape' => false)
								); ?>
								<ul class="dropdown-menu" role="menu">
									<? foreach ( $categorias_menu['accesorios'] as $categoria ) : ?>
									<li class="sub-categoria">
										<?= $this->Html->link(
											h($categoria['Categoria']['nombre']), '/categoria/' .  $categoria['Categoria']['slug']
										); ?>
										<ul class="hidden-xs">
											<? $x = 0; foreach ( $categoria['children'] as $children ) : ?>
											<? if ( ++$x >= 10 ) continue; ?>
											<li>
												<?= $this->Html->link(
													h($children['Categoria']['nombre']),'/categoria/'.$categoria['Categoria']['slug'].'/'.$children['Categoria']['slug']
												); ?>
											</li>
											<? endforeach; ?>
										</ul>
									</li>
									<? endforeach; ?>
								</ul>
							</li>

						</ul>
						<div class="call hidden">
							<a href="tel:+56222109100" class="fono"><i class="fa fa-mobile"></i>Fono Clientes +56 2 2210 9100</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</nav>
</header>
