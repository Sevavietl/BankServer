<?php

namespace BankServer\Persistence\Laravel\Hydrator;

use BankServer\Persistence\Laravel\Hydrator\HydratorInterface;

use BankServer\Domain\Entity\AbstractEntity;
use Illuminate\Http\Request;

class SimpleHydrator implements HydratorInterface
{
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
