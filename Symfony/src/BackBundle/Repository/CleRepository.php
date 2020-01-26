<?php

namespace BackBundle\Repository;

use Doctrine\ORM\EntityRepository;

class CleRepository extends EntityRepository
{
    public function findAllOrderedByName()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT p.numCle,e.causeArret,p.montantInitial,p.id FROM BackBundle:Cle p INNER JOIN BackBundle:Etat e WHERE p.idEtat = e.id '
            )
            ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }
    public function findOne($id)
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT p.numCle,p.dateCreation,p.dateArret,p.commentaire,p.created,p.updated,e.causeArret,p.montantInitial,p.id FROM BackBundle:Cle p INNER JOIN BackBundle:Etat e WHERE p.id = :id AND p.idEtat = e.id '
            )->setParameter("id", $id)
            ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }

    public function findOneBack($id)
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT p.numCle,p.dateCreation,p.dateArret,p.commentaire,p.created,p.updated,e.causeArret,p.montantInitial,p.id FROM BackBundle:Cle p INNER JOIN BackBundle:Etat e WHERE p.id = :id AND p.idEtat = e.id '
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
