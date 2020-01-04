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

		$this->assertTrue($results->dontSeeElement('html'));
		$this->assertTrue($results->dontSeeElement('pre'));
	}

	public function testDashboard()
	{
		$result = $this->withURI('localhost:8080/dashboard')
						->controller(\A6\Controllers\Spotify::class)
						->execute('dashboard');

		$this->assertTrue($result->isOK());
		$this->assertTrue($result->dontSee('Hello world'));
		$this->assertTrue($result->dontSeeElement('pre'));
		$this->assertTrue($result->seeElement('p.lead'));
		$this->assertTrue($result->seeLink('See dashboard'));
		$this->assertTrue($result->see('Spotify Dashboard', 'h1'));
		$this->assertTrue($result->seeElement('#pageDashboard'));
	}
}
