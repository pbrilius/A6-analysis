<?= $this->extend('dashboard'); ?>
<? $parser = \Config\Services::parser(); ?>
<?= $this->section('dashboardContent') ?>
	<canvas id="spotifyMarketDistro"></canvas>
	<script>
		var labels = <?= $labels ?>;
		var datasets = <?= $datasets ?>;
	</script>
<?= $this->endSection() ?>
