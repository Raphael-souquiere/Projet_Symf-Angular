<?php

namespace BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use BackBundle\Entity\User;
use BackBundle\Entity\Cle;
use BackBundle\Entity\TypeUser;
use \Datetime;

class StatistiqueController extends Controller


{


  //Liste de tout les utilisateur


  public function statAction()
  {
      $em = $this->getDoctrine()->getManager();
        $nbuseractif = $em->getRepository(User::class)->findUserActif();
        $nbuserinactif = $em->getRepository(User::class)->findUserInactif();
        $nbuser = $em->getRepository(User::class)->findUserTotal();

        $nbcleactif = $em->getRepository(Cle::class)->findCleActif();
        $nbcleinactif = $em->getRepository(Cle::class)->findCleInactif();
        $nbcle = $em->getRepository(Cle::class)->findCleTotal();

        $nbclebysites = $em->getRepository(Cle::class)->findCleBySite();
        $nbclebytypes = $em->getRepository(Cle::class)->findCleByType();

        $clemensuels = $em->getRepository(Cle::class)->evolutionmensuelcle();
        $usermensuels = $em->getRepository(User::class)->evolutionmensueluser();

        return $this->render('stat.html.twig', array(
            'nbuseractif' => $nbuseractif,
            'nbuserinactif' => $nbuserinactif,
            'nbuser' => $nbuser,
            'nbcleactif' => $nbcleactif,
            'nbcleinactif' => $nbcleinactif,
            'nbcle' => $nbcle,
            'nbclebytypes' => $nbclebytypes,
            'nbclebysites' => $nbclebysites,
            'clemensuels' => $clemensuels,
            'usermensuels' => $usermensuels,
        ));
  }

  //detail d'un utilisateur

}
