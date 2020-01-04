<?php

namespace A6\Entities;

use CodeIgniter\Entity;

class Track extends Entity
{
	protected $attributes = [
		'id'         => null,
		'spotifyId'  => null,
		'data'       => null,
		'created_at' => null,
		'updated_at' => null,
		'deleted_at' => null,
	];
}
