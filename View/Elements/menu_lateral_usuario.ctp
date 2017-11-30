<div class="visible-xs">
	<select class="form-control selectHelp" onchange="location = this.options[this.selectedIndex].value;">
		<option value="<?= $this->Html->url(array('controller' => 'usuarios', 'action' => 'edit')); ?>">Mis Datos</option>
		<option value="<?= $this->Html->url(array('controller' => 'direcciones', 'action' => 'index')); ?>">Mis Direcciones</option>
	</select>
</div>
<div class="col-sm-3 menu-lateral ayuda hidden-xs">
	<h2><i class="fa fa-user icon-titulo"></i> Panel usuario</h2>
	<ul>
		<li>
			<?= $this->Html->link(
				'Mis compras <i class="fa fa-angle-right"></i>',
				array('controller' => 'compras', 'action' => 'index'),
				array('escape' => false, 'class' => ($this->params['controller'] == 'compras' && $this->params['action'] == 'index' ? 'active' : ''))
			); ?>
		</li>
		<!--
		<li>
			<?= $this->Html->link(
				'Seguimiento compras <i class="fa fa-angle-right"></i>',
				array('controller' => 'compras', 'action' => 'seguimiento'),
				array('escape' => false, 'class' => ($this->params['controller'] == 'compras' && $this->params['action'] == 'seguimiento' ? 'active' : ''))
			); ?>
		</li>
		-->
		<li>
			<?= $this->Html->link(
				'Mis datos <i class="fa fa-angle-right"></i>',
				array('controller' => 'usuarios', 'action' => 'edit'),
				array('escape' => false, 'class' => ($this->params['controller'] == 'usuarios' ? 'active' : ''))
			); ?>
		</li>
		<li>
			<?= $this->Html->link(
				'Mis direcciones <i class="fa fa-angle-right"></i>',
				array('controller' => 'direcciones', 'action' => 'index'),
				array('escape' => false, 'class' => ($this->params['controller'] == 'direcciones' ? 'active' : ''))
			); ?>
		</li>
	</ul>
</div>
