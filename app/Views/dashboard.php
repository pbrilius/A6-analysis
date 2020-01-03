<?= $this->extend('content') ?>

<?= $this->section('dashboard') ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-12" id="pageDashboard">
			<?= $this->renderSection('dashboardContent') ?>
		</div>
	</div>
</div>
<?= $this->endSection() ?>
