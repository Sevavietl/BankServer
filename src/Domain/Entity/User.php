<?php

namespace BankServer\Domain\Entity;

class User extends AbstractEntity
{
	protected $firstName;
	protected $lastName;

	public function setFirstName($firstName)
	{
		$this->firstName = $firstName;
		return $this;
	}

	public function getFirstName()
	{
		return $this->firstName;
	}

	public function setLastName($lastName)
	{
		$this->lastName = $lastName;
		return $this;
	}

	public function getLastName()
	{
		return $this->lastName;
	}
}
