<?php

namespace A6\Controllers;

use A6\Controllers\BaseController;
use A6\Entities\Token;
use A6\Models\TokenModel;
use A6\Models\TrackModel;
use A6\ThirdParty\PBGroup\JsonProcessing;
use GuzzleHttp\Client;

class Spotify extends BaseController
{

	/**
	 * CI HTTP client
	 *
	 * @var Client
	 */
	private $client;

	/**
	 * Token model
	 *
	 * @var TokenModel
	 */
	private $tokenModel;

	/**
	 * JSON processing module
	 *
	 * @var JsonProcessing
	 */
	private $jsonProcessing;

	/**
	 * Tracks model
	 *
	 * @var TrackModel
	 */
	private $trackModel;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		$options              = [
			'base_uri' => getenv('spotify.grant.url'),
			'timeout'  => 3,
		];
		$this->client         = \Config\Services::curlrequest($options);
		$this->tokenModel     = new TokenModel();
		$this->jsonProcessing = new JsonProcessing();
		$this->trackModel     = new TrackModel();
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

		if ($accessToken)
		{
			log_message('info', 'Access token granted');
		}
		else
		{
			log_message('notice', 'Access token denied');
		}

		$token         = new Token();
		$token->access = $accessToken;

		$this->tokenModel->save($token);

		$this->response->setStatusCode(200);
	}

	public function dashboard()
	{
		$tracks = $this->trackModel->findAll();

		$data = [
			'title' => 'Spotify Dashboard',
		];

		return view('Spotify/startup', $data, ['cache' => 60]);
	}
}
