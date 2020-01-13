<?php

namespace ApiRestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use BackBundle\Entity\User;


class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ApiRestBundle:Default:index.html.twig');
    }
    public function listecleAction()
    {
        return $this->render('ApiRestBundle:Default:index.html.twig');
    }
    public function detailcleAction()
    {
        return $this->render('ApiRestBundle:Default:index.html.twig');
    }


    public function listeutilisateurAction(Request $request)
    {
      $em= $this->getDoctrine()->getEntityManager();

      $users = $em->getRepository('BackBundle:User')->listeuser();

      return new JsonResponse([$users]);
    }


    public function detailutilisateurAction()
    {
        return $this->render('ApiRestBundle:Default:index.html.twig');
    }
}
