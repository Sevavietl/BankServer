<?php

use BankServer\Domain\Service\ConductTransactionService;

use BankServer\Domain\Entity\Transaction;

use Prophecy\Prophet;
use Prophecy\Argument;

class ConductTransactionServiceTest extends PHPUnit_Framework_TestCase
{
	private $prophet;

	protected $transactionRepository;
	protected $userRepository;
	protected $cardRepository;

	protected $transaction;
	protected $user;
	protected $card;

	public function setUp()
    {
		$this->prophet = new Prophet;

		$this->transactionRepository = $this->prophet
			->prophesize('BankServer\Domain\Repository\TransactionRepositoryInterface');
		$this->userRepository = $this->prophet
			->prophesize('BankServer\Domain\Repository\UserRepositoryInterface');
		$this->cardRepository = $this->prophet
			->prophesize('BankServer\Domain\Repository\CardRepositoryInterface');

		$this->transaction = $this->prophet
			->prophesize('BankServer\Domain\Entity\Transaction');
		$this->user = $this->prophet
			->prophesize('BankServer\Domain\Entity\User');
		$this->card = $this->prophet
			->prophesize('BankServer\Domain\Entity\Card');
    }

	public function tearDown()
    {
		$this->prophet->checkPredictions();
    }

	/**
	 * Transaction not authenticated due to card verification error
	 */
	public function testNotAuthenticatedCardError()
	{
		$firstName = 'John';
		$lastName = 'Dow';
		$cardNumber = '1234 1234 1234 1234';
		$cardExpiration = '07/16';

		$error = 'Card Verification Error';

		$this->cardRepository->getBy([
			'card_number' => $cardNumber,
			'card_expiration' => $cardExpiration,
		])->willReturn([]);

		$conductTransactionService = new ConductTransactionService(
			$this->transactionRepository->reveal(),
			$this->userRepository->reveal(),
			$this->cardRepository->reveal()
		);

		$this->assertFalse($conductTransactionService->authenticate(
			$firstName,
			$lastName,
			$cardNumber,
			$cardExpiration
		));
		$this->assertEquals($conductTransactionService->getLastError(), $error);
	}

	/**
	 * Transaction not authenticated due to user verification error
	 */
	public function testNotAuthenticatedUserError()
	{
		$firstName = 'John';
		$lastName = 'Dow';
		$cardNumber = '1234 1234 1234 1234';
		$cardExpiration = '07/16';

		$userId = 1;

		$error = 'User Verification Error';

		$this->card->getUserId()->willReturn($userId);

		$this->cardRepository->getBy([
			'card_number' => $cardNumber,
			'card_expiration' => $cardExpiration,
		])->willReturn([
			0 => $this->card->reveal(),
		]);

		$this->userRepository->getBy([
			'id' => $userId,
			'first_name' => $firstName,
			'last_name' => $lastName,
		])->willReturn([]);

		$conductTransactionService = new ConductTransactionService(
			$this->transactionRepository->reveal(),
			$this->userRepository->reveal(),
			$this->cardRepository->reveal()
		);

		$this->assertFalse($conductTransactionService->authenticate(
			$firstName,
			$lastName,
			$cardNumber,
			$cardExpiration
		));
		$this->assertEquals($conductTransactionService->getLastError(), $error);
	}

	/**
	 * Transaction authenticated
	 */
	public function testAuthenticated()
	{
		$firstName = 'John';
		$lastName = 'Dow';
		$cardNumber = '1234 1234 1234 1234';
		$cardExpiration = '07/16';

		$userId = 1;

		$this->card->getUserId()->willReturn($userId);

		$this->cardRepository->getBy([
			'card_number' => $cardNumber,
			'card_expiration' => $cardExpiration,
		])->willReturn([
			0 => $this->card->reveal(),
		]);

		$this->card->getId()->willReturn(1);

		$this->userRepository->getBy([
			'id' => $userId,
			'first_name' => $firstName,
			'last_name' => $lastName,
		])->willReturn([
			0 => $this->user->reveal(),
		]);

		$this->transactionRepository->getBy(Argument::any())->willReturn([]);
		$this->transactionRepository->persist(Argument::any())->shouldBeCalled();

		$conductTransactionService = new ConductTransactionService(
			$this->transactionRepository->reveal(),
			$this->userRepository->reveal(),
			$this->cardRepository->reveal()
		);

		$this->assertTrue($conductTransactionService->authenticate(
			$firstName,
			$lastName,
			$cardNumber,
			$cardExpiration
		));
	}

	/**
	 * Transaction not billed due to token error
	 */
	public function testNotBilledTokenError()
	{
		$token = 'foobar';
		$amount = 5;

		$error = 'Transaction Token Error';

		$this->transactionRepository->getBy([
			'token' => $token,
		])->willReturn([]);

		$conductTransactionService = new ConductTransactionService(
			$this->transactionRepository->reveal(),
			$this->userRepository->reveal(),
			$this->cardRepository->reveal()
		);

		$this->assertFalse($conductTransactionService->bill($token, $amount));
		$this->assertEquals($conductTransactionService->getLastError(), $error);
	}

	/**
	 * Transaction not billed due to amount error
	 */
	public function testNotBilledAmountError()
	{
		$token = 'foobar';
		$amount = 5;

		$cardId = 1;

		$balance = 3;

		$error = 'Not Enough Money';

		$this->transaction->getCardId()->willReturn($cardId);

		$this->transactionRepository->getBy([
			'token' => $token,
		])->willReturn([
			0 => $this->transaction->reveal(),
		]);

		$this->card->getBalance()->willReturn($balance);

		$this->cardRepository->getById($cardId)->willReturn($this->card->reveal());

		$conductTransactionService = new ConductTransactionService(
			$this->transactionRepository->reveal(),
			$this->userRepository->reveal(),
			$this->cardRepository->reveal()
		);

		$this->assertFalse($conductTransactionService->bill($token, $amount));
		$this->assertEquals($conductTransactionService->getLastError(), $error);
	}

	/**
	* Transaction billed
	*/
	public function testBilled()
	{
		$token = 'foobar';
		$amount = 5;

		$cardId = 1;

		$balance = 7;

		$this->transaction->getCardId()->willReturn($cardId);
		$this->transaction->setAmount($amount)->shouldBeCalled();
		$this->transaction->setStatus(Transaction::STATUS_COMPLETED)->shouldBeCalled();

		$this->transactionRepository->getBy([
			'token' => $token,
		])->willReturn([
			0 => $this->transaction->reveal(),
		]);

		$this->card->getBalance()->willReturn($balance);
		$this->card->setBalance($balance - $amount)->shouldBeCalled();

		$this->cardRepository->getById($cardId)->willReturn($this->card->reveal());

		$this->transactionRepository->persist(Argument::any())->shouldBeCalled();
		$this->cardRepository->persist(Argument::any())->shouldBeCalled();

		$conductTransactionService = new ConductTransactionService(
			$this->transactionRepository->reveal(),
			$this->userRepository->reveal(),
			$this->cardRepository->reveal()
		);

		$this->assertTrue($conductTransactionService->bill($token, $amount));
	}
}
