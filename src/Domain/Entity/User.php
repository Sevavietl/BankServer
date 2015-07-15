<?php

namespace BankServer\Domain\Entity;

class User extends AbstractEntity
{
	/**
	 * [$firstName description]
	 * @var string
	 */
	protected $firstName;
	/**
	 * [$lastName description]
	 * @var string
	 */
	protected $lastName;

	/**
	 * [setFirstName description]
	 * @param string $firstName [description]
	 */
	public function setFirstName($firstName)
	{
		$this->firstName = $firstName;
		return $this;
	}

	/**
	 * [getFirstName description]
	 * @return string [description]
	 */
	public function getFirstName()
	{
		return $this->firstName;
	}

	/**
	 * [setLastName description]
	 * @param string $lastName [description]
	 */
	public function setLastName($lastName)
	{
		$this->lastName = $lastName;
		return $this;
	}

	/**
	 * [getLastName description]
	 * @return string [description]
	 */
	public function getLastName()
	{
		return $this->lastName;
	}
}
