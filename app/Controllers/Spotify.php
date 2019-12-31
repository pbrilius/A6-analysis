<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Spotify extends BaseController
{
	/**
	 * Controller helpers
	 *
	 * @var array
	 */
	protected $helpers = ['url'];

	/**
	 * Grant user a Spotify access by his consent
	 *
	 * @return void
	 */
	public function grant()
	{
		$session = session();

		$state = hash('haval160,4', uniqid('sp'));
		$session->set('state', $state);

		var_dump(getenv('CLIENT_ID'));

		$data = [
			'state'       => $state,
			'redirectUrl' => site_url('/spotify-access'),
		];
		$session->destroy();

		return view('spotify_implicit_grant', $data, ['cache' => 360]);
	}
}
