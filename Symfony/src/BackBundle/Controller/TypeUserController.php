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
  public function showAction($id)
  {
      $em = $this->getDoctrine()->getManager();

      $typeuser = $em->getRepository(TypeUser::class)->findOne($id);
      return $this->render('typeuser/show.html.twig', array(
          'typeuser' => $typeuser,
      ));
  }
}
