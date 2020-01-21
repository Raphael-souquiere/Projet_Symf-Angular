<?php

namespace BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use BackBundle\Entity\User;

class UserController extends Controller


{


  //Liste de tout les utilisateur


  public function showallAction()
  {
      $em = $this->getDoctrine()->getManager();

      $users = $em->getRepository(User::class)->findAllOrderedByName();
      return $this->render('user/index.html.twig', array(
          'users' => $users,
      ));
  }


  //detail d'un utilisateur


  public function showAction($id)
  {
      $em = $this->getDoctrine()->getManager();

      $user = $em->getRepository(User::class)->findOne($id);
      return $this->render('user/show.html.twig', array(
          'user' => $user,
      ));
  }


  //creation d'un utilisateur


  public function newAction(Request $request, User $user = null)
  {
      $user = new User();
      $form = $this->createForm('BackBundle\Form\UserType', $user);
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
          $em = $this->getDoctrine()->getManager();
          $em->persist($user);
          $em->flush();

          return $this->redirectToRoute('user_show', array('id' => $user->getId()));
      }

      return $this->render('user/new.html.twig', array('form' => $form->createView(),));
  }


  //Edition d'un utilisateur


  public function editAction(Request $request, User $user)

    {
        $deleteForm = $this->createFormBuilder()->setAction($this->generateUrl('user_delete', array('id' => $user->getId())))->setMethod('DELETE')->getForm();

        $editForm = $this->createForm('BackBundle\Form\UserType', $user)->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_show', array('id' => $user->getId()));
        }

        return $this->render('user/edit.html.twig', array(
            'user' => $user,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }


    //Suppresion d'un utilisateur


    public function deleteAction(Request $request, User $user)
    {
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('user_delete', array('id' => $user->getId())))->setMethod('DELETE')->getForm()->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();
        }

        return $this->redirectToRoute('user_index');
    }

}
