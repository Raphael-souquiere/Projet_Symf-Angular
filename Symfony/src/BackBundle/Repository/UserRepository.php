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
    public function findOne($id)
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT p FROM BackBundle:User p WHERE p.id = :id'
            )->setParameter("id", $id)
            ->getOneOrNullResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }

    public function findByRecherche($recherche)
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT p FROM BackBundle:User p WHERE p.nom LIKE :recherche'
            )->setParameter("recherche", $recherche)
            ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }

    public function findUserActif()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT COUNT(p) FROM BackBundle:User p WHERE p.actif = 1'
            )->getSingleScalarResult();
    }

}
