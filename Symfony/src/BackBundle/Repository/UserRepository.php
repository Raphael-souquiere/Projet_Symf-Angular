<?php

namespace BackBundle\Repository;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    public function findAllOrderedByName()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT p.id,p.nom,p.prenom,p.actif,t.typeUser,s.site FROM BackBundle:User p
                  INNER JOIN BackBundle:TypeUser t WHERE p.idSite = t.id
                  INNER JOIN BackBundle:Site s
                  WHERE p.idTypeUser = s.id'
            )
            ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }
    public function findOne($id)
    {
      {
          return $this->getEntityManager()
              ->createQuery(
                  'SELECT p.id,p.nom,p.prenom,p.actif,p.created,
                  p.updated,t.typeUser,s.site
                  FROM BackBundle:User p INNER JOIN BackBundle:TypeUser t WHERE p.idSite = t.id
                  INNER JOIN BackBundle:Site s
                  WHERE p.idTypeUser = s.id AND p.id = :id'
              )->setParameter("id", $id)
              ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
      }
    }

    public function findOneBack($id)
    {
      {
          return $this->getEntityManager()
              ->createQuery(
                  'SELECT p.id,p.nom,p.prenom,p.actif,p.created,
                  p.updated,t.typeUser,s.site
                  FROM BackBundle:User p
                  INNER JOIN BackBundle:TypeUser t WHERE p.idSite = t.id
                  INNER JOIN BackBundle:Site s
                  WHERE p.idTypeUser = s.id AND p.id = :id'
              )->setParameter("id", $id)
              ->getOneOrNullResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
      }
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

    public function findUserByCle($id)
    {
        return $this->getEntityManager()
            ->createQuery('SELECT p.id,c.id,a.id,p.nom,p.prenom,p.actif,c.numCle,c.dateCreation,c.dateArret,e.causeArret
              ,a.dateAffectation , a.dateSuppression
            FROM BackBundle:User p
            INNER JOIN BackBundle:Affecte a WHERE a.idUser = p.id
            INNER JOIN BackBundle:Cle c WHERE a.idCle = c.id  AND c.id = :id
            INNER JOIN BackBundle:Etat e WHERE c.idEtat = e.id')
              ->setParameter("id", $id)
            ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }

}
