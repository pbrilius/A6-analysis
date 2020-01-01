<?php

namespace App\Controllers;

use App\Controllers\BaseController;
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
		var_export($response->getStatusCode());
		var_export($response->getReason());
		var_export($response->getBody());

		$accessToken = json_decode($response->getBody())->access_token;
		var_dump('access token');
		var_dump($accessToken);

		// $client = \Config\Services::curlrequest([
		// 	'base_uri' => getenv('spotify.api.url'),
		// 	'timeout'  => 3,
		// ]);
		// var_dump(get_class($client));
		// var_dump($client->get_case);
		var_dump(getenv('TRACK_SPOTIFY_ID'));
		$client = \Config\Services::curlrequest([
			'base_uri' => getenv('spotify.api.url'),
		]);
		var_dump('test msg11');
		var_dump(getenv('spotify.api.url') . 'tracks/' . getenv('TRACK_SPOTIFY_ID'));
		try
		{
			$response = $client->get('tracks/' . getenv('TRACK_SPOTIFY_ID'), [
				'headers' => [
					'Authorization' => 'Bearer ' . $accessToken,
				],
				'debug'   => true,
			]);
		}
		catch (RequestException $e)
		{
		}
		catch (ClientException $e)
		{
			echo Psr7\str($e->getRequest());
			echo Psr7\str($e->getResponse());
		}
		catch (\Exception $e)
		{
			var_dump($client->getHeaders());
			var_dump('test msg');
			var_export($response->getStatusCode());
			var_export($response->getReason());
			var_export($response->getBody());
			var_dump($e->getMessage());
		}
	}
}
