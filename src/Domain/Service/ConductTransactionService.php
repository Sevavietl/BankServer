<?php

namespace BankServer\Domain\Service;

use BankServer\Domain\Repository\TransactionRepositoryInterface;
use BankServer\Domain\Repository\UserRepositoryInterface;
use BankServer\Domain\Repository\CardRepositoryInterface;
use BankServer\Domain\Entity\Transaction;

class ConductTransactionService
{
	protected $transactionRepository;
	protected $userRepository;
	protected $cardRepository;

	protected $token;
	protected $lastError;

	public function __construct(
		TransactionRepositoryInterface $transactionRepository,
		UserRepositoryInterface $userRepository,
		CardRepositoryInterface $cardRepository
	) {
		$this->transactionRepository = $transactionRepository;
		$this->userRepository = $userRepository;
		$this->cardRepository = $cardRepository;
	}

	/**
	 * Function to authenticate user by given first and last names
	 * and credit card number and expiration date.
	 * @param  string $firstName
	 * @param  string $lastName
	 * @param  string $cardNumber
	 * @param  string $cardExpiration
	 * @return boolean
	 */
	public function authenticate(
		$firstName,
		$lastName,
		$cardNumber,
		$cardExpiration
	) {
		$card = $this->cardRepository->getBy([
			'card_number' => $cardNumber,
			'card_expiration' => $cardExpiration,
		]);

		// If the card exist continue
		if (!empty($card)) {
			$card = $card[0];
			$user = $this->userRepository->getBy([
				'id' => $card->getUserId(),
				'first_name' => $firstName,
				'last_name' => $lastName,
			]);

			// If given user for this card exists continue
			if (!empty($user)) {
				$user = $user[0];
				$token = $this->generateToken(10);
				$this->setToken($token);

				$transaction = new Transaction;
				$transaction->setCardId($card->getId());
				$transaction->setStatus(Transaction::STATUS_NEW);
				$transaction->setToken($this->getToken());

				$this->transactionRepository->persist($transaction);

				return true;
			}

			$this->setLastError('User Verification Error');
			return false;
		}

		$this->setLastError('Card Verification Error');
		return false;
	}

	/**
	 * Withdraw money from the card
	 * @param  [type] $token  [description]
	 * @param  [type] $amount [description]
	 * @return [type]         [description]
	 */
	public function bill($token, $amount)
	{
		$transaction = $this->transactionRepository->getBy([
			'token' => $token,
		]);


		// Token mismatch
		if (! $transaction) {
			$this->setLastError('Transaction Token Error');

			return false;
		}

		$transaction = $transaction[0];

		$card = $this->cardRepository->getById($transaction->getCardId());

		// Not enough money on the account
		if ($card->getBalance() < $amount) {
			$this->setLastError('Not Enough Money');

			return false;
		}

		// Set transaction as completed
		$transaction->setAmount($amount);
		$transaction->setStatus(Transaction::STATUS_COMPLETED);
		$this->transactionRepository->persist($transaction);

		// Reduce card balance
		$card->setBalance($card->getBalance() - $amount);
		$this->cardRepository->persist($card);

		return true;
	}

	/**
	 * [setToken description]
	 * @param string $token [description]
	 */
	protected function setToken($token)
	{
		$this->token = $token;

		return $this;
	}

	/**
	 * [getToken description]
	 * @return string [description]
	 */
	public function getToken()
	{
		return $this->token;
	}

	/**
	 * [setLastError description]
	 * @param string $lastError [description]
	 */
	protected function setLastError($lastError)
	{
		$this->lastError = $lastError;

		return $this;
	}

	/**
	 * [getLastError description]
	 * @return string [description]
	 */
	public function getLastError()
	{
		return $this->lastError;
	}

	/**
	 * As token must be unique, we have to be sure it is)
	 * For the sake of this small project we will break from
	 * the generating loop after 10 tries.
	 * In the real life we have to handle this somehow.
	 * For example use bigger random string or bigger loop.
	 * @param  integer $size Size of the random string
	 * @return string       random string of the given size
	 */
	protected function generateToken($size)
	{
		for ($i = 0; $i <= 10; $i++) {
			$token = str_random($size);

			$transaction = $this->transactionRepository->getBy([
				'token' => $token,
			]);

			if (! $transaction) {
				return $token;
			}
		}

		return $token;
	}
}
