<?php

namespace BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use BackBundle\Entity\Site;

class SiteController extends Controller
{
  public function showallAction()
  {
      $em = $this->getDoctrine()->getManager();

      $sites = $em->getRepository(Site::class)->findAllOrderedByName();
      return $this->render('site/index.html.twig', array(
          'sites' => $sites,
      ));
  }
  public function showAction($id)
  {
      $em = $this->getDoctrine()->getManager();

      $site = $em->getRepository(Site::class)->findOne($id);
      return $this->render('site/show.html.twig', array(
          'site' => $site,
      ));
  }
}
