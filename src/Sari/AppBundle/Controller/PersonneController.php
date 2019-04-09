<?php

namespace Sari\AppBundle\Controller;

use PHPExcel_IOFactory;
use Sari\AppBundle\Entity\Adresse;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sari\AppBundle\Entity\Personne;
use Sari\AppBundle\Form\PersonneType;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Personne controller.
 *
 * @Route("/admin/personne")
 */
class PersonneController extends Controller
{
    /**
     * Lists all Personne entities.
     *
     * @Route("/", name="admin_personne_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository('SariAppBundle:Personne');
        $query = $repository->createQueryBuilder('p')->getQuery();

        $paginator = $this->get('knp_paginator');
        $personnes = $paginator->paginate($query, $request->query->getInt('page', 1), 20);

        return $this->render('SariAppBundle:Admin:personne/index.html.twig', array(
            'personnes' => $personnes,
        ));
    }

    /**
     * Lists all Personne deleted entities.
     *
     * @Route("/deleted", name="admin_personne_deleted")
     * @Method("GET")
     */
    public function deletedAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $em->getFilters()->disable('softdeleteable');
        $query = $em->getRepository('SariAppBundle:Personne')->findDeleted();

        $paginator = $this->get('knp_paginator');
        $personnes = $paginator->paginate($query, $request->query->getInt('page', 1), 20);

        return $this->render('SariAppBundle:Admin:personne/deleted.html.twig', array(
            'personnes' => $personnes,
        ));
    }

    /**
     * Restore Personne deleted entities.
     *
     * @Route("/restore/{id}", name="admin_personne_restore")
     * @Method("GET")
     */
    public function restoreAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $em->getFilters()->disable('softdeleteable');
        $personne = $em->getRepository('SariAppBundle:Personne')->find($id);

        $personne->setDeletedAt(null);
        $em->persist($personne);
        $em->flush();

        $this->addFlash('success',
            'Restauration réussi !'
        );

        return $this->redirectToRoute('admin_personne_show', ['id' => $id]);
    }


    /**
     * Creates a new Personne entity.
     *
     * @Route("/new", name="admin_personne_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $personne = new Personne();
        $form = $this->createForm('Sari\AppBundle\Form\PersonneType', $personne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($personne);
            $em->flush();

            return $this->redirectToRoute('admin_personne_show', array('id' => $personne->getId()));
        }

        return $this->render('SariAppBundle:Admin:personne/new.html.twig', array(
            'personne' => $personne,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Personne entity.
     *
     * @Route("/{id}/edit", name="admin_personne_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Personne $personne)
    {
        $editForm = $this->createForm('Sari\AppBundle\Form\PersonneType', $personne);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($personne);
            $em->flush();

            $this->addFlash('success',
                'Modification réussi !'
            );
            return $this->redirectToRoute('admin_personne_show', array('id' => $personne->getId()));

        }

        return $this->render('SariAppBundle:Admin:personne/edit.html.twig', array(
            'personne' => $personne,
            'edit_form' => $editForm->createView()
        ));
    }

    /**
     * Deletes a Personne entity.
     *
     * @Route("/{id}", name="admin_personne_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Personne $personne)
    {
        $form = $this->createDeleteForm($personne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->addFlash('info',
                'Vous venez de supprimer ' . $personne->getPrenom() . ' ' . $personne->getNom() . ' [personne_id#' . $personne->getId() . '] avec succès !'
            );
            $em = $this->getDoctrine()->getManager();
            $em->remove($personne);
            $em->flush();
        } else {
            $this->addFlash('danger',
                'Une erreur est survenue lors de la suppresion de la personne !'
            );
        }

        return $this->redirectToRoute('admin_personne_index');
    }

    /**
     * Creates a form to delete a Personne entity.
     *
     * @param Personne $personne The Personne entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Personne $personne)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_personne_delete', array('id' => $personne->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }


    /**
     * Search action in Personne entity
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/search", name="admin_personne_search")
     * @Method("GET")
     */
    public function searchAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository('SariAppBundle:Personne');

        $search = $request->query->get('search');
        $nbpage = $request->query->get('nbperpage');

        $nbpage = ($nbpage > 1 || $nbpage < 1000) ? $nbpage : 20;
        $search = mb_strtolower($search, 'UTF-8');
        $query = $repository->search($search);

        $paginator = $this->get('knp_paginator');
        $personnes = $paginator->paginate($query, $request->query->getInt('page', 1), $nbpage);

        if ($personnes->getTotalItemCount() > 0) {
            $this->addFlash('success',
                $personnes->getTotalItemCount() . ' Personnes trouvées avec la recherche : ' . $search . ' sur les noms et prénoms'
            );
        } else {
            $this->addFlash('info',
                'Pas de résultat avec votre recherche : ' . $search . ' sur les noms et prénoms'
            );
        }

        return $this->render('SariAppBundle:Admin:personne/index.html.twig', array('personnes' => $personnes));
    }

    /**
     * Import
     *
     * @Route("/import", name="admin_personne_import")
     * @Method({"GET", "POST"})
     */
    public function importAction(Request $request)
    {
        $form = $this->createFormBuilder()->add('file', FileType::class)->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $file = $form->get('file');
            $uploadFile = $file->getData();

            $em = $this->getDoctrine()->getManager();

            $inputFileName = $uploadFile->getPathName();
            $excelReader = PHPExcel_IOFactory::createReaderForFile($inputFileName);
            $excelReader->setReadDataOnly();
            $excelReader->setLoadAllSheets();

            $excelObj = $excelReader->load($inputFileName);

            $excelObj->setActiveSheetIndex();

            $feuille = $excelObj->getActiveSheet()->toArray(null, true, true, true);

            $message = "Erreur pour les personnes : ";

            for ($ligne = 2; $ligne < count($feuille); $ligne++) {
                $uneLigne = $feuille[$ligne];

                $personne = new Personne();

                if (!is_null($uneLigne['B']) && !is_null($uneLigne['C']) && !is_null($uneLigne['D'])) {

                    $double = $this->getDoctrine()->getRepository('SariAppBundle:Personne')->findOneBy(['nom' => $uneLigne['B'], 'prenom' => $uneLigne['C'], 'sexe' => $uneLigne['D']]);

                    if (count($double) > 0) {
                        $message = $message . ' (' . $double->getPrenom() . ' ' . $double->getNom() . ')';
                    } else {
                        $personne->setNom($uneLigne['B']);
                        $personne->setPrenom($uneLigne['C']);
                        $personne->setSexe($uneLigne['D']);
                        $personne->setDateNaissance(date_create($uneLigne['E']));

                        $adresse = new Adresse();
                        $adresse->setAdr($uneLigne['F']);
                        $adresse->setComplement($uneLigne['G']);
                        $adresse->setCodePostal($uneLigne['H']);
                        $adresse->setVille($uneLigne['I']);
                        $adresse->setPays($uneLigne['J']);
                        $adresse->setTelFixe($uneLigne['K']);
                        $adresse->setTelPort($uneLigne['L']);

                        $em->persist($personne);
                        $em->flush();
                    }
                }


            }

            $this->addFlash('warning',
                $message
            );

            return $this->redirectToRoute('admin_personne_index');

        }

        return $this->render('SariAppBundle:Admin:personne/import.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Export
     *
     * @Route("/export", name="admin_personne_export")
     * @Method("GET")
     */
    public function exportAction()
    {
        $personnes = $this->getDoctrine()->getRepository('SariAppBundle:Personne')->findAll();

        $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();

        $phpExcelObject->getProperties()->setCreator("Suivi Etudiant")
            ->setLastModifiedBy("Suivi Etudiant")
            ->setTitle("Liste des personnes")
            ->setSubject("liste des personnes du site suivis des étudiants")
            ->setDescription("Liste des personnes du site suivis des étudiants.")
            ->setKeywords("personnes suivis étudiants")
            ->setCategory("suivis_etudiant/personne");

        $phpExcelObject->setActiveSheetIndex(0)
            ->setCellValue('A1', 'ID')
            ->setCellValue('B1', 'Nom')
            ->setCellValue('C1', 'Prénom')
            ->setCellValue('D1', 'Sexe')
            ->setCellValue('E1', 'Date Naissance')
            ->setCellValue('F1', 'Adresse')
            ->setCellValue('G1', 'Complement')
            ->setCellValue('H1', 'Code Postale')
            ->setCellValue('I1', 'Ville')
            ->setCellValue('J1', 'Pays')
            ->setCellValue('K1', 'Tel fixe')
            ->setCellValue('L1', 'Tel Port')
            ->setCellValue('M1', 'Mise à jour le');

        $i = 1;
        foreach ($personnes as $personne) {
            $i++;
            $phpExcelObject->setActiveSheetIndex(0)
                ->setCellValue('A' . $i, $i - 1)
                ->setCellValue('B' . $i, $personne->getNom())
                ->setCellValue('C' . $i, $personne->getPrenom())
                ->setCellValue('D' . $i, $personne->getSexe())
                ->setCellValue('E' . $i, $personne->getDateNaissance())
                ->setCellValue('F' . $i, $personne->getAdrPersonnel()->getAdr())
                ->setCellValue('G' . $i, $personne->getAdrPersonnel()->getComplement())
                ->setCellValue('H' . $i, $personne->getAdrPersonnel()->getCodePostal())
                ->setCellValue('I' . $i, $personne->getAdrPersonnel()->getVille())
                ->setCellValue('J' . $i, $personne->getAdrPersonnel()->getPays())
                ->setCellValue('K' . $i, $personne->getAdrPersonnel()->getTelFixe())
                ->setCellValue('L' . $i, $personne->getAdrPersonnel()->getTelPort())
                ->setCellValue('M' . $i, $personne->getUpdatedAt());
        }

        $phpExcelObject->getActiveSheet()->setTitle('Simple');
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $phpExcelObject->setActiveSheetIndex(0);

        // create the writer
        $writer = $this->get('phpexcel')->createWriter($phpExcelObject, 'Excel5');
        // create the response
        $response = $this->get('phpexcel')->createStreamedResponse($writer);
        // adding headers
        $dispositionHeader = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            date('H:i:s') . '_personnes_suivi_etudiants.xls'
        );
        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');
        $response->headers->set('Content-Disposition', $dispositionHeader);


        return $response;
    }

    /**
     * Finds and displays a Personne entity.
     *
     * @Route("/{id}", name="admin_personne_show")
     * @Method("GET")
     */
    public function showAction(Personne $personne)
    {
        $deleteForm = $this->createDeleteForm($personne);

        $etudiant = $this->getDoctrine()->getRepository('SariAppBundle:Etudiant')->findOneBy(['personne' => $personne->getId()]);
        $professionnel = $this->getDoctrine()->getRepository('SariAppBundle:Professionnel')->findOneBy(['personne' => $personne->getId()]);
        $enseignant = $this->getDoctrine()->getRepository('SariAppBundle:Enseignant')->findOneBy(['personne' => $personne->getId()]);

        return $this->render('SariAppBundle:Admin:personne/show.html.twig', array(
            'personne' => $personne,
            'delete_form' => $deleteForm->createView(),
            'etudiant' => $etudiant,
            'professionnel' => $professionnel,
            'enseignant' => $enseignant
        ));
    }

}
