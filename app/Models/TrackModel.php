<?php

namespace A6\Models;

use A6\Entities\Track;
use CodeIgniter\Model;

class TrackModel extends Model
{
	protected $table      = 'tracks';
	protected $primaryKey = 'id';

	protected $returnType     = Track::class;
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
