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

		$this->logger->log('info', '[CLI] Starting to grant access to API - client ID {clientId}', ['clientId' => getenv('CLIENT_ID')]);

		$options  = [
			'base_uri' => base_url(),
			'timeout'  => 3,
		];
		$client   = \Config\Services::curlrequest($options);
		$response = $client->get(site_url(['spotify-grant']));

		CLI::write('Received response: ' . CLI::color($response->getStatusCode(), 'light_blue', 'light_gray'));

		if ($response->getStatusCode() >= '400')
		{
			CLI::error('Access denied');
			$this->logger->log('error', 'Access denied');
		}
		else
		{
			CLI::write('Access granted', 'light_green');
			$this->logger->log('info', 'Access granted');
		}
	}
}
