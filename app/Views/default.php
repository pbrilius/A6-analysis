<!doctype html>
<html>
<head>
    <title><?= $title ?></title>
</head>
<body>
    <?= $this->renderSection('content') ?>
	<footer>
		<?=	$this->include('footer') ?>
	</footer>
</body>
	<?= $this->renderSection('scripts/A6') ?>
</html>
