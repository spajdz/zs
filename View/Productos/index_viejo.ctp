<?= $this->element('buscadores/'.$categoria); ?>

<?foreach($productos as $producto):?>
	<div><?= $producto['Producto']['nombre'];?></div>
<?endforeach;?>

<?=$this->Paginator->numbers(array('first' => 'First page'));?>