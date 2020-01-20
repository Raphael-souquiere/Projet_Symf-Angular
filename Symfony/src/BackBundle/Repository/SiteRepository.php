<?php

namespace BackBundle\Repository;

use Doctrine\ORM\EntityRepository;

class SiteRepository extends EntityRepository
{
    public function findAllOrderedByName()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT p FROM BackBundle:Site p ORDER BY p.id ASC'
            )
            ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }
    public function findOne($id)
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT p FROM BackBundle:Site p WHERE p.id = :id'
            )->setParameter("id", $id)
            ->getOneOrNullResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }
}
