<?php

namespace BackBundle\Repository;

use Doctrine\ORM\EntityRepository;
use DoctrineExtensions\Query\Mysql\Month;
use DoctrineExtensions\Query\Mysql\Year;
use DoctrineExtensions\Query\Mysql\IfNull;

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

    public function findCleByUser($id)
    {
        return $this->getEntityManager()
            ->createQuery('SELECT c.id,c.numCle,c.montantInitial,c.commentaire,e.causeArret,c.dateArret,c.dateCreation,a.dateAffectation,a.dateSuppression
            FROM BackBundle:Cle c
            INNER JOIN BackBundle:Affecte a WHERE a.idCle = c.id
            INNER JOIN BackBundle:User p WHERE a.idUser = p.id  AND p.id = :id
            INNER JOIN BackBundle:Etat e WHERE c.idEtat = e.id
            INNER JOIN BackBundle:TypeUser t WHERE p.idTypeUser = t.id
            INNER JOIN BackBundle:Site s WHERE p.idSite = s.id')
              ->setParameter("id", $id)
            ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }


    //stat


        public function findCleActif()
        {
            return $this->getEntityManager()
                ->createQuery(
                    'SELECT COUNT(p) FROM BackBundle:Cle p
                    INNER JOIN BackBundle:Etat e
                    WHERE p.idEtat = e.id AND e.causeArret = :Actif')
                    ->setParameter("Actif", "Activé")
                ->getSingleScalarResult();
        }

        public function findCleInactif()
        {
          return $this->getEntityManager()
              ->createQuery(
                  'SELECT COUNT(p) FROM BackBundle:Cle p
                  INNER JOIN BackBundle:Etat e
                  WHERE p.idEtat = e.id AND e.causeArret != :Actif')
                  ->setParameter("Actif", "Activé")
              ->getSingleScalarResult();
        }

        public function findCleTotal()
        {
            return $this->getEntityManager()
                ->createQuery(
                    'SELECT COUNT(p) FROM BackBundle:Cle p'
                )->getSingleScalarResult();
        }




        public function findCleByType()
        {
            return $this->getEntityManager()
                ->createQuery(
                    'SELECT t.typeUser ,COUNT(c.id) AS nb
                    FROM BackBundle:Cle c
                    INNER JOIN BackBundle:Affecte a WHERE a.idCle = c.id
                    INNER JOIN BackBundle:User p WHERE a.idUser = p.id
                    INNER JOIN BackBundle:TypeUser t WHERE p.idTypeUser = t.id
                    GROUP BY t.typeUser')
                ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
        }

        public function findCleBySite()
        {
            return $this->getEntityManager()
                ->createQuery(
                    'SELECT IFNULL(COUNT(c), 0) AS nb ,s.site FROM BackBundle:Cle c
                    INNER JOIN BackBundle:Affecte a WHERE a.idCle = c.id
                    INNER JOIN BackBundle:User p WHERE a.idUser = p.id
                    INNER JOIN BackBundle:Site s WHERE p.idSite = s.id
                    GROUP BY s.site ')
                ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
        }

        public function evolutionmensuelcle()
        {
            return $this->getEntityManager()
                ->createQuery(
                      'SELECT MONTH(c.created) as da,
                              YEAR(c.created) as ye,
                                   COUNT(c) as nb
                      FROM BackBundle:Cle c
                      GROUP BY da,ye
                      ORDER BY YEAR(c.created),MONTH(c.created) ASC')
                ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
        }

        /*public function findCleInactif()
        {
          return $this->getEntityManager()
              ->createQuery(
                  'SELECT COUNT(p) FROM BackBundle:Cle p
                  INNER JOIN BackBundle:Etat e
                  WHERE p.idEtat = e.id AND e.causeArret != :Actif')
                  ->setParameter("Actif", "Activé")
              ->getSingleScalarResult();
        }*/
}
