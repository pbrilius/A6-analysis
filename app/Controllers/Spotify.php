<?php

namespace A6\Controllers;

use A6\Controllers\BaseController;
use A6\Entities\Token;
use A6\Models\TokenModel;
use A6\Models\TrackModel;
use A6\ThirdParty\PBGroup\JsonProcessing;
use A6\ThirdParty\PBGroup\PlaylistRadar;
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
	 * Playlist radat
	 *
	 * @var PlaylistRadar
	 */
	private $playlistRadar;

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
		$this->playlistRadar  = new PlaylistRadar();
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
		$token->token = $accessToken;

		$this->tokenModel->save($token);

		$this->response->setStatusCode(200);
	}

	public function dashboard()
	{
		$tracks         = $this->trackModel->findAll();
		$playlistRadar  = $this->playlistRadar;
		$jsonProcessing = $this->jsonProcessing;

		$tracksData = [];
		foreach ($tracks as $track)
		{
			$tracksData[] = $track->data;
		}

		$playlistRadar->setTracks($tracksData);
		$labels  = $playlistRadar->extractLabels($tracksData);
		$markets = $playlistRadar->extractMarkets($tracksData);

		$chartLabel   = 'Global tracks (by album) market distribution';
		$datasetLabel = 'Market distro of Startup - PB Group Spotify album';

		$markets[0]->label       = $datasetLabel;
		$markets[0]->borderColor = 'rgb(49, 12, 181)';

		$jsonProcessing->setLabels($labels);
		$jsonProcessing->setDatasets($markets);
		$formattedLabels  = $jsonProcessing->labelsFormatting($labels);
		$formattedMarkets = $jsonProcessing->datasetsFormatting($markets);

		$data = [
			'title'      => 'Spotify Dashboard',
			'labels'     => $formattedLabels,
			'datasets'   => $formattedMarkets,
			'chartLabel' => $chartLabel,
		];

		return view('Spotify/startup', $data, ['cache' => 60]);
	}
}
