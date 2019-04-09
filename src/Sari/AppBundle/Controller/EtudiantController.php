<?php

namespace Sari\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sari\AppBundle\Entity\Etudiant;
use Sari\AppBundle\Form\EtudiantType;

/**
 * Etudiant controller.
 *
 * @Route("/admin/etudiant")
 */
class EtudiantController extends Controller
{
    /**
     * Lists all Etudiant entities.
     *
     * @Route("/", name="admin_etudiant_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository('SariAppBundle:Etudiant');
        $query = $repository->createQueryBuilder('e')->getQuery();

        $paginator = $this->get('knp_paginator');
        $etudiants = $paginator->paginate($query, $request->query->getInt('page', 1), 20);

        return $this->render('SariAppBundle:Admin:etudiant/index.html.twig', array(
            'etudiants' => $etudiants,
        ));
    }

    /**
     * Creates a new Etudiant entity.
     *
     * @Route("/new", name="admin_etudiant_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $etudiant = new Etudiant();
        $form = $this->createForm('Sari\AppBundle\Form\EtudiantType', $etudiant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($etudiant);
            $em->flush();

            return $this->redirectToRoute('admin_etudiant_show', array('id' => $etudiant->getId()));
        }

        return $this->render('SariAppBundle:Admin:etudiant/new.html.twig', array(
            'etudiant' => $etudiant,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Etudiant entity.
     *
     * @Route("/{id}", name="admin_etudiant_show")
     * @Method("GET")
     */
    public function showAction(Etudiant $etudiant)
    {
        $deleteForm = $this->createDeleteForm($etudiant);

        return $this->render('SariAppBundle:Admin:etudiant/show.html.twig', array(
            'etudiant' => $etudiant,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Etudiant entity.
     *
     * @Route("/{id}/edit", name="admin_etudiant_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Etudiant $etudiant)
    {
        $deleteForm = $this->createDeleteForm($etudiant);
        $editForm = $this->createForm('Sari\AppBundle\Form\EtudiantType', $etudiant);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($etudiant);
            $em->flush();

            return $this->redirectToRoute('admin_etudiant_show', array('id' => $etudiant->getId()));
        }

        return $this->render('SariAppBundle:Admin:etudiant/edit.html.twig', array(
            'etudiant' => $etudiant,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Etudiant entity.
     *
     * @Route("/{id}", name="admin_etudiant_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Etudiant $etudiant)
    {
        $form = $this->createDeleteForm($etudiant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($etudiant);
            $em->flush();
        }

        return $this->redirectToRoute('admin_etudiant_index');
    }

    /**
     * Creates a form to delete a Etudiant entity.
     *
     * @param Etudiant $etudiant The Etudiant entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Etudiant $etudiant)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_etudiant_delete', array('id' => $etudiant->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
