<?php

namespace BankServer\Domain\Entity;

abstract class AbstractEntity
{
	/**
	 * Identificator of the entity
	 * @var integer
	 */
	protected $id;
	/**
	 * [$createdAt description]
	 * @var timestamp
	 */
	protected $createdAt;
	/**
	 * [$updatedAt description]
	 * @var timestamp
	 */
	protected $updatedAt;

	/**
	 * [getId description]
	 * @return integer [description]
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * [setId description]
	 * @param integer $id [description]
	 */
	public function setId($id) {
		$this->id = $id;
		return $this;
	}

	/**
	 * [getCreatedAt description]
	 * @return timestamp [description]
	 */
	public function getCreatedAt()
	{
		return $this->createdAt;
	}

	/**
	 * [setCreatedAt description]
	 * @param timestamp $createdAt [description]
	 */
	public function setCreatedAt($createdAt) {
		$this->createdAt = $createdAt;
		return $this;
	}

	/**
	 * [getUpdatedAt description]
	 * @return timestamp [description]
	 */
	public function getUpdatedAt()
	{
		return $this->updatedAt;
	}

	/**
	 * [setUpdatedAt description]
	 * @param timestamp $updatedAt [description]
	 */
	public function setUpdatedAt($updatedAt) {
		$this->updatedAt = $updatedAt;
		return $this;
	}
}
