<?php

namespace BankServer\Persistence\Laravel\Hydrator;

use BankServer\Domain\Entity\AbstractEntity;
use Illuminate\Http\Request;

interface HydratorInterface
{
	public function extract(AbstractEntity $entity);
	public function insert(AbstractEntity $entity, $data);
	public function hydrate(AbstractEntity $entity, Request $request);
}
