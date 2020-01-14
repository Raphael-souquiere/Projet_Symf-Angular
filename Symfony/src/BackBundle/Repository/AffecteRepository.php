<?php

namespace BackBundle\Repository;

use Doctrine\ORM\EntityRepository;

class AffecteRepository extends EntityRepository
{
    public function findAffecteByCle($id)
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT p FROM BackBundle:Affecte p WHERE p.idCle = :id'
            )
            ->setParameter("id", $id)
            ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }
}
