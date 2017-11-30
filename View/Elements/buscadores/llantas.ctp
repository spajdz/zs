<?= $this->Form->create('Producto', array('url' => '/filtros' , 'class' => 'form-horizontal', 'inputDefaults' => array('label' => false, 'div' => false), 'id' => 'ProductoFiltroForm')); ?>

<?= $this->Form->input('categoria', array('type' => 'hidden', 'value' => $categoria)); ?>
<?= $this->Form->input('aro', array('class' => 'form-control input-md', 'placeholder' => 'Aro', 'style' => 'width: 200px')); ?>
<?= $this->Form->input('apernadura', array('class' => 'form-control input-md', 'placeholder' => 'Apernadura', 'style' => 'width: 200px')); ?>
<?= $this->Form->input('filtro', array('class' => 'form-control input-md', 'placeholder' => 'Escribe tu busqueda', 'style' => 'width: 200px')); ?>

<button class="js-buscar-productos">Buscar</button>
<?= $this->Form->end(); ?>
