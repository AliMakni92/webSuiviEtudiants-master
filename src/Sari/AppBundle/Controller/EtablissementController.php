<?php

namespace Sari\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sari\AppBundle\Entity\Etablissement;
use Sari\AppBundle\Form\EtablissementType;

/**
 * Etablissement controller.
 *
 * @Route("/admin/etablissement")
 */
class EtablissementController extends Controller
{
    /**
     * Lists all Etablissement entities.
     *
     * @Route("/", name="admin_etablissement_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository('SariAppBundle:Etablissement');
        $query = $repository->createQueryBuilder('e')->getQuery();

        $paginator = $this->get('knp_paginator');
        $etablissements = $paginator->paginate($query, $request->query->getInt('page', 1), 20);
        return $this->render('SariAppBundle:Admin:etablissement/index.html.twig', array(
            'etablissements' => $etablissements,
        ));
    }

    /**
     * Lists all Entreprises deleted entities.
     *
     * @Route("/deleted", name="admin_etablissement_deleted")
     * @Method("GET")
     */
    public function deletedAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $em->getFilters()->disable('softdeleteable');
        $query = $em->getRepository('SariAppBundle:Etablissement')->findDeleted();

        $paginator = $this->get('knp_paginator');
        $etablissements = $paginator->paginate($query, $request->query->getInt('page', 1), 20);

        return $this->render('SariAppBundle:Admin:etablissement/deleted.html.twig', array(
            'etablissements' => $etablissements,
        ));
    }

    /**
     * Restore Entreprise deleted entities.
     *
     * @Route("/restore/{id}", name="admin_etablissement_restore")
     * @Method("GET")
     */
    public function restoreAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $em->getFilters()->disable('softdeleteable');
        $etablissement = $em->getRepository('SariAppBundle:Etablissement')->find($id);

        $etablissement->setDeletedAt(null);
        $em->persist($etablissement);
        $em->flush();

        $this->addFlash('success',
            'Restauration de l\'établissement réussi !'
        );

        return $this->redirectToRoute('admin_etablissement_show', ['id' => $id]);
    }


    /**
     * Creates a new Etablissement entity.
     *
     * @Route("/new", name="admin_etablissement_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $etablissement = new Etablissement();
        $form = $this->createForm('Sari\AppBundle\Form\EtablissementType', $etablissement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($etablissement);
            $em->flush();

            return $this->redirectToRoute('admin_etablissement_show', array('id' => $etablissement->getId()));
        }

        return $this->render('SariAppBundle:Admin:etablissement/new.html.twig', array(
            'etablissement' => $etablissement,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Etablissement entity.
     *
     * @Route("/{id}/edit", name="admin_etablissement_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Etablissement $etablissement)
    {
        $editForm = $this->createForm('Sari\AppBundle\Form\EtablissementType', $etablissement);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($etablissement);
            $em->flush();

            $this->addFlash('success',
                'Modification de l\'établissement réussi !'
            );

            return $this->redirectToRoute('admin_etablissement_show', array('id' => $etablissement->getId()));
        }

        return $this->render('SariAppBundle:Admin:etablissement/edit.html.twig', array(
            'etablissement' => $etablissement,
            'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * Deletes a Etablissement entity.
     *
     * @Route("/{id}", name="admin_etablissement_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Etablissement $etablissement)
    {
        $form = $this->createDeleteForm($etablissement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->addFlash('info',
                'Vous venez de supprimer ' . $etablissement->getNom() . ' [etablissement_id#' . $etablissement->getId() . '] avec succès !'
            );

            $em = $this->getDoctrine()->getManager();
            $em->remove($etablissement);
            $em->flush();
        }

        return $this->redirectToRoute('admin_etablissement_index');
    }

    /**
     * Creates a form to delete a Etablissement entity.
     *
     * @param Etablissement $etablissement The Etablissement entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Etablissement $etablissement)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_etablissement_delete', array('id' => $etablissement->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * Search action in ENtreprise entity
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/search", name="admin_etablissement_search")
     * @Method("GET")
     */
    public function searchAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository('SariAppBundle:Etablissement');

        $search = $request->query->get('search');
        $nbpage = $request->query->get('nbperpage');

        $nbpage = ($nbpage > 1 || $nbpage < 1000) ? $nbpage : 20;
        $search = mb_strtolower($search, 'UTF-8');
        $query = $repository->search($search);

        $paginator = $this->get('knp_paginator');
        $etablissements = $paginator->paginate($query, $request->query->getInt('page', 1), $nbpage);

        if ($etablissements->getTotalItemCount() > 0) {
            $this->addFlash('success',
                $etablissements->getTotalItemCount() . ' Etablissements trouvées avec la recherche : ' . $search
            );
        } else {
            $this->addFlash('info',
                'Pas de résultat avec votre recherche : ' . $search
            );
        }

        return $this->render('SariAppBundle:Admin:etablissement/index.html.twig', array('etablissements' => $etablissements));
    }

    /**
     * Finds and displays a Etablissement entity.
     *
     * @Route("/{id}", name="admin_etablissement_show")
     * @Method("GET")
     */
    public function showAction(Etablissement $etablissement)
    {
        $deleteForm = $this->createDeleteForm($etablissement);

        return $this->render('SariAppBundle:Admin:etablissement/show.html.twig', array(
            'etablissement' => $etablissement,
            'delete_form' => $deleteForm->createView(),
        ));
    }
}
