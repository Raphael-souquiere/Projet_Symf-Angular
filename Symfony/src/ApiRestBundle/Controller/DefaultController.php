<?php

namespace ApiRestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use BackBundle\Entity\User;
use BackBundle\Entity\Cle;
use BackBundle\Entity\Affecte;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ApiRestBundle:Default:index.html.twig');
    }


    public function listecleAction()
    {
      $cles = $this->getDoctrine()
          ->getRepository(Cle::class)
          ->findAllOrderedByName();
          $response = new Response();

            $response->setContent(json_encode($cles));
            $response->headers->set('Content-Type', 'application/json');
            $response->headers->set('Access-Control-Allow-Origin', '*');
          return $response;

    }


    public function detailcleAction($id)
    {
      $cle = $this->getDoctrine()
          ->getRepository(Affecte::class)
          ->findAffecteByCle($id);


      return new JsonResponse([$cle]);
    }


    public function listeutilisateurAction()
    {
      $users = $this->getDoctrine()
          ->getRepository(User::class)
          ->findAllOrderedByName();
      return new JsonResponse([$users]);
    }

    public function detailutilisateurAction()
    {
        return $this->render('ApiRestBundle:Default:index.html.twig');
    }
}
