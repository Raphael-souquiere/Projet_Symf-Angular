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
    ->findAllCle();
    $response = new Response();
    $response->setContent(json_encode($cles));
    $response->headers->set('Content-Type', 'application/json');
    $response->headers->set('Access-Control-Allow-Origin', '*');
    return $response;

  }


  public function detailcleAction($id)
  {
    $cle = $this->getDoctrine()
    ->getRepository(Cle::class)
    ->findOne($id);

    $response = new Response();
    $response->setContent(json_encode($cle));;
    $response->headers->set('Content-Type', 'application/json');
    $response->headers->set('Access-Control-Allow-Origin', '*');
    return $response;
  }



  public function detailcleusersAction($id)
  {

    $users = $this->getDoctrine()
    ->getRepository(User::class)
    ->findUserByCle($id);


    $response = new Response();
    $response->setContent(json_encode($users));
    $response->headers->set('Content-Type', 'application/json');
    $response->headers->set('Access-Control-Allow-Origin', '*');
    return $response;
  }




  public function listeuserAction()
  {
    $users = $this->getDoctrine()
    ->getRepository(User::class)
    ->findAllOrderedByNameFront();
    $response = new Response();
    $response->setContent(json_encode($users));
    $response->headers->set('Content-Type', 'application/json');
    $response->headers->set('Access-Control-Allow-Origin', '*');
    return $response;
  }

  public function detailuserAction($id)
  {
    $user = $this->getDoctrine()
    ->getRepository(User::class)
    ->findOne($id);


    $response = new Response();
    $response->setContent(json_encode($user));
    $response->headers->set('Content-Type', 'application/json');
    $response->headers->set('Access-Control-Allow-Origin', '*');
    return $response;
  }
  public function detailuserclesAction($id)
  {

    $cles = $this->getDoctrine()
    ->getRepository(Cle::class)
    ->findCleByUser($id);


    $response = new Response();
    $response->setContent(json_encode($cles));
    $response->headers->set('Content-Type', 'application/json');
    $response->headers->set('Access-Control-Allow-Origin', '*');
    return $response;
  }
}
