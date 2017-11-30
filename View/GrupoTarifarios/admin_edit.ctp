<div class="page-title">
	<h2><span class="fa fa-dollar"></span> Grupos Tarifarios</h2>
</div>
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Editar grupo tarifario</h3>
	</div>
	<div class="panel-body">
		<div class="table-responsive">
			<?= $this->Form->create('GrupoTarifario', array('class' => 'form-horizontal', 'type' => 'file', 'inputDefaults' => array('label' => false, 'div' => false, 'class' => 'form-control'))); ?>
				<table class="table">
					<?= $this->Form->input('id'); ?>
					<!-- NOMBRE -->
					<tr>
						<th><?= $this->Form->label('nombre', 'Nombre'); ?></th>
						<td><?= $this->Form->input('nombre'); ?></td>
					</tr>
					<!-- COMENTARIO -->
					<tr>
						<th><?= $this->Form->label('comentario', 'Comentario'); ?></th>
						<td><?= $this->Form->input('comentario'); ?></td>
					</tr>
					<!--  QUERY -->
					<tr>
						<th><?= $this->Form->label('query_id', 'Query'); ?></th>
						<td><?= $this->Form->input('query_id', array('class' => 'form-control select')); ?></td>
					</tr>
					<!--  USUARIOS-->
					<tr>
						<th><?= $this->Form->label('', 'Usuario'); ?></th>
						<td><?= $this->Form->input('usuario', array(
								'type'				=>	'text',
								'value'				=> '',
								'placeholder'		=> 'Escribe el nombre del usuario o bien su telefono o E-mail',
								'data-provide'		=> 'typeahead',
								'autocomplete'		=> 'off'
							)); ?>
						</td>
					</tr>
					<!-- Tabla de usuarios -->
					<tr>
						<td colspan="2">
							<div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Usuarios</h3>
                                </div>
                                <div class="panel-body panel-body-table">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped table-actions tabla-usuarios">
                                            <thead>
                                                <tr>
                                                    <th width="20%">Tipo Usuario</th>
                                                    <th width="30%">Nombre</th>
                                                    <th width="20%">E-mail</th>
                                                    <th width="20%">Celular</th>
                                                    <th width="10%">Opciones</th>
                                                </tr>
                                            </thead>
											<tbody>
												<? foreach ( $this->request->data['Usuario'] as $grupoUsuarios) : ?>
													<tr>
														<td width="100">
															<?= $grupoUsuarios['TipoUsuario']['nombre']; ?>
															<input type="hidden" name="data[Usuario][][usuario_id]" value="<?= $grupoUsuarios['id']; ?>" />
														</td>
														<td><?= $grupoUsuarios['nombre_apellidos']; ?></td>
														<td><?= $grupoUsuarios['email']; ?></td>
														<td><?= $grupoUsuarios['celular']; ?></td>
														<td><a href="#" class="btn btn-danger js-elimina-usuario"><span class="fa fa-times"></span></td>
													</tr>
												<? endforeach; ?>
											</tbody>
                                        </table>
                                    </div>
                                </div>
                            </div
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
