<?php

namespace BackBundle\Repository;

use Doctrine\ORM\EntityRepository;

class TypeUserRepository extends EntityRepository
{

  //récupère tous les type d'utilisateur

  public function findAllOrderedByName()
  {
    return $this->getEntityManager()
    ->createQuery(
      'SELECT p FROM BackBundle:TypeUser p ORDER BY p.id ASC'
      )
      ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }

    //Récupère un type d'utilisateur

    public function findOne($id)
    {
      return $this->getEntityManager()
      ->createQuery(
        'SELECT p FROM BackBundle:TypeUser p WHERE p.id = :id'
        )->setParameter("id", $id)
        ->getOneOrNullResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
      }
    }
