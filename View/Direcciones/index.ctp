<div class="contenedor">
    <div class="row">
		<?= $this->element('menu_lateral_usuario'); ?>
		<div class="col-sm-9 contenido">
			<h2>Mis Direcciones</h2>
			<?= $this->element('alertas'); ?>
			<div class="row" id="no-more-tables">
				<table class="table-striped table-condensed cf">
					<thead class="cf">
						<tr>
							<th class="numeric">Calle</th>
							<th class="numeric">Número</th>
							<th class="numeric">Dpto.</th>
							<th class="numeric">Región</th>
							<th class="numeric">Comuna</th>
							<th class="numeric">Código Postal</th>
							<th class="numeric">Celular</th>
							<th class="numeric">Editar</th>
							<th class="numeric">Eliminar</th>
						</tr>
					</thead>
					<tbody>
						<? foreach ( $direcciones as $direccion ) : ?>
						<tr>
							<td data-title="Calle:"><?= h($direccion['Direccion']['calle']); ?></td>
							<td data-title="Número:"><?= h($direccion['Direccion']['numero']); ?></td>
							<td data-title="Casa/Dpto.:"><?= h($direccion['Direccion']['depto']); ?></td>
							<td data-title="Región:"><?= h($direccion['Comuna']['Region']['nombre']); ?></td>
							<td data-title="Comuna:"><?= h($direccion['Comuna']['nombre']); ?></td>
							<td data-title="Código Postal:"><?= h($direccion['Direccion']['codigo_postal']); ?></td>
							<td data-title="Celular:"><?= h($direccion['Direccion']['telefono']); ?></td>
							<td data-title="Editar:">
								<?= $this->Html->link(
									'<i class="fa fa-pencil-square-o"></i>',
									array('action' => 'edit', $direccion['Direccion']['id']),
									array('escape' => false)
								); ?>
							</td>
							<td data-title="Eliminar:">
								<?= $this->Html->link(
									'x',
									array('action' => 'delete', $direccion['Direccion']['id']),
									array('escape' => false)
								); ?>
							</td>
						</tr>
						<? endforeach; ?>
					</tbody>
				</table>
			</div>
			<!--
			<div class="row">
				<div class="col-sm-8 col-xs-4"></div>
				<div class="col-sm-4 col-xs-8 right">
					<?= $this->Html->link(
						'Agregar nueva dirección',
						array('action' => 'add'),
						array('class' => 'btn')
					); ?>
				</div>
			</div>
			-->
		</div>
	</div>
</div>
