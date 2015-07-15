<?php

namespace BankServer\Persistence\Laravel\Repository;

use BankServer\Domain\Entity\AbstractEntity;
use BankServer\Domain\Repository\RepositoryInterface;
use BankServer\Persistence\Laravel\Hydrator\HydratorInterface;

use Illuminate\Database\Eloquent\Model;

use DB;

abstract class AbstractRepository
implements RepositoryInterface
{
	/**
	 * [$model description]
	 * @var Illuminate\Database\Eloquent\Model
	 */
	protected $model;
	/**
	 * [$hydrator description]
	 * @var BankServer\Persistence\Laravel\Hydrator\HydratorInterface
	 */
	protected $hydrator;
	/**
	 * [$entity description]
	 * @var BankServer\Domain\Entity\AbstractEntity
	 */
	protected $entity;

	public function __construct(
		Model $model,
		HydratorInterface $hydrator,
		AbstractEntity $entity
	) {
		$this->model = $model;
		$this->hydrator = $hydrator;
		$this->entity = $entity;
	}

	/**
	 * Get entity by id
	 * @param  integer $id
	 * @return BankServer\Domain\Entity\AbstractEntity
	 */
	public function getById($id)
	{
		$model = $this->model;
		$result = $model::find($id);

		return $result
			? $this->hydrator->insert($this->entity, $result->toArray())
			: false;
	}

	/**
	 * Get by criterias
	 * @param  array  $criterias
	 * @return array
	 */
	public function getBy(array $criterias)
	{
		$model = $this->model;

		foreach ($criterias as $criteria => $value) {
			$model = $model->where($criteria, '=', $value);
		}

		$resultSet = $model->get();

		if (!$resultSet) {
			return false;
		}

		$results = [];
		foreach ($resultSet as $result) {
			$results[] = $this->hydrator->insert(clone $this->entity, $result->toArray());
		}

		return $results;
	}

	/**
	 * Get all entities
	 * @return array
	 */
	public function getAll()
	{
		$model = $this->model;
		$resultSet = $model::all();

		if (!$resultSet) {
			return false;
		}

		$results = [];
		foreach ($resultSet as $result) {
			$results[] = $this->hydrator->insert(clone $this->entity, $result->toArray());
		}

		return $results;
	}

	/**
	 * Store or update entity
	 * @param  BankServer\Domain\Entity\AbstractEntity $entity
	 * @return BankServer\Domain\Entity\AbstractEntity
	 */
	public function persist(AbstractEntity $entity)
	{
		$data = $this->hydrator->extract($entity);
		$model = $this->model;

		if ($this->hasIdentity($entity)) {
			$model = $model::find($entity->getId());

			foreach ($data as $property => $datum) {
				if ($property != 'id') {
					$model->{$property} = $datum;
				}
			}

			$model->save();
		} else {
			$model = $model::create($data);
		}

		$entity = $this->hydrator->insert($entity, $model->toArray());

		return $entity;
	}

	public function begin() {
		DB::beginTransaction();

		return $this;
	}

	public function commit() {
		DB::commit();

		return $this;
	}

	/**
	 * If entity exists in the table
	 * @param  BankServer\Domain\Entity\AbstractEntity $entity
	 * @return boolean
	 */
	protected function hasIdentity(AbstractEntity $entity)
	{
		return !empty($entity->getId());
	}
}
