<?php

use BankServer\Domain\Service\BillingService;

use Prophecy\Prophet;

use BankServer\Domain\Entity\Transaction;

use BankServer\Persistence\Laravel\Hydrator\SimpleHydrator;

class SimpleHydratorTest extends PHPUnit_Framework_TestCase
{
	private $prophet;

	protected $entity;
	protected $hydrator;

	public function setUp()
    {
		$this->prophet = new Prophet;

		$this->entity = $this->prophet
			->prophesize('BankServer\Domain\Entity\Transaction');

		$this->hydrator = new SimpleHydrator;
    }

	public function tearDown()
    {
		$this->prophet->checkPredictions();
    }

	/**
	 * Test extraction
	 */
	public function testExtract()
	{
		$this->entity->getId()->willReturn(null);
		$this->entity->getCardId()->willReturn(1);
		$this->entity->getAmount()->willReturn(5);
		$this->entity->getStatus()->willReturn('new');
		$this->entity->getToken()->willReturn('foobar');
		$this->entity->getCreatedAt()->willReturn('2015-07-14 14:58:22');
		$this->entity->getUpdatedAt()->willReturn('2015-07-14 14:58:22');

		$this->assertEquals(
			$this->hydrator->extract($this->entity->reveal()),
			[
				'card_id' => 1,
				'amount' => 5,
				'status' => 'new',
				'token' => 'foobar',
				'created_at' => '2015-07-14 14:58:22',
				'updated_at' => '2015-07-14 14:58:22',
			]
		);
	}

	/**
	 * Test insert
	 */
	public function testInsert()
	{
		$transaction = new Transaction;

		$entity = $this->hydrator->insert(
			$transaction,
			[
				'card_id' => 1,
				'amount' => 5,
				'status' => 'new',
				'token' => 'foobar',
				'created_at' => '2015-07-14 14:58:22',
				'updated_at' => '2015-07-14 14:58:22',
			]
		);

		$this->assertEquals($entity->getId(), null);
		$this->assertEquals($entity->getCardId(), 1);
		$this->assertEquals($entity->getAmount(), 5);
		$this->assertEquals($entity->getStatus(), 'new');
		$this->assertEquals($entity->getToken(), 'foobar');
		$this->assertEquals($entity->getCreatedAt(), '2015-07-14 14:58:22');
		$this->assertEquals($entity->getUpdatedAt(), '2015-07-14 14:58:22');
	}

	/**
	* Test hydrate
	*/
	public function testHydrate()
	{
		$transaction = new Transaction;
		$request = $this->prophet->prophesize('Illuminate\Http\Request');
		$request->get('card_id')->willReturn(null);
		$request->get('amount')->willReturn(5);
		$request->get('status')->willReturn(null);
		$request->get('token')->willReturn(null);
		$request->get('created_at')->willReturn(null);
		$request->get('updated_at')->willReturn(null);

		$entity = $this->hydrator->hydrate($transaction, $request->reveal());

		$this->assertEquals($entity->getId(), null);
		$this->assertEquals($entity->getCardId(), null);
		$this->assertEquals($entity->getAmount(), 5);
		$this->assertEquals($entity->getStatus(), null);
		$this->assertEquals($entity->getToken(), null);
		$this->assertEquals($entity->getCreatedAt(), null);
		$this->assertEquals($entity->getUpdatedAt(), null);

	}
}
