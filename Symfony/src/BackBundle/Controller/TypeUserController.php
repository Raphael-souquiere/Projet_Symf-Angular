<?php

namespace BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use BackBundle\Entity\TypeUser;

class TypeUserController extends Controller
{
  public function showallAction()
  {
      $em = $this->getDoctrine()->getManager();
      $typeusers = $em->getRepository(TypeUser::class)->findAllOrderedByName();
      return $this->render('typeuser/index.html.twig', array(
          'typeusers' => $typeusers,
      ));
  }
}
