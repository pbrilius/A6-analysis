<?php namespace A6\Controllers;

use CodeIgniter\Test\ControllerTester;

class SpotifyTest extends \CIUnitTestCase
{
	use ControllerTester;

	public function testGrant()
	{
		$result = $this->withURI(site_url(['spotify-grant']))
						->controller(\A6\Controllers\Spotify::class)
						->execute('grant');

		$this->assertTrue($result->isOK());

		$results->dontSeeElement('html');
		$results->dontSeeElement('pre');
	}
}
