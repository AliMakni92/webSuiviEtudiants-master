<?php

namespace Sari\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sari\AppBundle\Entity\Stage;
use Sari\AppBundle\Form\StageType;

/**
 * Stage controller.
 *
 * @Route("/admin/stage")
 */
class StageController extends Controller
{
    /**
     * Lists all Stage entities.
     *
     * @Route("/", name="admin_stage_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository('SariAppBundle:Stage');
        $query = $repository->createQueryBuilder('e')->getQuery();

        $paginator = $this->get('knp_paginator');
        $stages = $paginator->paginate($query, $request->query->getInt('page', 1), 20);

        return $this->render('SariAppBundle:Admin:stage/index.html.twig', array(
            'stages' => $stages,
        ));
    }

    /**
     * Creates a new Stage entity.
     *
     * @Route("/new", name="admin_stage_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $stage = new Stage();
        $form = $this->createForm('Sari\AppBundle\Form\StageType', $stage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($stage);
            $em->flush();

            return $this->redirectToRoute('admin_stage_show', array('id' => $stage->getId()));
        }

        return $this->render('SariAppBundle:Admin:stage/new.html.twig', array(
            'stage' => $stage,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Stage entity.
     *
     * @Route("/{id}", name="admin_stage_show")
     * @Method("GET")
     */
    public function showAction(Stage $stage)
    {
        $deleteForm = $this->createDeleteForm($stage);

        return $this->render('SariAppBundle:Admin:stage/show.html.twig', array(
            'stage' => $stage,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Stage entity.
     *
     * @Route("/{id}/edit", name="admin_stage_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Stage $stage)
    {
        $deleteForm = $this->createDeleteForm($stage);
        $editForm = $this->createForm('Sari\AppBundle\Form\StageType', $stage);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($stage);
            $em->flush();

            return $this->redirectToRoute('admin_stage_show', array('id' => $stage->getId()));
        }

        return $this->render('SariAppBundle:Admin:stage/edit.html.twig', array(
            'stage' => $stage,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Stage entity.
     *
     * @Route("/{id}", name="admin_stage_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Stage $stage)
    {
        $form = $this->createDeleteForm($stage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($stage);
            $em->flush();
        }

        return $this->redirectToRoute('admin_stage_index');
    }

    /**
     * Creates a form to delete a Stage entity.
     *
     * @param Stage $stage The Stage entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Stage $stage)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_stage_delete', array('id' => $stage->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
