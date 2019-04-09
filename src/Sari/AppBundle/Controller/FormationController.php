<?php

namespace Sari\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sari\AppBundle\Entity\Formation;
use Sari\AppBundle\Form\FormationType;

/**
 * Formation controller.
 *
 * @Route("/admin/formation")
 */
class FormationController extends Controller
{
    /**
     * Lists all Formation entities.
     *
     * @Route("/", name="admin_formation_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository('SariAppBundle:Formation');
        $query = $repository->createQueryBuilder('e')->getQuery();

        $paginator = $this->get('knp_paginator');
        $formations = $paginator->paginate($query, $request->query->getInt('page', 1), 20);

        return $this->render('SariAppBundle:Admin:formation/index.html.twig', array(
            'formations' => $formations,
        ));
    }

    /**
     * Creates a new Formation entity.
     *
     * @Route("/new", name="admin_formation_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $formation = new Formation();
        $form = $this->createForm('Sari\AppBundle\Form\FormationType', $formation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($formation);
            $em->flush();

            return $this->redirectToRoute('admin_formation_show', array('id' => $formation->getId()));
        }

        return $this->render('SariAppBundle:Admin:formation/new.html.twig', array(
            'formation' => $formation,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Formation entity.
     *
     * @Route("/{id}", name="admin_formation_show")
     * @Method("GET")
     */
    public function showAction(Formation $formation)
    {
        $deleteForm = $this->createDeleteForm($formation);

        return $this->render('SariAppBundle:Admin:formation/show.html.twig', array(
            'formation' => $formation,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Formation entity.
     *
     * @Route("/{id}/edit", name="admin_formation_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Formation $formation)
    {
        $editForm = $this->createForm('Sari\AppBundle\Form\FormationType', $formation);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($formation);
            $em->flush();

            return $this->redirectToRoute('admin_formation_show', array('id' => $formation->getId()));
        }

        return $this->render('SariAppBundle:Admin:formation/edit.html.twig', array(
            'formation' => $formation,
            'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * Deletes a Formation entity.
     *
     * @Route("/{id}", name="admin_formation_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Formation $formation)
    {
        $form = $this->createDeleteForm($formation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($formation);
            $em->flush();
        }

        return $this->redirectToRoute('admin_formation_index');
    }

    /**
     * Creates a form to delete a Formation entity.
     *
     * @param Formation $formation The Formation entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Formation $formation)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_formation_delete', array('id' => $formation->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
