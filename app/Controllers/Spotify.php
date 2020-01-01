<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Config\View;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;

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
		$client   = $this->client;
		$response = $client->request('POST', '', [
			'auth'        => [
				getenv('CLIENT_ID'),
				getenv('CLIENT_SECRET'),
			],
			'form_params' => [
				'grant_type' => 'client_credentials',
			],
		]);

		$accessToken = json_decode($response->getBody())->access_token;

		$client = \Config\Services::curlrequest([
			'base_uri' => getenv('spotify.api.url'),
		]);

		$curl = curl_init();

		curl_setopt_array($curl, [
							  CURLOPT_URL            => getenv('spotify.api.url') . 'tracks/' . getenv('TRACK_SPOTIFY_ID'),
							  CURLOPT_RETURNTRANSFER => true,
							  CURLOPT_ENCODING       => '',
							  CURLOPT_MAXREDIRS      => 10,
							  CURLOPT_TIMEOUT        => 0,
							  CURLOPT_FOLLOWLOCATION => true,
							  CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
							  CURLOPT_CUSTOMREQUEST  => 'GET',
							  CURLOPT_HTTPHEADER     => [
				"Authorization: Bearer $accessToken"
							  ],
						  ]);

		$response = curl_exec($curl);

		curl_close($curl);

		return view('json-spotify-access', ['spotifyTrack' => $response], ['cache' => 60]);
	}
}
