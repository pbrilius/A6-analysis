<?php

namespace A6\Models;

use App\Entities\Playlist;
use CodeIgniter\Model;

class PlaylistModel extends Model
{
	protected $table      = 'playlists';
	protected $primaryKey = 'id';

	protected $returnType     = Playlist::class;
	protected $useSoftDeletes = true;

	protected $allowedFields = [
		'spotifyId',
		'data',
	];

	protected $useTimestamps = true;

	protected $validationRules    = [];
	protected $validationMessages = [];
	protected $skipValidation     = true;

}
