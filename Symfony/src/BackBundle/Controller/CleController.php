<?php

namespace BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use BackBundle\Entity\Cle;
use \Datetime;

class CleController extends Controller
{

  //affichage de toutes les clé

  public function showallAction()
  {
    $em = $this->getDoctrine()->getManager();

    $cles = $em->getRepository(Cle::class)->findAllCle();
    return $this->render('cle/index.html.twig', array(
      'cles' => $cles,

    ));
  }

  //affichage d'une clé



  public function showAction($id)
  {
    $em = $this->getDoctrine()->getManager();

    $cle = $em->getRepository(Cle::class)->findOneBack($id);
    return $this->render('cle/show.html.twig', array(
      'cle' => $cle,
    ));
  }


  //Creation d'une clé


  public function newAction(Request $request, Cle $cle = null)
  {
    $cle = new Cle();
    $form = $this->createForm('BackBundle\Form\CleType', $cle)->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $datetime = new DateTime();
      $cle->setCreated($datetime);
      $cle->setUpdated($datetime);
      $cle->setDateCreation($datetime);
      $em = $this->getDoctrine()->getManager();
      $em->persist($cle);


      try{

        $em->flush();
      }catch (\Doctrine\DBAL\DBALException $e){
        return $this->render('error.html.twig', [
          "title" => "Une erreur est survenue lors de la suppression de l'entité",
          "message" => $e->getMessage(),
            "errorcode" => $e->getErrorCode()
        ]);
      }

      return $this->redirectToRoute('cle_show', array('id' => $cle->getId()));
    }

    return $this->render('cle/new.html.twig', array('form' => $form->createView(),));
  }


  //Edition d'une clé'


  public function editAction(Request $request, Cle $cle)

  {
    $deleteForm = $this->createFormBuilder()->setAction($this->generateUrl('cle_delete', array('id' => $cle->getId())))->setMethod('DELETE')->getForm();

    $editForm = $this->createForm('BackBundle\Form\CleType', $cle)->handleRequest($request);

    if ($editForm->isSubmitted() && $editForm->isValid()) {
      $datetime = new DateTime();
      $cle->setUpdated($datetime);

      try{

        $this->getDoctrine()->getManager()->flush();

      }catch (\Doctrine\DBAL\DBALException $e){
        return $this->render('error.html.twig', [
          "title" => "Une erreur est survenue lors de la suppression de l'entité",
          "message" => $e->getMessage(),
            "errorcode" => $e->getErrorCode()
        ]);
      }

      return $this->redirectToRoute('cle_show', array('id' => $cle->getId()));
    }

    return $this->render('cle/edit.html.twig', array(
      'cle' => $cle,
      'edit_form' => $editForm->createView(),
      'delete_form' => $deleteForm->createView(),
    ));
  }


  //Suppression d'une clé


  public function deleteAction(Request $request, Cle $cle)
  {
    $form = $this->createFormBuilder()
    ->setAction($this->generateUrl('cle_delete', array('id' => $cle->getId())))->setMethod('DELETE')->getForm()->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

      $em = $this->getDoctrine()->getManager();
      $em->remove($cle);


      //Gestion des Erreur de suppression

      try{
        $em->flush();
      }catch (\Doctrine\DBAL\DBALException $e){
        return $this->render('error.html.twig', [
          "title" => "Une erreur est survenue lors de la suppression de l'entité",
          "message" => $e->getMessage(),
            "errorcode" => $e->getErrorCode()
        ]);
      }
    }

    return $this->redirectToRoute('cle_index');

  }
}
