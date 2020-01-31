<?php

namespace BackBundle\Repository;

use Doctrine\ORM\EntityRepository;

class SearchRepository extends EntityRepository
{
    public function findAllOrderedByName($nom,$site,$typeUser)
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT p.id,p.nom,p.prenom,p.actif,t.typeUser,s.site FROM BackBundle:User p
                  INNER JOIN BackBundle:TypeUser t WHERE p.idTypeUser = t.id
                  INNER JOIN BackBundle:Affecte a WHERE a.idUser = p.id
                  INNER JOIN BackBundle:Cle c WHERE a.idCle = c.id
                  INNER JOIN BackBundle:Site s
                  WHERE true = true AND WHERE p.nom LIKE :nom% AND WHERE s.site LIKE :site% AND WHERE t.typeUser LIKE :typeUser%'
            )->setParameter("nom", $nom)
            ->setParameter("site", $site)
            ->setParameter("typeUser", $typeUser)
            ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }
}
