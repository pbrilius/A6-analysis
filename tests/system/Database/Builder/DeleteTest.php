<?php namespace Builder;

use Tests\Support\Database\MockConnection;

class DeleteTest extends \CIUnitTestCase
{
	protected $db;

	//--------------------------------------------------------------------

	protected function setUp(): void
	{
		parent::setUp();

		$this->db = new MockConnection([]);
	}

	//--------------------------------------------------------------------

	public function testDelete()
	{
		$builder = $this->db->table('jobs');

		$answer = $builder->testMode()->delete(['id' => 1], null, true);

		$expectedSQL   = 'DELETE FROM "jobs" WHERE "id" = :id:';
		$expectedBinds = [
			'id' => [
				1,
				true,
			],
		];

		$this->assertEquals($expectedSQL, str_replace("\n", ' ', $answer));
		$this->assertEquals($expectedBinds, $builder->getBinds());
	}

	//--------------------------------------------------------------------
}
