<?php

namespace BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use BackBundle\Entity\Cle;
use \Datetime;

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





    public function newAction(Request $request, Cle $cle = null)
    {
        $cle = new Cle();
        $form = $this->createForm('BackBundle\Form\CleType', $cle)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $datetime = new DateTime();
            $cle->setCreated($datetime);
            $cle->setUpdated($datetime);
            $em = $this->getDoctrine()->getManager();
            $em->persist($cle);
            $em->flush();

            return $this->redirectToRoute('cle_show', array('id' => $cle->getId()));
        }

        return $this->render('cle/new.html.twig', array('form' => $form->createView(),));
    }


    //Edition d'un utilisateur


    public function editAction(Request $request, Cle $cle)

      {
          $deleteForm = $this->createFormBuilder()->setAction($this->generateUrl('cle_delete', array('id' => $cle->getId())))->setMethod('DELETE')->getForm();

          $editForm = $this->createForm('BackBundle\Form\CleType', $cle)->handleRequest($request);

          if ($editForm->isSubmitted() && $editForm->isValid()) {
              $datetime = new DateTime();
              $cle->setUpdated($datetime);
              $this->getDoctrine()->getManager()->flush();

              return $this->redirectToRoute('cle_show', array('id' => $cle->getId()));
          }

          return $this->render('cle/edit.html.twig', array(
              'cle' => $cle,
              'edit_form' => $editForm->createView(),
              'delete_form' => $deleteForm->createView(),
          ));
      }


      //Suppresion d'un utilisateur


      public function deleteAction(Request $request, Cle $cle)
      {
          $form = $this->createFormBuilder()
              ->setAction($this->generateUrl('cle_delete', array('id' => $cle->getId())))->setMethod('DELETE')->getForm()->handleRequest($request);

          if ($form->isSubmitted() && $form->isValid()) {

              $em = $this->getDoctrine()->getManager();
              $em->remove($cle);
              $em->flush();
          }

          return $this->redirectToRoute('cle_index');
      }
}
