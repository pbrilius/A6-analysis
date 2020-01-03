<?= $this->extend('content') ?>

<?= $this->section('dashboard') ?>
<div class="container-fluid">
	<div>
		<?= $this->renderSection('dashboardContent') ?>
	</div>
</div>
<?= $this->endSection() ?>
