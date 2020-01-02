<?php

namespace A6\Models;

use CodeIgniter\Model;

class TokenModel extends Model
{
	protected $table      = 'tokens';
	protected $primaryKey = 'id';

	protected $allowedFields = [
		'access'
	];
	protected $returnType    = 'A6\Entities\Token';
	protected $useTimestamps = true;

}
