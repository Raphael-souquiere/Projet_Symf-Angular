<?php

namespace BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use BackBundle\Entity\Site;

class SiteController extends Controller
{
  public function showallAction()
  {
      $em = $this->getDoctrine()->getManager();

      $sites = $em->getRepository(Site::class)->findAllOrderedByName();
      return $this->render('site/index.html.twig', array(
          'sites' => $sites,
      ));
  }


  public function showAction($id)
  {
      $em = $this->getDoctrine()->getManager();

      $site = $em->getRepository(Site::class)->findOne($id);
      return $this->render('site/show.html.twig', array(
          'site' => $site,
      ));
  }


  public function newAction(Request $request, Site $site = null)
  {
      $site = new Site();
      $form = $this->createForm('BackBundle\Form\SiteType', $site);
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
          $em = $this->getDoctrine()->getManager();
          $em->persist($site);
          $em->flush();

          return $this->redirectToRoute('site_show', array('id' => $site->getId()));
      }

      return $this->render('site/new.html.twig', array('form' => $form->createView(),));
  }


  //Edition d'un utilisateur


  public function editAction(Request $request, Site $site)

    {
        $deleteForm = $this->createFormBuilder()->setAction($this->generateUrl('site_delete', array('id' => $site->getId())))->setMethod('DELETE')->getForm();

        $editForm = $this->createForm('BackBundle\Form\SiteType', $site)->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('site_show', array('id' => $site->getId()));
        }

        return $this->render('site/edit.html.twig', array(
            'site' => $site,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }


    //Suppresion d'un utilisateur


    public function deleteAction(Request $request, Site $site)
    {
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('site_delete', array('id' => $site->getId())))->setMethod('DELETE')->getForm()->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->remove($site);
            $em->flush();
        }

        return $this->redirectToRoute('site_index');
    }
}
