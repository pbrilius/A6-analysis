<?php

use App\Controllers\BaseController;

class Spotify extends BaseController
{
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

		$data = [
			'state' => $state,
		];
		$session->destroy();

		return view('spotify_implicit_grant', $data, ['cache' => 360]);
	}
}
