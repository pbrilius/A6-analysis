<?php

namespace A6\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class StoreTracks extends BaseCommand
{
	protected $group       = 'Spotify';
	protected $name        = 'spotify:access';
	protected $description = 'Store Spotify accessed track list';

	public function __construct()
	{
	}

	public function run(array $params)
	{
		CLI::write('A starter pack launching track set');
		log_message('info', 'Starting to store tracklist {tracklist}', ['tracklist' => genenv('TRACKLIT_ID')]);
	}

}
