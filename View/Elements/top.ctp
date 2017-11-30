<div class="nav-top hidden-xs">
	<ul>
		<!--
		<li class="hidden-xs"><a href="#"><i class="fa fa-facebook"></i></a></li>
		<li class="hidden-xs"><a href="#"><i class="fa fa-twitter"></i></a></li>
		-->
		<li><?= $this->Html->link('<i class="fa fa-envelope"></i>', array('controller' => 'contactos', 'action' => 'add'), array('escape' => false)); ?></li>
		<li><?= $this->Html->link('Ayuda', array('controller' => 'ayudas')); ?></li>
		<li><?= $this->Html->link('Sucursales', array('controller' => 'sucursales')); ?></li>
		<li><a href="tel:+56222109100" class="fono">+56 2 2210 9100</a></li>
	</ul>
</div>
