<?php namespace App\Controllers;

use CodeIgniter\Test\ControllerTester;

class SpotifyTest extends \CIUnitTestCase
{
	use ControllerTester;

	public function testGrant()
	{
		$result = $this->withURI('http://localhost:8080/spotify-grant')
						->controller(\App\Controllers\Spotify::class)
						->execute('grant');

		$this->assertTrue($result->isOK());

		$result->seeElement('pre');
	}
}
