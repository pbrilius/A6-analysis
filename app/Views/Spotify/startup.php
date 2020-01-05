<?= $this->extend('dashboard'); ?>
<?= $parser = \Config\Services::parser(); ?>
<?= $this->section('dashboardContent') ?>
	<canvas id="spotifyMarketDistro"></canvas>
	<script>
	var ctx = $('spotifyMarketDistro');
	var chartRadar = new Chart(ctx, {
		type: 'radar',
		data: [
			labels: <?= $parser->setData([
                            'labels' => $labels,
                        ])->renderString('{ labels|esc("js") }') ?>
		],
		options: [

		]
	});
	</script>
<?= $this->endSection() ?>
