<?php namespace A6\Controllers;

use CodeIgniter\Test\ControllerTester;

class SpotifyTest extends \CIUnitTestCase
{
	use ControllerTester;

	public function testGrant()
	{
		$result = $this->withURI('http://localhost:8080/spotify-grant')
						->controller(\A6\Controllers\Spotify::class)
						->execute('grant');

		$this->assertTrue($result->isOK());

		$result->seeElement('pre');
	}
}
