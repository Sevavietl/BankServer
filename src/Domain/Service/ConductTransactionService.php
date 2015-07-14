<?php

namespace BankServer\Domain\Service;

use BankServer\Domain\Contract\HttpBankServerInterface;
use BankServer\Domain\Repository\TransactionRepositoryInterface;
use BankServer\Domain\Repository\UserRepositoryInterface;
use BankServer\Domain\Repository\CardRepositoryInterface;
use BankServer\Domain\Entity\Transaction;
use BankServer\Domain\Entity\User;
use BankServer\Domain\Entity\Card;

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

		if (!empty($card)) {
			$card = $card[0];
			$user = $this->userRepository->getBy([
				'id' => $card->getUserId(),
				'first_name' => $firstName,
				'last_name' => $lastName,
			]);

			if (!empty($user)) {
				$user = $user[0];
				$token = str_random(10);
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

	public function bill($token, $amount)
	{
		$transaction = $this->transactionRepository->getBy([
			'token' => $token,
		]);


		if (! $transaction) {
			$this->setLastError('Transaction Token Error');

			return false;
		}

		$card = $this->cardRepository->getById($transaction->getCardId());

		if ($card->getBalance() < $amount) {
			$this->setLastError('Not Enough Money');

			return false;
		}

		$transaction->setAmount($amount);
		$transaction->setStatus(Transaction::STATUS_COMPLETED);
		$this->transactionRepository->persist($transaction);

		$card->setBalance($card->getBalance() - $amount);
		$this->cardRepository->persist($card);

		return true;
	}

	protected function setToken($token)
	{
		$this->token = $token;

		return $this;
	}

	public function getToken()
	{
		return $this->token;
	}

	protected function setLastError($lastError)
	{
		$this->lastError = $lastError;

		return $this;
	}

	public function getLastError()
	{
		return $this->lastError;
	}
}
