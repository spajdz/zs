<div class="page-title">
	<h2><span class="fa fa-database"></span> Querys SQL</h2>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Nueva query</h3>
	</div>
	<div class="panel-body">
		<div class="table-responsive">
			<?= $this->Form->create('Query', array('class' => 'form-horizontal', 'type' => 'file', 'inputDefaults' => array('label' => false, 'div' => false, 'class' => 'form-control'))); ?>
				<table class="table">
					<tr>
						<th><?= $this->Form->label('identificador', 'Identificador'); ?></th>
						<td><?= $this->Form->input('identificador'); ?></td>
					</tr>
					<tr>
						<th><?= $this->Form->label('descripcion', 'Descripcion'); ?></th>
						<td><?= $this->Form->input('descripcion'); ?></td>
					</tr>
					<tr>
						<th><?= $this->Form->label('query', 'Query'); ?></th>
						<td><?= $this->Form->input('query'); ?></td>
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
editor.on('change', function(instancia, cambio)
{
	$('#QueryQuery').text(instancia.getValue());
});
editor.setSize('100%', 320);
</script>
