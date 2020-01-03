<?= $this->extend('default') ?>
test content
<?= $this->section('content') ?>
	<?=	$this->renderSection('dashboard') ?>
<?= $this->endSection() ?>
