<?php

namespace BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use BackBundle\Entity\User;

class UserController extends Controller
{
  public function showallAction()
  {
      $em = $this->getDoctrine()->getManager();

      $users = $em->getRepository(User::class)->findAllOrderedByName();
      return $this->render('user/index.html.twig', array(
          'users' => $users,
      ));
  }
  public function showAction($id)
  {
      $em = $this->getDoctrine()->getManager();

      $user = $em->getRepository(User::class)->findOne($id);
      return $this->render('user/show.html.twig', array(
          'user' => $user,
      ));
  }
}
