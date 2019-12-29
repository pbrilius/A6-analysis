<?php

namespace CodeIgniter\HTTP;

use Config\App;
use CodeIgniter\Config\Services;
use CodeIgniter\Validation\Validation;
use CodeIgniter\Router\RouteCollection;
use Tests\Support\HTTP\MockIncomingRequest;

class RedirectResponseTest extends \CIUnitTestCase
{

	/**
	 * @var RouteCollection
	 */
	protected $routes;
	protected $request;
	protected $config;

	protected function setUp(): void
	{
		parent::setUp();

		$_SERVER['REQUEST_METHOD'] = 'GET';

		$this->config          = new App();
		$this->config->baseURL = 'http://example.com';

		$this->routes = new RouteCollection(Services::locator(), new \Config\Modules());
		Services::injectMock('routes', $this->routes);

		$this->request = new MockIncomingRequest($this->config, new URI('http://example.com'), null, new UserAgent());
		Services::injectMock('request', $this->request);
	}

	//--------------------------------------------------------------------

	public function testRedirectToFullURI()
	{
		$response = new RedirectResponse(new App());

		$response = $response->to('http://example.com/foo');

		$this->assertTrue($response->hasHeader('Location'));
		$this->assertEquals('http://example.com/foo', $response->getHeaderLine('Location'));
	}

	//--------------------------------------------------------------------

	public function testRedirectRoute()
	{
		$response = new RedirectResponse(new App());

		$this->routes->add('exampleRoute', 'Home::index');

		$response->route('exampleRoute');

		$this->assertTrue($response->hasHeader('Location'));
		$this->assertEquals('http://example.com/exampleRoute', $response->getHeaderLine('Location'));

		$this->routes->add('exampleRoute', 'Home::index', ['as' => 'home']);

		$response->route('home');

		$this->assertTrue($response->hasHeader('Location'));
		$this->assertEquals('http://example.com/exampleRoute', $response->getHeaderLine('Location'));
	}

	public function testRedirectRouteBad()
	{
		$this->expectException(Exceptions\HTTPException::class);

		$response = new RedirectResponse(new App());

		$this->routes->add('exampleRoute', 'Home::index');

		$response->route('differentRoute');
	}

	//--------------------------------------------------------------------

	public function testRedirectRelativeConvertsToFullURI()
	{
		$response = new RedirectResponse($this->config);

		$response = $response->to('/foo');

		$this->assertTrue($response->hasHeader('Location'));
		$this->assertEquals('http://example.com/foo', $response->getHeaderLine('Location'));
	}

	//--------------------------------------------------------------------

	/**
	 * @runInSeparateProcess
	 * @preserveGlobalState  disabled
	 */
	public function testWithInput()
	{
		$_SESSION = [];
		$_GET     = ['foo' => 'bar'];
		$_POST    = ['bar' => 'baz'];

		$response = new RedirectResponse(new App());

		$returned = $response->withInput();

		$this->assertSame($response, $returned);
		$this->assertArrayHasKey('_ci_old_input', $_SESSION);
		$this->assertEquals('bar', $_SESSION['_ci_old_input']['get']['foo']);
		$this->assertEquals('baz', $_SESSION['_ci_old_input']['post']['bar']);
	}

	//--------------------------------------------------------------------

	/**
	 * @runInSeparateProcess
	 * @preserveGlobalState  disabled
	 */
	public function testWithValidationErrors()
	{
		$_SESSION = [];

		$response = new RedirectResponse(new App());

		$validation = $this->createMock(Validation::class);
		$validation->method('getErrors')
				->willReturn(['foo' => 'bar']);

		Services::injectMock('validation', $validation);

		$response->withInput();

		$this->assertArrayHasKey('_ci_validation_errors', $_SESSION);
	}

	//--------------------------------------------------------------------

	/**
	 * @runInSeparateProcess
	 * @preserveGlobalState  disabled
	 */
	public function testWith()
	{
		$_SESSION = [];

		$response = new RedirectResponse(new App());

		$returned = $response->with('foo', 'bar');

		$this->assertSame($response, $returned);
		$this->assertArrayHasKey('foo', $_SESSION);
	}

	//--------------------------------------------------------------------

	/**
	 * @runInSeparateProcess
	 * @preserveGlobalState  disabled
	 */
	public function testRedirectBack()
	{
		$_SERVER['HTTP_REFERER'] = 'http://somewhere.com';
		$this->request           = new MockIncomingRequest($this->config, new URI('http://somewhere.com'), null, new UserAgent());
		Services::injectMock('request', $this->request);

		$response = new RedirectResponse(new App());

		$returned = $response->back();
		$this->assertEquals('http://somewhere.com', $returned->getHeader('location')->getValue());
	}

	/**
	 * @runInSeparateProcess
	 * @preserveGlobalState  disabled
	 */
	public function testRedirectBackMissing()
	{
		$_SESSION = [];

		$response = new RedirectResponse(new App());

		$returned = $response->back();

		$this->assertSame($response, $returned);
	}

}
