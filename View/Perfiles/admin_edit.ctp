<div class="page-title">
	<h2><span class="fa fa-user"></span> Perfiles</h2>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Editar perfil</h3>
	</div>
	<div class="panel-body">
		<div class="table-responsive">
			<?= $this->Form->create('Perfil', array('class' => 'form-horizontal', 'type' => 'file', 'inputDefaults' => array('label' => false, 'div' => false, 'class' => 'form-control'))); ?>
				<table class="table">
					<?= $this->Form->input('id'); ?>
					<tr>
						<th><?= $this->Form->label('nombre', 'Nombre'); ?></th>
						<td><?= $this->Form->input('nombre'); ?></td>
					</tr>
					<tr>
					<th><?= $this->Form->label('permisos', 'Permisos'); ?></th>
					<td>
						<table class="table">
							<? $permisos = json_decode($this->request->data['Perfil']['permisos']);?>
							<table class="table">
								<!-- Dashboard -->
								<tr>
									<td class="check_perfil"><div><?= $this->Form->checkbox('dashboard' , array('checked' => (existe($permisos->dashboard,'') ? 'checked' : ''))); ?></div></td>
									<th><?= $this->Form->label('dashboard', 'Dashboard'); ?></th>
								</tr>

								<!-- Ventas-->
								<tr>
									<td class="check_perfil-padre">
										<label class="switch switch-small">
											<?= $this->Form->checkbox('perfil_ventas', array('checked' => (existe($permisos->perfil_ventas,'') ? 'checked' : ''), 'class' => 'js-check-ventas-perfil')); ?>
											<span></span>
										</label>
									</td>
									<th><?= $this->Form->label('perfil_ventas', ' -- Ventas --'); ?></th>
								</tr>
								<!-- Listado OC -->
								<tr>
									<td class="check_perfil"><div class="<?= ( ! existe($permisos->perfil_ventas,'') ? 'check-ventas' : '' ) ?>"><?= $this->Form->checkbox('compras' , array('checked' => (existe($permisos->compras,'') ? 'checked' : ''), 'class' => 'ck-ventas-perfil')); ?></div></td>
									<th><?= $this->Form->label('compras', 'Listado OC (Orden de Compra)'); ?></th>
								</tr>
								<!-- Descuentos -->
								<tr>
									<td class="check_perfil"><div class="<?= ( ! existe($permisos->perfil_ventas,'') ? 'check-ventas' : '' ) ?>"><?= $this->Form->checkbox('descuentos' , array('checked' => (existe($permisos->descuentos,'') ? 'checked' : ''), 'class' => 'ck-ventas-perfil')); ?></div></td>
									<th><?= $this->Form->label('descuentos', 'Descuentos'); ?></th>
								</tr>
								<!-- Tarifa despacho -->
								<tr>
									<td class="check_perfil"><div class="<?= ( ! existe($permisos->perfil_ventas,'') ? 'check-ventas' : '' ) ?>"><?= $this->Form->checkbox('tarifa_despachos' , array('checked' => (existe($permisos->tarifa_despachos,'') ? 'checked' : ''), 'class' => 'ck-ventas-perfil')); ?></div></td>
									<th><?= $this->Form->label('tarifa_despachos', 'Tarifa Despacho'); ?></th>
								</tr>
								<!-- Paginas-->
								<tr>
									<td class="check_perfil-padre">
										<label class="switch switch-small">
											<?= $this->Form->checkbox('perfil_paginas', array('checked' => (existe($permisos->perfil_paginas,'') ? 'checked' : ''), 'class' => 'js-check-paginas-perfil')); ?>
											<span></span>
										</label>
									</td>
									<th><?= $this->Form->label('perfil_paginas', ' -- Páginas --'); ?></th>
								</tr>
								<!-- Banners -->
								<tr>
									<td class="check_perfil"><div class="<?= ( ! existe($permisos->perfil_paginas,'') ? 'check-paginas' : '' ) ?>"><?= $this->Form->checkbox('banners', array('checked' => (existe($permisos->banners,'') ? 'checked' : ''),'class' => 'ck-paginas-perfil')); ?></div></td>
									<th><?= $this->Form->label('banners', 'Banners'); ?></th>
								</tr>
								<!-- Ayuda -->
								<tr>
									<td class="check_perfil"><div class="<?= ( ! existe($permisos->perfil_paginas,'') ? 'check-paginas' : '' ) ?>"><?= $this->Form->checkbox('ayudas', array('checked' => (existe($permisos->ayudas,'') ? 'checked' : ''),'class' => 'ck-paginas-perfil')); ?></div></td>
									<th><?= $this->Form->label('ayudas', 'Ayuda'); ?></th>
								</tr>
								<!-- Sucursal -->
								<tr>
									<td class="check_perfil"><div class="<?= ( ! existe($permisos->perfil_paginas,'') ? 'check-paginas' : '' ) ?>"><?= $this->Form->checkbox('sucursales', array('checked' => (existe($permisos->sucursales,'') ? 'checked' : ''),'class' => 'ck-paginas-perfil')); ?></div></td>
									<th><?= $this->Form->label('sucursales', 'Sucursales'); ?></th>
								</tr>
								<!-- Contacto -->
								<tr>
									<td class="check_perfil"><div class="<?= ( ! existe($permisos->perfil_paginas,'') ? 'check-paginas' : '' ) ?>"><?= $this->Form->checkbox('contactos', array('checked' => (existe($permisos->contactos,'') ? 'checked' : ''),'class' => 'ck-paginas-perfil')); ?></div></td>
									<th><?= $this->Form->label('contactos', 'Contacto'); ?></th>
								</tr>
								<!-- Novedades -->
								<tr>
									<td class="check_perfil"><div class="<?= ( ! existe($permisos->perfil_paginas,'') ? 'check-paginas' : '' ) ?>"><?= $this->Form->checkbox('novedades', array('checked' => (existe($permisos->novedades,'') ? 'checked' : ''),'class' => 'ck-paginas-perfil')); ?></div></td>
									<th><?= $this->Form->label('novedades', 'Novedades'); ?></th>
								</tr>
								<!-- MOdulos -->
								<tr>
									<td class="check_perfil-padre">
										<label class="switch switch-small">
											<?= $this->Form->checkbox('perfil_modulos', array('checked' => (existe($permisos->perfil_modulos,'') ? 'checked' : ''), 'class' => 'js-check-modulos-perfil')); ?>
											<span></span>
										</label>
									</td>
									<th><?= $this->Form->label('perfil_modulos', '-- Módulos --'); ?></th>
								</tr>
								<!-- Usuarios -->
								<tr>
									<td class="check_perfil"><div class="<?= ( ! existe($permisos->perfil_modulos,'') ? 'check-modulos' : '' ) ?>"><?= $this->Form->checkbox('usuarios', array('checked' => (existe($permisos->usuarios,'') ? 'checked' : ''), 'class' => 'ck-modulos-perfil')); ?></div></td>
									<th><?= $this->Form->label('usuarios', 'Usuarios'); ?></th>
								</tr>
								<!-- tipos de usuarios -->
								<tr>
									<td class="check_perfil"><div class="<?= ( ! existe($permisos->perfil_modulos,'') ? 'check-modulos' : '' ) ?>"><?= $this->Form->checkbox('tipo_usuarios', array('checked' => (existe($permisos->tipo_usuarios,'') ? 'checked' : ''), 'class' => 'ck-modulos-perfil')); ?></div></td>
									<th><?= $this->Form->label('tipo_usuarios', 'Tipos de usuarios'); ?></th>
								</tr>
								<!-- Grupos tarifarios -->
								<tr>
									<td class="check_perfil"><div class="<?= ( ! existe($permisos->perfil_modulos,'') ? 'check-modulos' : '' ) ?>"><?= $this->Form->checkbox('grupo_tarifarios', array('checked' => (existe($permisos->grupo_tarifarios,'') ? 'checked' : ''), 'class' => 'ck-modulos-perfil')); ?></div></td>
									<th><?= $this->Form->label('grupo_tarifarios', 'Grupos Tarifarios'); ?></th>
								</tr>
								<!-- Textos -->
								<tr>
									<td class="check_perfil"><div class="<?= ( ! existe($permisos->perfil_modulos,'') ? 'check-modulos' : '' ) ?>"><?= $this->Form->checkbox('textos', array('checked' => (existe($permisos->textos,'') ? 'checked' : ''), 'class' => 'ck-modulos-perfil')); ?></div></td>
									<th><?= $this->Form->label('textos', 'Textos'); ?></th>
								</tr>
								<!-- Query Sql -->
								<tr>
									<td class="check_perfil"><div class="<?= ( ! existe($permisos->perfil_modulos,'') ? 'check-modulos' : '' ) ?>"><?= $this->Form->checkbox('querys', array('checked' => (existe($permisos->querys,'') ? 'checked' : ''), 'class' => 'ck-modulos-perfil')); ?></div></td>
									<th><?= $this->Form->label('querys', 'Query SQL'); ?></th>
								</tr>
								<!-- Idenditicadores SQL -->
								<tr>
									<td class="check_perfil"><div class="<?= ( ! existe($permisos->perfil_modulos,'') ? 'check-modulos' : '' ) ?>"><?= $this->Form->checkbox('identificadores', array('checked' => (existe($permisos->identificadores,'') ? 'checked' : ''), 'class' => 'ck-modulos-perfil')); ?></div></td>
									<th><?= $this->Form->label('identificadores', 'Identificadores SQL'); ?></th>
								</tr>
								<!-- Carga masiva -->
								<tr>
									<td class="check_perfil"><div class="<?= ( ! existe($permisos->perfil_modulos,'') ? 'check-modulos' : '' ) ?>"><?= $this->Form->checkbox('cargar_masiva', array('checked' => (existe($permisos->cargar_masiva,'') ? 'checked' : ''), 'class' => 'ck-modulos-perfil')); ?></div></td>
									<th><?= $this->Form->label('cargar_masiva', 'Carga Masiva'); ?></th>
								</tr>
								<!-- Administradores -->
								<tr>
									<td class="check_perfil"><div class="<?= ( ! existe($permisos->perfil_modulos,'') ? 'check-modulos' : '' ) ?>"><?= $this->Form->checkbox('administradores', array('checked' => (existe($permisos->administradores,'') ? 'checked' : ''), 'class' => 'ck-modulos-perfil')); ?></div></td>
									<th><?= $this->Form->label('administradores', 'Administrdores'); ?></th>
								</tr>
								<!-- Perfiles -->
								<tr>
									<td class="check_perfil"><div class="<?= ( ! existe($permisos->perfil_modulos,'') ? 'check-modulos' : '' ) ?>"><?= $this->Form->checkbox('perfiles', array('checked' => (existe($permisos->perfiles,'') ? 'checked' : ''), 'class' => 'ck-modulos-perfil')); ?></div></td>
									<th><?= $this->Form->label('perfiles', 'Perfiles'); ?></th>
								</tr>
								<!-- Configuraciones -->
								<tr>
									<td class="check_perfil"><div class="<?= ( ! existe($permisos->perfil_modulos,'') ? 'check-modulos' : '' ) ?>"><?= $this->Form->checkbox('configuraciones', array('checked' => (existe($permisos->configuraciones,'') ? 'checked' : ''), 'class' => 'ck-modulos-perfil')); ?></div></td>
									<th><?= $this->Form->label('configuraciones', 'Configuraciones'); ?></th>
								</tr>
							</table>
				</table>
				<div class="pull-right">
					<input type="submit" class="btn btn-primary esperar-carga" autocomplete="off" data-loading-text="Espera un momento..." value="Guardar cambios">
					<?= $this->Html->link('Cancelar', array('action' => 'index'), array('class' => 'btn btn-danger')); ?>
				</div>
			<?= $this->Form->end(); ?>
		</div>
	</div>
</div>
