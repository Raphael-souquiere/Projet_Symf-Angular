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
    public function findOne($id)
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT p FROM BackBundle:Cle p WHERE p.id = :id '
            )->setParameter("id", $id)
            ->getOneOrNullResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }

    public function findCleActif()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT COUNT(p) FROM BackBundle:Cle p WHERE p.idEtat = 1'
            )->getSingleScalarResult();
    }
}
