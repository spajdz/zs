<div class="page-title">
	<h2><span class="fa fa-user"></span> Perfiles</h2>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Nuevo perfil</h3>
	</div>
	<div class="panel-body perfiles">
		<div class="table-responsive">
			<?= $this->Form->create('Perfil', array('class' => 'form-horizontal', 'type' => 'file', 'inputDefaults' => array('label' => false, 'div' => false, 'class' => 'form-control'))); ?>
				<table class="table">
					<tr>
						<th><?= $this->Form->label('nombre', 'Nombre'); ?></th>
						<td><?= $this->Form->input('nombre'); ?></td>
					</tr>
					<tr>
						<th><?= $this->Form->label('permisos', 'Permisos'); ?></th>
						<td>
							<table class="table">
								<!-- Dashboard -->
								<tr>
									<td class="check_perfil"><div><?= $this->Form->checkbox('dashboard'); ?></div></td>
									<th><?= $this->Form->label('dashboard', 'Dashboard'); ?></th>
								</tr>

								<!-- Ventas-->
								<tr>
									<td class="check_perfil-padre">
										<label class="switch switch-small">
											<?= $this->Form->checkbox('perfil_ventas', array('value' => 1, 'class' => 'js-check-ventas-perfil')); ?>
											<span></span>
										</label>
									</td>
									<th><?= $this->Form->label('perfil_ventas', ' -- Ventas --'); ?></th>
								</tr>
								<!-- Listado OC -->
								<tr>
									<td class="check_perfil"><div class="check-ventas"><?= $this->Form->checkbox('compras' , array('class' => 'ck-ventas-perfil')); ?></div></td>
									<th><?= $this->Form->label('compras', 'Listado OC (Orden de Compra)'); ?></th>
								</tr>
								<!-- Descuentos -->
								<tr>
									<td class="check_perfil"><div class="check-ventas"><?= $this->Form->checkbox('descuentos' , array('class' => 'ck-ventas-perfil')); ?></div></td>
									<th><?= $this->Form->label('descuentos', 'Descuento'); ?></th>
								</tr>
								<!-- Tarifa despacho -->
								<tr>
									<td class="check_perfil"><div class="check-ventas"><?= $this->Form->checkbox('tarifa_despachos' , array('class' => 'ck-ventas-perfil')); ?></div></td>
									<th><?= $this->Form->label('tarifa_despachos', 'Despacho'); ?></th>
								</tr>
								<!-- Paginas-->
								<tr>
									<td class="check_perfil-padre">
										<label class="switch switch-small">
											<?= $this->Form->checkbox('perfil_paginas', array('class' => 'js-check-paginas-perfil')); ?>
											<span></span>
										</label>
									</td>
									<th><?= $this->Form->label('perfil_paginas', ' -- Páginas --'); ?></th>
								</tr>
								<!-- Banners -->
								<tr>
									<td class="check_perfil"><div class="check-paginas"><?= $this->Form->checkbox('banners', array('class' => 'ck-paginas-perfil')); ?></div></td>
									<th><?= $this->Form->label('banners', 'Banners'); ?></th>
								</tr>
								<!-- Ayuda -->
								<tr>
									<td class="check_perfil"><div class="check-paginas"><?= $this->Form->checkbox('ayudas', array('class' => 'ck-paginas-perfil')); ?></div></td>
									<th><?= $this->Form->label('ayudas', 'Ayuda'); ?></th>
								</tr>
								<!-- Sucursal -->
								<tr>
									<td class="check_perfil"><div class="check-paginas"><?= $this->Form->checkbox('sucursales', array('class' => 'ck-paginas-perfil')); ?></div></td>
									<th><?= $this->Form->label('sucursales', 'Sucursales'); ?></th>
								</tr>
								<!-- Contacto -->
								<tr>
									<td class="check_perfil"><div class="check-paginas"><?= $this->Form->checkbox('contactos', array('class' => 'ck-paginas-perfil')); ?></div></td>
									<th><?= $this->Form->label('contactos', 'Contacto'); ?></th>
								</tr>
								<!-- Novedades -->
								<tr>
									<td class="check_perfil"><div class="check-paginas"><?= $this->Form->checkbox('novedades', array('class' => 'ck-paginas-perfil')); ?></div></td>
									<th><?= $this->Form->label('novedades', 'Novedades'); ?></th>
								</tr>
								<!-- MOdulos -->
								<tr>
									<td class="check_perfil-padre">
										<label class="switch switch-small">
											<?= $this->Form->checkbox('perfil_modulos', array('class' => 'js-check-modulos-perfil')); ?>
											<span></span>
										</label>
									</td>
									<th><?= $this->Form->label('perfil_modulos', '-- Módulos --'); ?></th>
								</tr>
								<!-- Usuarios -->
								<tr>
									<td class="check_perfil"><div class="check-modulos"><?= $this->Form->checkbox('usuarios', array('class' => 'ck-modulos-perfil')); ?></div></td>
									<th><?= $this->Form->label('usuarios', 'Usuarios'); ?></th>
								</tr>
								<!-- tipos de usuarios -->
								<tr>
									<td class="check_perfil"><div class="check-modulos"><?= $this->Form->checkbox('tipo_usuarios', array('class' => 'ck-modulos-perfil')); ?></div></td>
									<th><?= $this->Form->label('tipo_usuarios', 'Tipos de usuarios'); ?></th>
								</tr>
								<!-- Grupos tarifarios -->
								<tr>
									<td class="check_perfil"><div class="check-modulos"><?= $this->Form->checkbox('grupo_tarifarios', array('class' => 'ck-modulos-perfil')); ?></div></td>
									<th><?= $this->Form->label('grupo_tarifarios', 'Grupos Tarifarios'); ?></th>
								</tr>
								<!-- Textos -->
								<tr>
									<td class="check_perfil"><div class="check-modulos"><?= $this->Form->checkbox('textos', array('class' => 'ck-modulos-perfil')); ?></div></td>
									<th><?= $this->Form->label('textos', 'Textos'); ?></th>
								</tr>
								<!-- Query Sql -->
								<tr>
									<td class="check_perfil"><div class="check-modulos"><?= $this->Form->checkbox('querys', array('class' => 'ck-modulos-perfil')); ?></div></td>
									<th><?= $this->Form->label('querys', 'Query SQL'); ?></th>
								</tr>
								<!-- Idenditicadores SQL -->
								<tr>
									<td class="check_perfil"><div class="check-modulos"><?= $this->Form->checkbox('identificadores', array('class' => 'ck-modulos-perfil')); ?></div></td>
									<th><?= $this->Form->label('identificadores', 'Identificadores SQL'); ?></th>
								</tr>
								<!-- Carga masiva -->
								<tr>
									<td class="check_perfil"><div class="check-modulos"><?= $this->Form->checkbox('cargar_masiva', array('class' => 'ck-modulos-perfil')); ?></div></td>
									<th><?= $this->Form->label('cargar_masiva', 'Carga Masiva'); ?></th>
								</tr>
								<!-- Administradores -->
								<tr>
									<td class="check_perfil"><div class="check-modulos"><?= $this->Form->checkbox('administradores', array('class' => 'ck-modulos-perfil')); ?></div></td>
									<th><?= $this->Form->label('administradores', 'Administrdores'); ?></th>
								</tr>
								<!-- Perfiles -->
								<tr>
									<td class="check_perfil"><div class="check-modulos"><?= $this->Form->checkbox('perfiles', array('class' => 'ck-modulos-perfil')); ?></div></td>
									<th><?= $this->Form->label('perfiles', 'Perfiles'); ?></th>
								</tr>
								<!-- Configuraciones -->
								<tr>
									<td class="check_perfil"><div class="check-modulos"><?= $this->Form->checkbox('configuraciones', array('class' => 'ck-modulos-perfil')); ?></div></td>
									<th><?= $this->Form->label('configuraciones', 'Configuraciones'); ?></th>
								</tr>
							</table>
						</td>
					</tr>
				</table>
				<div class="pull-right">
					<input type="submit" class="btn btn-primary esperar-carga" autocomplete="off" data-loading-text="Espera un momento..." value="Guardar cambios">
					<?= $this->Html->link('Cancelar', array('action' => 'index'), array('class' => 'btn btn-danger')); ?>
				</div>
			<?= $this->Form->end(); ?>
		</div>
	</div>
</div>
