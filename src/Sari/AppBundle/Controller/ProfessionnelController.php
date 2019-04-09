<?php

namespace Sari\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sari\AppBundle\Entity\Professionnel;
use Sari\AppBundle\Form\ProfessionnelType;

/**
 * Professionnel controller.
 *
 * @Route("/admin/professionnel")
 */
class ProfessionnelController extends Controller
{
    /**
     * Lists all Professionnel entities.
     *
     * @Route("/", name="admin_professionnel_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository('SariAppBundle:Professionnel');
        $query = $repository->createQueryBuilder('p')->getQuery();

        $paginator = $this->get('knp_paginator');
        $professionnels = $paginator->paginate($query, $request->query->getInt('page', 1), 20);

        return $this->render('SariAppBundle:Admin:professionnel/index.html.twig', array(
            'professionnels' => $professionnels,
        ));
    }

    /**
     * Lists all Entreprises deleted entities.
     *
     * @Route("/deleted", name="admin_professionnel_deleted")
     * @Method("GET")
     */
    public function deletedAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $em->getFilters()->disable('softdeleteable');
        $query = $em->getRepository('SariAppBundle:Professionnel')->findDeleted();

        $paginator = $this->get('knp_paginator');
        $professionnels = $paginator->paginate($query, $request->query->getInt('page', 1), 20);

        return $this->render('SariAppBundle:Admin:professionnel/deleted.html.twig', array(
            'professionnels' => $professionnels,
        ));
    }

    /**
     * Restore Entreprise deleted entities.
     *
     * @Route("/restore/{id}", name="admin_professionnel_restore")
     * @Method("GET")
     */
    public function restoreAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $em->getFilters()->disable('softdeleteable');
        $professionnel = $em->getRepository('SariAppBundle:Professionnel')->find($id);
        $entreprise = $em->getRepository('SariAppBundle:Entreprise')->find($professionnel->getEntreprise());

        if ($entreprise->getDeletedAt() != null) {
            $this->addFlash('danger',
                'Impossible de restaurer ce professionnel l\'entreprise n\'existe plus, il faut restaurer l\'entreprise  ' . $entreprise->getRaisonSociale() . ' avant'
            );
        } else {
            $professionnel->setDeletedAt(null);
            $em->persist($professionnel);
            $em->flush();

            $this->addFlash('success',
                'Réstauration du professionnel '
            );
            return $this->redirectToRoute('admin_professionnel_show', ['id' => $id]);
        }

        return $this->redirectToRoute('admin_professionnel_deleted');

    }

    /**
     * Creates a new Professionnel entity.
     *
     * @Route("/new", name="admin_professionnel_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $professionnel = new Professionnel();
        $form = $this->createForm('Sari\AppBundle\Form\ProfessionnelType', $professionnel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($professionnel);
            $em->flush();

            return $this->redirectToRoute('admin_professionnel_show', array('id' => $professionnel->getId()));
        }

        return $this->render('SariAppBundle:Admin:professionnel/new.html.twig', array(
            'professionnel' => $professionnel,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Professionnel entity.
     *
     * @Route("/{id}/edit", name="admin_professionnel_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Professionnel $professionnel)
    {
        $editForm = $this->createForm('Sari\AppBundle\Form\ProfessionnelType', $professionnel);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($professionnel);
            $em->flush();

            return $this->redirectToRoute('admin_professionnel_show', array('id' => $professionnel->getId()));
        }

        return $this->render('SariAppBundle:Admin:professionnel/edit.html.twig', array(
            'professionnel' => $professionnel,
            'edit_form' => $editForm->createView()
        ));
    }

    /**
     * Deletes a Professionnel entity.
     *
     * @Route("/{id}", name="admin_professionnel_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Professionnel $professionnel)
    {
        $form = $this->createDeleteForm($professionnel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->addFlash('info',
                'Vous venez de supprimer le professionnel !'
            );

            $em = $this->getDoctrine()->getManager();
            $em->remove($professionnel);
            $em->flush();
        }

        return $this->redirectToRoute('admin_professionnel_index');
    }

    /**
     * Creates a form to delete a Professionnel entity.
     *
     * @param Professionnel $professionnel The Professionnel entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Professionnel $professionnel)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_professionnel_delete', array('id' => $professionnel->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * Finds and displays a Professionnel entity.
     *
     * @Route("/{id}", name="admin_professionnel_show")
     * @Method("GET")
     */
    public function showAction(Professionnel $professionnel)
    {
        $deleteForm = $this->createDeleteForm($professionnel);

        return $this->render('SariAppBundle:Admin:professionnel/show.html.twig', array(
            'professionnel' => $professionnel,
            'delete_form' => $deleteForm->createView(),
        ));
    }
}
