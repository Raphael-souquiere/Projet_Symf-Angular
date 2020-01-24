<?php

namespace BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use BackBundle\Entity\User;
use BackBundle\Entity\Cle;
use \Datetime;

class StatistiqueController extends Controller


{


  //Liste de tout les utilisateur


  public function statAction()
  {
      $em = $this->getDoctrine()->getManager();
        $statuser = $em->getRepository(User::class)->findUserActif();

        $statcle = $em->getRepository(Cle::class)->findCleActif();

        $statcle = $em->getRepository(Cle::class)->findCleActif();

        $statcle = $em->getRepository(Cle::class)->findCleActif();

        return $this->render('stat.html.twig', array(
            'user' => $statuser,'cle' => $statcle
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
          $datetime = new DateTime();
          $user->setCreated($datetime);
          $user->setUpdated($datetime);
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
            $datetime = new DateTime();
            $user->setUpdated($datetime);
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
