<?php

namespace BankServer\Persistence\Laravel\Hydrator;

use BankServer\Persistence\Laravel\Hydrator\HydratorInterface;

use BankServer\Domain\Entity\AbstractEntity;
use Illuminate\Http\Request;

class SimpleHydrator implements HydratorInterface
{
	/**
	 * Extract data from entity to simple array, so we can give it to
	 * Eloquent Model
	 * @param  BankServer\Domain\Entity\AbstractEntity $entity
	 * @return array
	 */
	public function extract(AbstractEntity $entity)
	{
		$result = [];

		$reflection = new \ReflectionClass($entity);
		$properties = $reflection->getProperties(\ReflectionProperty::IS_PROTECTED);

		foreach ($properties as $property) {
			if (
				null != ($entity->{'get' . ucfirst($property->getName())}())
				&& 'id' != $property->getName()
			) {
		    	$result[snake_case($property->getName())] = $entity->{'get' . ucfirst($property->getName())}();
			}
		}

		return $result;
	}

	/**
	 * Populate entity with array data
	 * @param  BankServer\Domain\Entity\AbstractEntity $entity
	 * @param  array         $data
	 * @return BankServer\Domain\Entity\AbstractEntity
	 */
	public function insert(AbstractEntity $entity, $data)
	{
		$reflection = new \ReflectionClass($entity);

		foreach ($data as $property => $datum) {
			if ($reflection->hasProperty(camel_case($property))) {
				$entity->{'set' . ucfirst(camel_case($property))}($datum);
			}
		}

		return $entity;
	}

	/**
	 * Extract data from the request and populate entity with it
	 * @param  BankServer\Domain\Entity\AbstractEntity $entity
	 * @param  Illuminate\Http\Request        $request
	 * @return BankServer\Domain\Entity\AbstractEntity
	 */
	public function hydrate(AbstractEntity $entity, Request $request)
	{
		$reflection = new \ReflectionClass($entity);
		$properties = $reflection->getProperties(\ReflectionProperty::IS_PROTECTED);

		foreach ($properties as $property) {
			if ('id' != $property->getName()) {
		    	$entity->{'set' . ucfirst($property->getName())}($request->get(snake_case($property->getName())));
			}
		}

		return $entity;
	}
}
