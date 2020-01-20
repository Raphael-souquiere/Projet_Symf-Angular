<?php

namespace BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use BackBundle\Entity\Etat;

class EtatController extends Controller
{
  public function showallAction()
  {
      $em = $this->getDoctrine()->getManager();

      $etats = $em->getRepository(Etat::class)->findAllOrderedByName();
      return $this->render('etat/index.html.twig', array(
          'etats' => $etats,
      ));
  }
}