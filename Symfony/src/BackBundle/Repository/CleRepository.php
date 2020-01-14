<?php

namespace BackBundle\Repository;

use Doctrine\ORM\EntityRepository;

class CleRepository extends EntityRepository
{
    public function findAllOrderedByName()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT p FROM BackBundle:Cle p ORDER BY p.id ASC'
            )
            ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }
}
