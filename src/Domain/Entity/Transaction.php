<?php

namespace BankServer\Domain\Entity;

class Transaction extends AbstractEntity
{
	/**
	 * Card id
	 * @var integer
	 */
	protected $cardId;
	/**
	 * Amount of withdrawal
	 * @var integer
	 */
	protected $amount;
	/**
	 * Transaction status
	 * @var string
	 */
	protected $status;
	/**
	 * Random token
	 * @var string
	 */
	protected $token;

	const STATUS_NEW = 'new';
	const STATUS_PENDING = 'pending';
	const STATUS_COMPLETED = 'completed';
	const STATUS_FAILED = 'failed';
	const STATUS_REJECTED = 'rejected';

	/**
	 * [setCardId description]
	 * @param integer $cardId [description]
	 */
	public function setCardId($cardId)
	{
		$this->cardId = $cardId;
		return $this;
	}

	/**
	 * [getCardId description]
	 * @return integer [description]
	 */
	public function getCardId()
	{
		return $this->cardId;
	}

	/**
	 * [setAmount description]
	 * @param integer $amount [description]
	 */
	public function setAmount($amount)
	{
		$this->amount = $amount;
		return $this;
	}

	/**
	 * [getAmount description]
	 * @return integer [description]
	 */
	public function getAmount()
	{
		return $this->amount;
	}

	/**
	 * [setStatus description]
	 * @param string $status [description]
	 */
	public function setStatus($status)
	{
		$this->status = $status;
		return $this;
	}

	/**
	 * [getStatus description]
	 * @return string [description]
	 */
	public function getStatus()
	{
		return $this->status;
	}

	/**
	 * [setToken description]
	 * @param string $token [description]
	 */
	public function setToken($token)
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
}
