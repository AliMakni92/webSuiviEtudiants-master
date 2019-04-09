<?php

namespace Sari\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sari\AppBundle\Entity\Inscription;
use Sari\AppBundle\Form\InscriptionType;

/**
 * Inscription controller.
 *
 * @Route("/admin/inscription")
 */
class InscriptionController extends Controller
{
    /**
     * Lists all Inscription entities.
     *
     * @Route("/", name="admin_inscription_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository('SariAppBundle:Inscription');
        $query = $repository->createQueryBuilder('e')->getQuery();

        $paginator = $this->get('knp_paginator');
        $inscriptions = $paginator->paginate($query, $request->query->getInt('page', 1), 20);

        return $this->render('SariAppBundle:Admin:inscription/index.html.twig', array(
            'inscriptions' => $inscriptions,
        ));
    }

    /**
     * Creates a new Inscription entity.
     *
     * @Route("/new", name="admin_inscription_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $inscription = new Inscription();
        $form = $this->createForm('Sari\AppBundle\Form\InscriptionType', $inscription);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($inscription);
            $em->flush();

            return $this->redirectToRoute('admin_inscription_show', array('id' => $inscription->getId()));
        }

        return $this->render('SariAppBundle:Admin:inscription/new.html.twig', array(
            'inscription' => $inscription,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Inscription entity.
     *
     * @Route("/{id}", name="admin_inscription_show")
     * @Method("GET")
     */
    public function showAction(Inscription $inscription)
    {
        $deleteForm = $this->createDeleteForm($inscription);

        return $this->render('SariAppBundle:Admin:inscription/show.html.twig', array(
            'inscription' => $inscription,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Inscription entity.
     *
     * @Route("/{id}/edit", name="admin_inscription_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Inscription $inscription)
    {
        $deleteForm = $this->createDeleteForm($inscription);
        $editForm = $this->createForm('Sari\AppBundle\Form\InscriptionType', $inscription);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($inscription);
            $em->flush();

            return $this->redirectToRoute('admin_inscription_show', array('id' => $inscription->getId()));
        }

        return $this->render('SariAppBundle:Admin:inscription/edit.html.twig', array(
            'inscription' => $inscription,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Inscription entity.
     *
     * @Route("/{id}", name="admin_inscription_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Inscription $inscription)
    {
        $form = $this->createDeleteForm($inscription);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($inscription);
            $em->flush();
        }

        return $this->redirectToRoute('admin_inscription_index');
    }

    /**
     * Creates a form to delete a Inscription entity.
     *
     * @param Inscription $inscription The Inscription entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Inscription $inscription)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_inscription_delete', array('id' => $inscription->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
