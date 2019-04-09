<?php

namespace Sari\UserBundle\Controller;

use Sari\UserBundle\Entity\Utilisateur;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Utilisateur controller.
 *
 * @Route("/admin/utilisateur")
 */
class UtilisateurController extends Controller
{
    /**
     * Lists all Utilisateur entities.
     *
     * @Route("/", name="admin_utilisateur_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {

        $repository = $this->getDoctrine()->getRepository('SariUserBundle:Utilisateur');
        $query = $repository->createQueryBuilder('u')->orderBy('u.id', 'ASC')->getQuery();

        $paginator = $this->get('knp_paginator');
        $utilisateurs = $paginator->paginate($query, $request->query->getInt('page', 1), 20);

        return $this->render('SariUserBundle:Admin:utilisateur/index.html.twig', array(
            'utilisateurs' => $utilisateurs,
        ));
    }

    /**
     * Lists all Personne deleted entities.
     *
     * @Route("/deleted", name="admin_utilisateur_deleted")
     * @Method("GET")
     */
    public function deletedAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $em->getFilters()->disable('softdeleteable');
        $query = $em->getRepository('SariUserBundle:Utilisateur')->findDeleted();

        $paginator = $this->get('knp_paginator');
        $utilisateurs = $paginator->paginate($query, $request->query->getInt('page', 1), 20);

        return $this->render('SariUserBundle:Admin:utilisateur/deleted.html.twig', array(
            'utilisateurs' => $utilisateurs,
        ));
    }

    /**
     * Restore Personne deleted entities.
     *
     * @Route("/restore/{id}", name="admin_utilisateur_restore")
     * @Method("GET")
     */
    public function restoreAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $em->getFilters()->disable('softdeleteable');
        $utilisateur = $em->getRepository('SariUserBundle:Utilisateur')->find($id);

        $utilisateur->setDeletedAt(null);
        $em->persist($utilisateur);
        $em->flush();

        $this->addFlash('success',
            'Réstauration de l\'utilisateur ' . $utilisateur->getUsername() . ' réussi !'
        );

        return $this->redirectToRoute('admin_utilisateur_show', ['id' => $id]);
    }

    /**
     * Displays a form to edit an existing Utilisateur entity.
     *
     * @Route("/{id}/edit", name="admin_utilisateur_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Utilisateur $utilisateur)
    {
        $editForm = $this->createForm('Sari\UserBundle\Form\UtilisateurType', $utilisateur);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($utilisateur);
            $em->flush();

            $this->addFlash('success',
                'Modification réussi !'
            );
            return $this->redirectToRoute('admin_utilisateur_show', array('id' => $utilisateur->getId()));
        }

        return $this->render('SariUserBundle:Admin:utilisateur/edit.html.twig', array(
            'utilisateur' => $utilisateur,
            'edit_form' => $editForm->createView()
        ));
    }

    /**
     * Deletes a Utilisateur entity.
     *
     * @Route("/{id}", name="admin_utilisateur_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Utilisateur $utilisateur)
    {
        $form = $this->createDeleteForm($utilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            if (!in_array('ROLE_SUPER_ADMIN', $utilisateur->getRoles())) {

                $this->addFlash('info',
                    'Vous venez de supprimer ' . $utilisateur->getUsername() . ' ' . $utilisateur->getEmail() . ' [utilisateur_id#' . $utilisateur->getId() . '] avec succès !'
                );

                $em->remove($utilisateur);
                $em->flush();
            } else {
                // On supprime pas le compte super admin
                // set flash messages
                $this->addFlash(
                    'danger',
                    'Impossible de supprimer le compte administrateur'
                );
            }
        }

        return $this->redirectToRoute('admin_utilisateur_index');
    }

    /**
     * Creates a form to delete a Utilisateur entity.
     *
     * @param Utilisateur $utilisateur The Utilisateur entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Utilisateur $utilisateur)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_utilisateur_delete', array('id' => $utilisateur->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * Search action in Personne entity
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/search", name="admin_utilisateur_search")
     * @Method("GET")
     */
    public function searchAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository('SariUserBundle:Utilisateur');

        $search = $request->query->get('search');
        $nbpage = $request->query->get('nbperpage');

        $nbpage = ($nbpage > 1 || $nbpage < 1000) ? $nbpage : 20;
        $search = mb_strtolower($search, 'UTF-8');
        $query = $repository->search($search);

        $paginator = $this->get('knp_paginator');
        $utilisateurs = $paginator->paginate($query, $request->query->getInt('page', 1), $nbpage);

        if ($utilisateurs->getTotalItemCount() > 0) {
            $this->addFlash('success',
                $utilisateurs->getTotalItemCount() . ' Personnes trouvées avec la recherche : ' . $search . ' sur les noms et prénoms'
            );
        } else {
            $this->addFlash('info',
                'Pas de résultat avec votre recherche : ' . $search . ' sur les nom de compte et email'
            );
        }

        return $this->render('SariUserBundle:Admin:utilisateur/index.html.twig', array('utilisateurs' => $utilisateurs));
    }

    /**
     * Finds and displays a Utilisateur entity.
     *
     * @Route("/{id}", name="admin_utilisateur_show")
     * @Method("GET")
     */
    public function showAction(Utilisateur $utilisateur)
    {
        $deleteForm = $this->createDeleteForm($utilisateur);

        return $this->render('SariUserBundle:Admin:utilisateur/show.html.twig', array(
            'utilisateur' => $utilisateur,
            'delete_form' => $deleteForm->createView(),
        ));
    }
}
