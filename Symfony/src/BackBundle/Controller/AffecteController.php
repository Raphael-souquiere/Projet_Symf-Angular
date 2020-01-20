<?php

namespace BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use BackBundle\Entity\Affecte;

class AffecteController extends Controller
{
  public function showallAction()
  {
      $em = $this->getDoctrine()->getManager();

      $affectes = $em->getRepository(Affecte::class)->findAllOrderedByName();
      return $this->render('affecte/index.html.twig', array(
          'affectes' => $affectes,
      ));
  }
  public function showAction($id)
  {
      $em = $this->getDoctrine()->getManager();

      $affecte = $em->getRepository(Affecte::class)->findOne($id);
      return $this->render('affecte/show.html.twig', array(
          'affecte' => $affecte,
      ));
  }
}
