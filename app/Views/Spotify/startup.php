<?= $this->extend('dashboard'); ?>

<?= $this->section('dashboardContent') ?>
	<canvas id="spotifyMarketDistro"></canvas>
	<script>
	var ctx = $('spotifyMarketDistro');
	var chartRadar = new Chart(ctx, {
		type: 'radar',
		data: data,
		options: [

		]
	});
	</script>
<?= $this->endSection() ?>
