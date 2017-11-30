
<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<?= $this->Html->css(array('sitio-pdf'), null, array('fullBase' => true)); ?>
	</head>
	<body>
		<?= $this->fetch('content'); ?>
	</body>
</html>
