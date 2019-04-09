<?php

namespace Sari\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sari\AppBundle\Entity\Enseignant;
use Sari\AppBundle\Form\EnseignantType;

/**
 * Enseignant controller.
 *
 * @Route("/admin/enseignant")
 */
class EnseignantController extends Controller
{
    /**
     * Lists all Enseignant entities.
     *
     * @Route("/", name="admin_enseignant_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository('SariAppBundle:Enseignant');
        $query = $repository->createQueryBuilder('e')->getQuery();

        $paginator = $this->get('knp_paginator');
        $enseignants = $paginator->paginate($query, $request->query->getInt('page', 1), 20);

        return $this->render('SariAppBundle:Admin:enseignant/index.html.twig', array(
            'enseignants' => $enseignants,
        ));
    }

    /**
     * Creates a new Enseignant entity.
     *
     * @Route("/new", name="admin_enseignant_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $enseignant = new Enseignant();
        $form = $this->createForm('Sari\AppBundle\Form\EnseignantType', $enseignant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($enseignant);
            $em->flush();

            return $this->redirectToRoute('admin_enseignant_show', array('id' => $enseignant->getId()));
        }

        return $this->render('SariAppBundle:Admin:enseignant/new.html.twig', array(
            'enseignant' => $enseignant,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Enseignant entity.
     *
     * @Route("/{id}", name="admin_enseignant_show")
     * @Method("GET")
     */
    public function showAction(Enseignant $enseignant)
    {
        $deleteForm = $this->createDeleteForm($enseignant);

        return $this->render('SariAppBundle:Admin:enseignant/show.html.twig', array(
            'enseignant' => $enseignant,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Enseignant entity.
     *
     * @Route("/{id}/edit", name="admin_enseignant_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Enseignant $enseignant)
    {
        $deleteForm = $this->createDeleteForm($enseignant);
        $editForm = $this->createForm('Sari\AppBundle\Form\EnseignantType', $enseignant);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($enseignant);
            $em->flush();

            return $this->redirectToRoute('admin_enseignant_show', array('id' => $enseignant->getId()));
        }

        return $this->render('SariAppBundle:Admin:enseignant/edit.html.twig', array(
            'enseignant' => $enseignant,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Enseignant entity.
     *
     * @Route("/{id}", name="admin_enseignant_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Enseignant $enseignant)
    {
        $form = $this->createDeleteForm($enseignant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $this->addFlash('info',
                'Vous venez de supprimer enseignant avec succès !'
            );

            $em->remove($enseignant);
            $em->flush();
        }

        return $this->redirectToRoute('admin_enseignant_index');
    }

    /**
     * Creates a form to delete a Enseignant entity.
     *
     * @param Enseignant $enseignant The Enseignant entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Enseignant $enseignant)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_enseignant_delete', array('id' => $enseignant->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
