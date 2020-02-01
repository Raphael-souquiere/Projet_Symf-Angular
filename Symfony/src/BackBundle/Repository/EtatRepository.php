<?php

namespace BackBundle\Repository;

use Doctrine\ORM\EntityRepository;

class EtatRepository extends EntityRepository
{

  //Récupère tous les états

  public function findAllOrderedByName()
  {
    return $this->getEntityManager()
    ->createQuery(
      'SELECT p FROM BackBundle:Etat p ORDER BY p.id ASC'
      )
      ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }

    //Récupère un etat

    public function findOne($id)
    {
      return $this->getEntityManager()
      ->createQuery(
        'SELECT p FROM BackBundle:Etat p WHERE p.id = :id'
        )->setParameter("id", $id)
        ->getOneOrNullResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
      }
    }
