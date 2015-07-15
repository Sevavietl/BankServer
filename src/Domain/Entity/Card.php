<?php

namespace BankServer\Domain\Entity;

class Card extends AbstractEntity
{
	/**
	 * Card number (16 digits, 4 groups of 4 digits)
	 * @var string
	 */
	protected $cardNumber;
	/**
	 * Card expiration mm/yy
 	 * @var string
	 */
	protected $cardExpiration;
	/**
	 * Id of the user
	 * @var integer
	 */
	protected $userId;
	/**
	 * Card balance
	 * @var integer
	 */
	protected $balance;

	/**
	 * [setCardNumber description]
	 * @param string $cardNumber [description]
	 */
	public function setCardNumber($cardNumber)
	{
		$this->cardNumber = $cardNumber;
		return $this;
	}

	/**
	 * [getCardNumber description]
	 * @return string [description]
	 */
	public function getCardNumber()
	{
		return $this->cardNumber;
	}

	/**
	 * [setCardExpiration description]
	 * @param string $cardExpiration [description]
	 */
	public function setCardExpiration($cardExpiration)
	{
		$this->cardExpiration = $cardExpiration;
		return $this;
	}

	/**
	 * [getCardExpiration description]
	 * @return string [description]
	 */
	public function getCardExpiration()
	{
		return $this->cardExpiration;
	}

	/**
	 * [setUserId description]
	 * @param integer $userId [description]
	 */
	public function setUserId($userId)
	{
		$this->userId = $userId;
		return $this;
	}

	/**
	 * [getUserId description]
	 * @return integer [description]
	 */
	public function getUserId()
	{
		return $this->userId;
	}

	/**
	 * [setBalance description]
	 * @param integer $balance [description]
	 */
	public function setBalance($balance)
	{
		$this->balance = $balance;
		return $this;
	}

	/**
	 * [getBalance description]
	 * @return integer [description]
	 */
	public function getBalance()
	{
		return $this->balance;
	}
}
