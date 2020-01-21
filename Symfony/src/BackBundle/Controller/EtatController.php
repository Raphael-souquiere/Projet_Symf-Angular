<?php

namespace BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use BackBundle\Entity\Etat;

class EtatController extends Controller
{
  public function showallAction()
  {
      $em = $this->getDoctrine()->getManager();

      $etats = $em->getRepository(Etat::class)->findAllOrderedByName();
      return $this->render('etat/index.html.twig', array(
          'etats' => $etats,
      ));
  }
  public function showAction($id)
  {
      $em = $this->getDoctrine()->getManager();

      $etat = $em->getRepository(Etat::class)->findOne($id);
      return $this->render('etat/show.html.twig', array(
          'etat' => $etat,
      ));
  }
  public function newAction(Request $request, Etat $etat = null)
  {
      $etat = new Etat();
      $form = $this->createForm('BackBundle\Form\EtatType', $etat);
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
          $em = $this->getDoctrine()->getManager();
          $em->persist($etat);
          $em->flush();

          return $this->redirectToRoute('etat_show', array('id' => $etat->getId()));
      }

      return $this->render('etat/new.html.twig', array('form' => $form->createView(),));
  }


  //Edition d'un utilisateur


  public function editAction(Request $request, Etat $etat)

    {
        $deleteForm = $this->createFormBuilder()->setAction($this->generateUrl('etat_delete', array('id' => $etat->getId())))->setMethod('DELETE')->getForm();

        $editForm = $this->createForm('BackBundle\Form\EtatType', $etat)->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('etat_show', array('id' => $etat->getId()));
        }

        return $this->render('etat/edit.html.twig', array(
            'etat' => $etat,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }


    //Suppresion d'un utilisateur


    public function deleteAction(Request $request, Etat $etat)
    {
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('etat_delete', array('id' => $etat->getId())))->setMethod('DELETE')->getForm()->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->remove($etat);
            $em->flush();
        }

        return $this->redirectToRoute('etat_index');
    }

}
