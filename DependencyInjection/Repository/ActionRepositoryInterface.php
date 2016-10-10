<?php

namespace Sipsynergy\ActivityStreamBundle\Repository;

interface ActionRepositoryInterface
{
    public function findOneBy(array $criteria);

    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null);
}