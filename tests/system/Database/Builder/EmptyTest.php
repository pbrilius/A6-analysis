<?php namespace Builder;

use CodeIgniter\Database\BaseBuilder;
use Tests\Support\Database\MockConnection;

class EmptyTest extends \CIUnitTestCase
{
	protected $db;

	//--------------------------------------------------------------------

	protected function setUp(): void
	{
		parent::setUp();

		$this->db = new MockConnection([]);
	}

	//--------------------------------------------------------------------

	public function testEmptyWithNoTable()
	{
		$builder = new BaseBuilder('jobs', $this->db);

		$answer = $builder->testMode()->emptyTable();

		$expectedSQL = 'DELETE FROM "jobs"';

		$this->assertEquals($expectedSQL, str_replace("\n", ' ', $answer));
	}

	//--------------------------------------------------------------------

}
