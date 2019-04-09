<?php

namespace Sari\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sari\AppBundle\Entity\Entreprise;
use Sari\AppBundle\Form\EntrepriseType;

/**
 * Entreprise controller.
 *
 * @Route("/admin/entreprise")
 */
class EntrepriseController extends Controller
{
    /**
     * Lists all Entreprise entities.
     *
     * @Route("/", name="admin_entreprise_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository('SariAppBundle:Entreprise');
        $query = $repository->createQueryBuilder('e')->getQuery();

        $paginator = $this->get('knp_paginator');
        $entreprises = $paginator->paginate($query, $request->query->getInt('page', 1), 20);

        return $this->render('SariAppBundle:Admin:entreprise/index.html.twig', array(
            'entreprises' => $entreprises,
        ));
    }

    /**
     * Lists all Entreprises deleted entities.
     *
     * @Route("/deleted", name="admin_entreprise_deleted")
     * @Method("GET")
     */
    public function deletedAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $em->getFilters()->disable('softdeleteable');
        $query = $em->getRepository('SariAppBundle:Entreprise')->findDeleted();

        $paginator = $this->get('knp_paginator');
        $entreprises = $paginator->paginate($query, $request->query->getInt('page', 1), 20);

        return $this->render('SariAppBundle:Admin:entreprise/deleted.html.twig', array(
            'entreprises' => $entreprises,
        ));
    }

    /**
     * Restore Entreprise deleted entities.
     *
     * @Route("/restore/{id}", name="admin_entreprise_restore")
     * @Method("GET")
     */
    public function restoreAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $em->getFilters()->disable('softdeleteable');
        $entreprise = $em->getRepository('SariAppBundle:Entreprise')->find($id);

        $entreprise->setDeletedAt(null);
        $em->persist($entreprise);
        $em->flush();

        $this->addFlash('success',
            'Réstauration de l\'entreprise ' . $entreprise->getRaisonSociale() . ' réussi !'
        );

        return $this->redirectToRoute('admin_entreprise_show', ['id' => $id]);
    }

    /**
     * Creates a new Entreprise entity.
     *
     * @Route("/new", name="admin_entreprise_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $entreprise = new Entreprise();
        $form = $this->createForm('Sari\AppBundle\Form\EntrepriseType', $entreprise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entreprise);
            $em->flush();

            return $this->redirectToRoute('admin_entreprise_show', array('id' => $entreprise->getId()));
        }

        return $this->render('SariAppBundle:Admin:entreprise/new.html.twig', array(
            'entreprise' => $entreprise,
            'form' => $form->createView(),
        ));
    }


    /**
     * Displays a form to edit an existing Entreprise entity.
     *
     * @Route("/{id}/edit", name="admin_entreprise_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Entreprise $entreprise)
    {
        $editForm = $this->createForm('Sari\AppBundle\Form\EntrepriseType', $entreprise);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entreprise);
            $em->flush();

            $this->addFlash('success',
                'Modification de l\'entreprise ' . $entreprise->getRaisonSociale() . ' réussi !'
            );

            return $this->redirectToRoute('admin_entreprise_show', array('id' => $entreprise->getId()));
        }

        return $this->render('SariAppBundle:Admin:entreprise/edit.html.twig', array(
            'entreprise' => $entreprise,
            'edit_form' => $editForm->createView()
        ));
    }

    /**
     * Deletes a Entreprise entity.
     *
     * @Route("/{id}", name="admin_entreprise_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Entreprise $entreprise)
    {
        $form = $this->createDeleteForm($entreprise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->addFlash('info',
                'Vous venez de supprimer ' . $entreprise->getRaisonSociale() . ' [entreprise_id#' . $entreprise->getId() . '] avec succès !'
            );

            $em = $this->getDoctrine()->getManager();
            $em->remove($entreprise);
            $em->flush();
        } else {
            $this->addFlash('danger',
                'Une erreur est survenue lors de la suppresion de l\'entreprise !'
            );
        }

        return $this->redirectToRoute('admin_entreprise_index');
    }

    /**
     * Creates a form to delete a Entreprise entity.
     *
     * @param Entreprise $entreprise The Entreprise entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Entreprise $entreprise)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_entreprise_delete', array('id' => $entreprise->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * Search action in ENtreprise entity
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/search", name="admin_entreprise_search")
     * @Method("GET")
     */
    public function searchAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository('SariAppBundle:Entreprise');

        $search = $request->query->get('search');
        $nbpage = $request->query->get('nbperpage');

        $nbpage = ($nbpage > 1 || $nbpage < 1000) ? $nbpage : 20;
        $search = mb_strtolower($search, 'UTF-8');
        $query = $repository->search($search);

        $paginator = $this->get('knp_paginator');
        $entreprises = $paginator->paginate($query, $request->query->getInt('page', 1), $nbpage);

        if ($entreprises->getTotalItemCount() > 0) {
            $this->addFlash('success',
                $entreprises->getTotalItemCount() . ' Entreprises trouvées avec la recherche : ' . $search
            );
        } else {
            $this->addFlash('info',
                'Pas de résultat avec votre recherche : ' . $search
            );
        }

        return $this->render('SariAppBundle:Admin:entreprise/index.html.twig', array('entreprises' => $entreprises));
    }


    /**
     * Finds and displays a Entreprise entity.
     *
     * @Route("/{id}", name="admin_entreprise_show")
     * @Method("GET")
     */
    public function showAction(Entreprise $entreprise)
    {
        $deleteForm = $this->createDeleteForm($entreprise);

        return $this->render('SariAppBundle:Admin:entreprise/show.html.twig', array(
            'entreprise' => $entreprise,
            'delete_form' => $deleteForm->createView(),
        ));
    }
}
