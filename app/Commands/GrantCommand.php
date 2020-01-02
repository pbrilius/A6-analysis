<?php

namespace A6\Commands;

use CodeIgniter\CLI\BaseCommand;

class GrantCommand extends BaseCommand
{
	protected $group       = 'Spotify';
	protected $name        = 'spotify:grant';
	protected $description = 'Grants a Spotify token to client app';

	public function run(array $params)
	{
	}
}
