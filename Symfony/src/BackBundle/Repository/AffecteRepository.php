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
    public function findAllOrderedByName()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT p.id,p.dateAffectation,p.dateSuppression,c.numCle,u.nom,u.prenom FROM BackBundle:Affecte p
                 INNER JOIN   BackBundle:Cle c WHERE c.id = p.idCle
                 INNER JOIN   BackBundle:User u  WHERE u.id = p.idUser'
            )
            ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }

    public function findOne($id)
    {
        return $this->getEntityManager()
            ->createQuery(
              'SELECT p.id, p.dateAffectation,p.dateSuppression,c.numCle,u.nom,u.prenom FROM BackBundle:Affecte p
               INNER JOIN   BackBundle:Cle c WHERE c.id = p.idCle
               INNER JOIN   BackBundle:User u  WHERE u.id = p.idUser AND p.id = :id'
            )->setParameter("id", $id)
          ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
        }


    public function findOneBack($id)
    {
        return $this->getEntityManager()
            ->createQuery(
              'SELECT p.id, p.dateAffectation,p.dateSuppression, p.created, p.updated,c.numCle,u.nom,u.prenom FROM BackBundle:Affecte p
               INNER JOIN   BackBundle:Cle c WHERE c.id = p.idCle
               INNER JOIN   BackBundle:User u  WHERE u.id = p.idUser AND p.id = :id')
               ->setParameter("id", $id)
            ->getOneOrNullResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }
    }
