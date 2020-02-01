<?php

namespace BackBundle\Repository;

use Doctrine\ORM\EntityRepository;

class AffecteRepository extends EntityRepository
{

  //recupère les affectations de la clé d'id $id

  public function findAffecteByCle($id)
  {
    return $this->getEntityManager()
    ->createQuery(
      'SELECT p FROM BackBundle:Affecte p WHERE p.idCle = :id'
      )
      ->setParameter("id", $id)
      ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }

    //recupère toute les affectations

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

      //récupère l'affectation d'id $id

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

        //récupère l'affectation d'id $id pour le backoffice

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
