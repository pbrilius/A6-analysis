<?= $this->extend('default') ?>

<?= $this->section('content') ?>
	test content2
	<?=	$this->renderSection('dashboard') ?>
<?= $this->endSection() ?>
