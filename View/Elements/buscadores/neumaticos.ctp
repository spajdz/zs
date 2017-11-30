<?= $this->Form->create('Producto', array('url' => '/filtros' , 'class' => 'form-horizontal', 'inputDefaults' => array('label' => false, 'div' => false), 'id' => 'ProductoFiltroForm')); ?>

	<?= $this->Form->input('categoria', array('type' => 'hidden', 'value' => $categoria, 'id' => 'buscador-categoria')); ?>

	<?= $this->Form->input('marca', array('id' =>'buscador-marca' ,  'class' => 'form-control input-md', 'placeholder' => 'Marca', 'style' => 'width: 200px', 'options' => $marcas_vehiculo, 'empty' => 'Marca')); ?>

	<?= $this->Form->input('modelo', array('id' =>'buscador-modelo' ,'class' => 'form-control input-md', 'placeholder' => 'Modelo', 'style' => 'width: 200px', 'options' => $modelos_vehiculo)); ?>

	<?= $this->Form->input('version', array('id' =>'buscador-version' ,'class' => 'form-control input-md', 'placeholder' => 'Version', 'style' => 'width: 200px', 'options' => $versiones_vehiculo)); ?>

	<?= $this->Form->input('ano', array('id' =>'buscador-ano','class' => 'form-control input-md', 'placeholder' => 'Año', 'style' => 'width: 200px', 'options' => $anos_vehiculo)); ?>
	
	<?= $this->Form->input('ancho', array('id' => 'buscador-ancho','class' => 'form-control input-md', 'placeholder' => 'Ancho', 'style' => 'width: 200px', 'options' => $anchos_neumaticos, 'empty' => 'Ancho')); ?>

	<?= $this->Form->input('perfil', array('id' => 'buscador-perfil', 'class' => 'form-control input-md', 'placeholder' => 'Perfil', 'style' => 'width: 200px', 'options' => $perfiles_vehiculos, 'empty' => 'Perfil')); ?>

	<?= $this->Form->input('aro', array('id' => 'buscador-aro', 'class' => 'form-control input-md', 'placeholder' => 'Aro', 'style' => 'width: 200px', 'options' => $aros_vehiculos, 'empty' => 'Aro')); ?>

	<?= $this->Form->input('filtro', array('class' => 'form-control input-md', 'placeholder' => 'Escribe tu busqueda', 'style' => 'width: 200px')); ?>

<button class="js-buscar-productos">Buscar</button>
<?= $this->Form->end(); ?>
