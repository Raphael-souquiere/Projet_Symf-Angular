<?php

namespace BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function statAction()
    {
      $cle = $this->getDoctrine()
          ->getRepository(Cle::class)
          ->findOne($id);

          $response = new Response();
          $response->setContent(json_encode($cle + $affectes));
          $response->headers->set('Content-Type', 'application/json');
          $response->headers->set('Access-Control-Allow-Origin', '*');
          return $response;
    }
