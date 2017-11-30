<div class="page-title">
	<h2><span class="fa fa-database"></span> Querys SQL</h2>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Editar query</h3>
	</div>
	<div class="panel-body">
		<div class="table-responsive">
			<?= $this->Form->create('Query', array('class' => 'form-horizontal', 'type' => 'file', 'inputDefaults' => array('label' => false, 'div' => false, 'class' => 'form-control'))); ?>
				<table class="table">
					<?= $this->Form->input('id'); ?>
					<tr>
						<th><?= $this->Form->label('identificador', 'Identificador'); ?></th>
						<td><?= $this->request->data['Query']['identificador'] ?></td>
					</tr>
					<tr>
						<th><?= $this->Form->label('descripcion', 'Descripcion'); ?></th>
						<td><?= $this->Form->input('descripcion'); ?></td>
					</tr>
					<tr>
						<th>Variables</th>
						<td>
							<dl class="dl-horizontal">
								<? foreach ( $identificadores as $identificador ) : ?>
								<dt><span class="label label-form label-success">:<?= h($identificador['Identificador']['identificador']); ?></span></dt>
								<dd><?= h($identificador['Identificador']['descripcion']); ?></dd>
								<? endforeach; ?>
							</dl>
						</td>
					</tr>
					<tr>
						<th><?= $this->Form->label('query', 'Query'); ?></th>
						<td><?= $this->Form->input('query'); ?></td>
					</tr>
					<tr>
						<th><?= $this->Form->label('comentarios', 'Comentarios'); ?></th>
						<td>
							<?= $this->Form->input('comentarios'); ?>
							<p class="help-block">* Ingresa aca el motivo de esta modificación</p>
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

<script>
var editor = CodeMirror.fromTextArea(document.getElementById('QueryQuery'),
{
	mode				: 'text/x-mssql',
	lineNumbers			: true,
	matchBrackets		: true,
	indentUnit			: 4,
	indentWithTabs		: true
});
editor.setSize('100%', 320);
</script>

<? if ( $versiones ) : ?>
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Historial</h3>
	</div>
	<div class="panel-body">
		<div class="table-responsive">
			<table class="table query-historial-versiones">
				<tr>
					<th>Versión</th>
					<th>Fecha cambio</th>
					<th>Autor</th>
					<th>Query</th>
					<th>Comentarios</th>
					<th>Acciones</th>
				</tr>
				<? foreach ( $versiones as $version ) : ?>
				<tr>
					<td><?= h($version['Query']['version']); ?></td>
					<td><?= h($version['Query']['created']); ?></td>
					<td><?= h($version['Administrador']['nombre']); ?></td>
					<td>
						<p class="extracto"><?= $this->Text->truncate($version['Query']['query'], 50); ?></p>
						<pre class="query"><?= h($version['Query']['query']); ?></pre>
					</td>
					<td><?= ($version['Query']['version'] == 1 ? 'Versión inicial' : h($version['Query']['comentarios'])); ?></td>
					<td>
						<a href="#" class="js-query-ver-query btn btn-mini btn-default"><i class="fa fa-file-o"></i> Ver query</a>
						<?= $this->Html->link('<i class="fa fa-database"></i> Restaurar', array('action' => 'restore', $version['Query']['id']), array('class' => 'btn btn-mini btn-info', 'rel' => 'tooltip', 'title' => 'Restaurar esta query', 'escape' => false)); ?>
					</td>
				</tr>
				<? endforeach; ?>
			</table>
		</div>
	</div>
</div>
<? endif; ?>
