import _ from 'lodash';
import 'bootstrap';
import Chart from 'chart.js';
global.$ = require("jquery")

$(function() {
    var ctx = $('#spotifyMarketDistro');
	var chartRadar = new Chart(ctx, {
		type: 'radar',
		data: {
			labels: labels,
			datasets: datasets
		},
		options: [

		]
	});
});