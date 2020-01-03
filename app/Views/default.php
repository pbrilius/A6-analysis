<!doctype html>
<html>
<head>
    <title><?= $title ?></title>
</head>
<body>
	<header>
		<?= $this->include('header') ?>
	</header>
    <?= $this->renderSection('content') ?>
	<footer>
		<?=	$this->include('footer') ?>
	</footer>
	<?= $this->renderSection('scripts/A6') ?>
</body>
</html>
