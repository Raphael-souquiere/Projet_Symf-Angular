<?php

namespace BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use BackBundle\Entity\Cle;

class CleController extends Controller
{
  public function showallAction()
  {
      $em = $this->getDoctrine()->getManager();

      $cles = $em->getRepository(Cle::class)->findAllOrderedByName();
      return $this->render('cle/index.html.twig', array(
          'cles' => $cles,
      ));
    }
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $cle = $em->getRepository(Cle::class)->findOne($id);
        return $this->render('cle/show.html.twig', array(
            'cle' => $cle,
        ));
    }
}
