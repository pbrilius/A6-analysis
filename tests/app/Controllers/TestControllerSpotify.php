<?php namespace A6\Controllers;

use CodeIgniter\Test\ControllerTester;

class TestControllerSpotify extends \CodeIgniter\Test\CIDatabaseTestCase
{
	use ControllerTester;

	public function testGrant()
	{
		$result = $this->withURI('localhost:8080/spotify-grant')
						->controller(\A6\Controllers\Spotify::class)
						->execute('grant');

		$this->assertTrue($result->isOK());

		$results->dontSeeElement('html');
		$results->dontSeeElement('pre');
	}
}
