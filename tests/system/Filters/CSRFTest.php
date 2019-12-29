<?php
namespace CodeIgniter\Filters;

use Config\Filters as FilterConfig;
use CodeIgniter\Config\Services;
use CodeIgniter\Filters\Exceptions\FilterException;
use CodeIgniter\Honeypot\Exceptions\HoneypotException;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * @backupGlobals enabled
 */
class CSRFTest extends \CIUnitTestCase
{

	protected $config;
	protected $request;
	protected $response;

	protected function setUp(): void
	{
		parent::setUp();
		$this->config = new \Config\Filters();
	}

	//--------------------------------------------------------------------
	public function testNormal()
	{
		$this->config->globals = [
			'before' => ['csrf'],
			'after'  => [],
		];

		$this->request  = Services::request(null, false);
		$this->response = Services::response();

		$filters = new Filters($this->config, $this->request, $this->response);
		$uri     = 'admin/foo/bar';

		// we expect CSRF requests to be ignored in CLI
		$expected = $this->request;
		$request  = $filters->run($uri, 'before');
		$this->assertEquals($expected, $request);
	}

}
