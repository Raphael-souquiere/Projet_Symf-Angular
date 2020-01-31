<?php

namespace BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use BackBundle\Entity\TypeUser;

class TypeUserController extends Controller
{

  //affichage de tout les type d'utilisateur

  public function showallAction()
  {
    $em = $this->getDoctrine()->getManager();
    $typeusers = $em->getRepository(TypeUser::class)->findAllOrderedByName();
    return $this->render('typeuser/index.html.twig', array(
      'typeusers' => $typeusers,
    ));
  }

  //affichage d'un type

  public function showAction($id)
  {
    $em = $this->getDoctrine()->getManager();

    $typeuser = $em->getRepository(TypeUser::class)->findOne($id);
    return $this->render('typeuser/show.html.twig', array(
      'typeuser' => $typeuser,
    ));
  }

  //création d'un type


  public function newAction(Request $request, TypeUser $typeuser = null)
  {
      $typeuser = new TypeUser();
      $form = $this->createForm('BackBundle\Form\TypeUserType', $typeuser);
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
          $em = $this->getDoctrine()->getManager();
          $em->persist($typeuser);
          $em->flush();

          return $this->redirectToRoute('typeuser_show', array('id' => $typeuser->getId()));
      }

      return $this->render('typeuser/new.html.twig', array('form' => $form->createView(),));
  }


  //Edition d'un utilisateur


  public function editAction(Request $request, TypeUser $typeuser)

    {
        $deleteForm = $this->createFormBuilder()->setAction($this->generateUrl('typeuser_delete', array('id' => $typeuser->getId())))->setMethod('DELETE')->getForm();

        $editForm = $this->createForm('BackBundle\Form\TypeUserType', $typeuser)->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('typeuser_show', array('id' => $typeuser->getId()));
        }

        return $this->render('typeuser/edit.html.twig', array(
            'typeuser' => $typeuser,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
  //Suppression d'un type


  public function deleteAction(Request $request, TypeUser $typeuser)
  {
    $form = $this->createFormBuilder()
    ->setAction($this->generateUrl('typeuser_delete', array('id' => $typeuser->getId())))->setMethod('DELETE')->getForm()->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

      $em = $this->getDoctrine()->getManager();
      $em->remove($typeuser);
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

    return $this->redirectToRoute('typeuser_index');
  }
}
