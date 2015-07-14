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
	protected $model;
	protected $hydrator;
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

	public function getById($id)
	{
		$model = $this->model;
		$result = $model::find($id);

		return $result
			? $this->hydrator->insert($this->entity, $result->toArray())
			: false;
	}

	public function getBy(array $criterias)
	{
		$model = $this->model;

		foreach ($criterias as $criteria => $value) {
			$model->where($criteria, '=', $value);
		}

		$result = $model->get();

		if (!$result) {
			return false;
		}

		$results = [];
		foreach ($resultSet as $result) {
			$results[] = $this->hydrator->insert($this->entity, $result->toArray());
		}

		return $results;
	}

	public function getAll()
	{
		$model = $this->model;
		$resultSet = $model::all();

		if (!$resultSet) {
			return false;
		}

		$results = [];
		foreach ($resultSet as $result) {
			$results[] = $this->hydrator->insert($this->entity, $result->toArray());
		}

		return $results;
	}

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

	protected function hasIdentity(AbstractEntity $entity)
	{
		return !empty($entity->getId());
	}
}
