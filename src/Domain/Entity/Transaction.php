<?php

namespace BankServer\Domain\Entity;

class Transaction extends AbstractEntity
{
	protected $cardId;
	protected $amount;
	protected $status;
	protected $token;

	const STATUS_NEW = 'new';
	const STATUS_PENDING = 'pending';
	const STATUS_COMPLETED = 'completed';
	const STATUS_FAILED = 'failed';
	const STATUS_REJECTED = 'rejected';

	public function setCardId($cardId)
	{
		$this->cardId = $cardId;
		return $this;
	}

	public function getCardId()
	{
		return $this->cardId;
	}

	public function setAmount($amount)
	{
		$this->amount = $amount;
		return $this;
	}

	public function getAmount()
	{
		return $this->amount;
	}

	public function setStatus($status)
	{
		$this->status = $status;
		return $this;
	}

	public function getStatus()
	{
		return $this->status;
	}

	public function setToken($token)
	{
		$this->token = $token;
		return $this;
	}

	public function getToken()
	{
		return $this->token;
	}
}
