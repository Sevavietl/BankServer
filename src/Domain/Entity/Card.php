<?php

namespace BankServer\Domain\Entity;

class Card extends AbstractEntity
{
	protected $cardNumber;
	protected $cardExpiration;
	protected $userId;
	protected $balance;

	public function setCardNumber($cardNumber)
	{
		$this->cardNumber = $cardNumber;
		return $this;
	}

	public function getCardNumber()
	{
		return $this->cardNumber;
	}

	public function setCardExpiration($cardExpiration)
	{
		$this->cardExpiration = $cardExpiration;
		return $this;
	}

	public function getCardExpiration()
	{
		return $this->cardExpiration;
	}

	public function setUserId($userId)
	{
		$this->userId = $userId;
		return $this;
	}

	public function getUserId()
	{
		return $this->userId;
	}

	public function setBalance($balance)
	{
		$this->balance = $balance;
		return $this;
	}

	public function getBalance()
	{
		return $this->balance;
	}
}
