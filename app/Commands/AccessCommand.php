<?php

namespace A6\Commands;

use A6\Models\PlaylistModel;
use A6\Models\TokenModel;
use A6\Models\TrackModel;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use CodeIgniter\Database\BaseConnection;
use GuzzleHttp\Client;

class AccessCommand extends BaseCommand
{
	protected $group       = 'Spotify';
	protected $name        = 'spotify:access';
	protected $description = 'Store Spotify accessed track list';

	/**
	 * Token model
	 *
	 * @var TokenModel
	 */
	private $tokenModel;

	/**
	 * Playlist model
	 *
	 * @var PlaylistModel
	 */
	private $playlistModel;

	/**
	 * Track model
	 *
	 * @var TrackModel
	 */
	private $trackModel;

	/**
	 * Database connection
	 *
	 * @var BaseConnection
	 */
	private $db;

	/**
	 * CURL CI client
	 *
	 * @var Client
	 */
	private $client;

	public function __construct()
	{
		$this->tokenModel    = new TokenModel();
		$this->playlistModel = new PlaylistModel();
		$this->trackModel    = new TrackModel();

		$this->db = db_connect();

		$options      = [
			'base_uri' => getenv('spotify.api.url'),
			'timeout'  => 4,
		];
		$this->client = \Config\Services::curlrequest($options);
	}

	public function run(array $params)
	{
		$db     = $this->db;
		$client = $this->client;

		CLI::write('A starter pack is launching track set');
		log_message('info', 'Starting to store tracklist {tracklist}', ['tracklist' => getenv('PLAYLIST_SPOTIFY_ID')]);

		$builder = $db->table('tokens');
		$query   = $builder
			->select('access, created_at')
			->orderBy('created_at', 'DESC')
			->get(1, 0);

		var_dump($query->getResult()[0]->created_at);
		// die;
		$accessToken = $query->getResult()[0]->access;

		CLI::write('Access token: ' . CLI::color($accessToken, 'light_green'));
		log_message('info', 'Access token {accessToken}', ['accessToken' => $accessToken]);

		$response = $client->get('playlists/' . getenv('PLAYLIST_SPOTIFY_ID') . '/tracks', [
			'headers' => [
				'Authorization' => 'Bearer ' . $accessToken,
			],
		]);

		var_dump($response->getStatusCode());
	}

}
