<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use GuzzleHttp\Client;

class Spotify extends BaseController
{

	/**
	 * Undocumented variable
	 *
	 * @var Client
	 */
	private $client;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct();
		$options      = [
			'base_uri' => getenv('spotify.grant.url'),
			'timeout'  => 3,
		];
		$this->client = \Config\Services::curlrequest($options);
	}

	/**
	 * Grant user a Spotify access by his consent
	 *
	 * @return void
	 */
	public function grant()
	{
	}
}
