<?php

namespace A6\Commands;

use A6\Models\PlaylistModel;
use A6\Models\TokenModel;
use A6\Models\TrackModel;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use CodeIgniter\Database\BaseConnection;

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

	public function __construct()
	{
		$this->tokenModel    = new TokenModel();
		$this->playlistModel = new PlaylistModel();
		$this->trackModel    = new TrackModel();

		$this->db = db_connect();
	}

	public function run(array $params)
	{
		$db = $this->db;

		CLI::write('A starter pack is launching track set');
		log_message('info', 'Starting to store tracklist {tracklist}', ['tracklist' => getenv('PLAYLIST_SPOTIFY_ID')]);

		$builder = $db->table('tokens');
		$query   = $builder
			->select('access')
			->orderBy('created_at', 'DESC')
			->get(1, 0);

		$token = $query->getResult()[0];
	}

}
