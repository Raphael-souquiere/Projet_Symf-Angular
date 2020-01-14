<?php

namespace BackBundle\Repository;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    public function findAllOrderedByName()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT p FROM BackBundle:User p ORDER BY p.nom ASC'
            )
            ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }
}
