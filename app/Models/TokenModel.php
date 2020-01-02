<?php

namespace App\Models;

use CodeIgniter\Model;

class TokenModel extends Model
{
	protected $table      = 'tokens';
	protected $primaryKey = 'id';

	protected $allowedFields = [
		'access'
	];
	protected $returnType    = 'App\Entities\Token';
	protected $useTimestamps = true;

}
