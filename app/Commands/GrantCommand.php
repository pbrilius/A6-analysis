<?php

namespace A6\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class GrantCommand extends BaseCommand
{
	protected $group       = 'Spotify';
	protected $name        = 'spotify:grant';
	protected $description = 'Grants a Spotify token to client app';

	public function run(array $params)
	{
		CLI::write('Starting to request access');
		CLI::write('Client ID: ' . CLI::color(getenv('CLIENT_ID'), 'yellow'));

		$this->logger->log('info', '[INFO] Starting to grant access to API - client ID {clientId}', ['clientId' => getenv('CLIENT_ID')]);
	}
}
