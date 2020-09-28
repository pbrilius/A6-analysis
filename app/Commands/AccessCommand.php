<?php

namespace A6\Commands;

use A6\Entities\Track;
use A6\Models\PlaylistModel;
use A6\Models\TokenModel;
use A6\Models\TrackModel;
use App\Entities\Playlist;
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
			->select('token, created_at')
			->orderBy('created_at', 'DESC')
			->get(1, 0);

		$accessToken = $query->getResult()[0]->access;

		CLI::write('Access token: ' . CLI::color($accessToken, 'light_green'));
		log_message('info', 'Access token {accessToken}', ['accessToken' => $accessToken]);

		$message = 'Getting playlist info';
		CLI::write($message);
		log_message('info', $message);

		$response = $client->get('playlists/' . getenv('PLAYLIST_SPOTIFY_ID'), [
			'headers' => [
				'Authorization' => 'Bearer ' . $accessToken,
			],
		]);

		if ($response->getStatusCode() !== 200)
		{
			$message = 'Spotify playlist access denied';
			CLI::error($message);
			log_message($message);
			return;
		}

		$builder           = $db->table('playlists');
		$playlistPersisted = $builder->getWhere([
			'spotifyId' => getenv('PLAYLIST_SPOTIFY_ID'),
		])->getResult();

		if (! $playlistPersisted)
		{
			$playlist = new Playlist();
		}
		else
		{
			$playlist = $this->playlistModel->find($playlistPersisted[0]->id);
		}
		$playlist->fill([
			'spotifyId' => getenv('PLAYLIST_SPOTIFY_ID'),
			'data'      => $response->getBody(),
		]);
		$this->playlistModel->save($playlist);

		CLI::write('Checked for playlist in database and ' . CLI::color('updated', 'light_red') . ' details');
		CLI::write(CLI::color('Querying', 'light_cyan') . ' for playlist tracks');

		$response = $client->get('playlists/' . getenv('PLAYLIST_SPOTIFY_ID') . '/tracks', [
			'headers' => [
				'Authorization' => 'Bearer ' . $accessToken,
			],
		]);

		$tracks = json_decode($response->getBody(), true)['items'];
		CLI::write(CLI::color('Storing and persisting', 'light_cyan') . ' playlist tracks');

		$totalSteps = count($tracks);
		$currStep   = 1;
		foreach ($tracks as $track)
		{
			// CLI::write('Persisting and updating track: ' . CLI::color($track['track']['id'], 'light_red'));
			$builder        = $db->table('tracks');
			$persistedTrack = $builder->getWhere([
				'spotifyId' => $track['track']['id'],
			])->getResult();

			if (! $persistedTrack)
			{
				$trackEntity = new Track();
			}
			else
			{
				$trackEntity = $this->trackModel->find($persistedTrack[0]->id);
			}
			$trackEntity->fill([
				'spotifyId' => $track['track']['id'],
				'data'      => json_encode($track),
			]);

			$this->trackModel->save($trackEntity);
			CLI::showProgress($currStep++, $totalSteps);
		}

		CLI::clearScreen();
		CLI::write('Playlist tracks operations performed');
	}

}
