<?php

namespace BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use BackBundle\Entity\Affecte;
use \Datetime;

class AffecteController extends Controller
{
  public function showallAction()
  {
      $em = $this->getDoctrine()->getManager();

      $affectes = $em->getRepository(Affecte::class)->findAllOrderedByName();
      return $this->render('affecte/index.html.twig', array(
          'affectes' => $affectes,
      ));
  }


  public function showAction( $id )
  {
      $em = $this->getDoctrine()->getManager();

      $affecte = $em->getRepository(Affecte::class)->findOneBack($id);

      return $this->render('affecte/show.html.twig', array(
            'affecte' => $affecte,
      ));
  }

  public function newAction(Request $request, Affecte $affecte = null)
  {
      $affecte = new Affecte();
      $form = $this->createForm('BackBundle\Form\AffecteType', $affecte);
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
        $datetime = new DateTime();
        $affecte->setCreated($datetime);
        $affecte->setUpdated($datetime);
          $em = $this->getDoctrine()->getManager();
          $em->persist($affecte);
          $em->flush();

          return $this->redirectToRoute('affecte_show', array('id' => $affecte->getId()));
      }

      return $this->render('affecte/new.html.twig', array('form' => $form->createView(),));
  }


  //Edition d'un utilisateur


  public function editAction(Request $request, Affecte $affecte)

    {
        $deleteForm = $this->createFormBuilder()->setAction($this->generateUrl('affecte_delete', array('id' => $affecte->getId())))->setMethod('DELETE')->getForm();

        $editForm = $this->createForm('BackBundle\Form\AffecteType', $affecte)->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
          $datetime = new DateTime();
          $affecte->setUpdated($datetime);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('affecte_show', array('id' => $affecte->getId()));
        }

        return $this->render('affecte/edit.html.twig', array(
            'affecte' => $affecte,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }


    //Suppresion d'un utilisateur


    public function deleteAction(Request $request, Affecte $affecte)
    {
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('affecte_delete', array('id' => $affecte->getId())))->setMethod('DELETE')->getForm()->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->remove($affecte);
            $em->flush();
        }

        return $this->redirectToRoute('affecte_index');
    }
}
