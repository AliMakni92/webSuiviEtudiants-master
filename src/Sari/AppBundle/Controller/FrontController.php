<?php

namespace Sari\AppBundle\Controller;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Sari\AppBundle\Entity\Personne;
use Sari\AppBundle\Entity\Etablissement;
use Sari\AppBundle\Entity\Etudiant;
use Sari\AppBundle\Entity\Professionnel;
use Sari\AppBundle\Entity\Enseignant;
use Sari\AppBundle\Form\AdresseType;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class FrontController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        return $this->render('SariAppBundle:Front:index.html.twig');
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contactAction()
    {
        return $this->render('SariAppBundle:Front/pages:contact.html.twig');
    }

    /**
     * @Route("/information", name="information")
     */
    public function informationAction()
    {
        return $this->render('SariAppBundle:Front/pages:information.html.twig');
    }

    /**
     * @Route("/changeType", name="change_type")
     */
    public function profilAction(Request $request)
    {

        $user = $this->getUser();
        $personne = $user->getPersonne();

        $etudiant = $this->getDoctrine()->getRepository('SariAppBundle:Etudiant')->findOneBy(['personne' => $personne->getId()]);
        $professionnel = $this->getDoctrine()->getRepository('SariAppBundle:Professionnel')->findOneBy(['personne' => $personne->getId()]);
        $enseignant = $this->getDoctrine()->getRepository('SariAppBundle:Enseignant')->findOneBy(['personne' => $personne->getId()]);
        if ($personne)
            return $this->render('SariAppBundle:Front/pages:profil_content.html.twig', array(
                'personne' => $personne,
                'etudiant' => $etudiant,
                'professionnel' => $professionnel,
                'enseignant' => $enseignant
            ));
        else
            return $this->redirectToRoute('fos_user_profile_edit', array('user' => $user));

    }

    /**
     * @Route("/changeTypeEtudiant", name="sari_create_etudiant")
     * @Method({"GET", "POST"})
     */
    public function profilEtudiantAction(Request $request)
    {
        $etudiant = new Etudiant();
        $form = $this->createFormBuilder($etudiant)
            ->add('etablissement', EntityType::class, [
                'class' => 'SariAppBundle:Etablissement',
                'choice_label' => function ($etablissement) {
                    return $etablissement->getNom();
                },
                'required' => false
            ])
            ->add('NumIne', TextType::class)
            ->add('NumEtudiant', TextType::class)
            ->add('save', 'submit', array('label' => "Création de votre profil"))
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $personne = $user->getPersonne();
            $etudiant->setPersonne($personne);
            $em = $this->getDoctrine()->getManager();
            $em->persist($etudiant);
            $em->flush();
            return $this->render('SariAppBundle:Front:index.html.twig');
        }
        return $this->render('SariAppBundle:Front/pages/profil:profil_etudiant.html.twig', array(

            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/changeTypeEnseignant", name="sari_create_enseignant")
     * @Method({"GET", "POST"})
     */
    public function profilEnseignantAction(Request $request)
    {
        $enseignant = new Enseignant();
        $form = $this->createFormBuilder($enseignant)
            ->add('etablissements', EntityType::class, array(
                'required' => false,
                'multiple' => true,
                'class' => 'SariAppBundle:Etablissement',
                'choice_label' => function ($etablissement) {
                    return $etablissement->getNom() . ' à ' . $etablissement->getAdresse()->getVille();
                }))
            ->add('statut')
            ->add('save', 'submit', array('label' => "Création de votre profil"))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $personne = $user->getPersonne();
            $enseignant->setPersonne($personne);
            $em = $this->getDoctrine()->getManager();
            $em->persist($enseignant);
            $em->flush();
            return $this->render('SariAppBundle:Front:index.html.twig');
        }
        return $this->render('SariAppBundle:Front/pages/profil:profil_enseignant.html.twig', array(

            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/changeTypeProfessionnel", name="sari_create_professionnel")
     * @Method({"GET", "POST"})
     */
    public function profilProfessionnelAction(Request $request)
    {
        $pro = new Professionnel();
        $form = $this->createFormBuilder($pro)
            ->add('poste')
            ->add('service')
            ->add('entreprise', 'entity', array(
                'class' => 'SariAppBundle:Entreprise',
                'choice_label' => function ($entreprise) {
                    return $entreprise->getRaisonSociale();
                }
            ))
            ->add('adrProfessionnel', AdresseType::class, ['data_class' => 'Sari\AppBundle\Entity\Adresse', 'label' => 'Adresse professionnelle'])
            ->add('save', 'submit', array('label' => "Création de votre profil"))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $personne = $user->getPersonne();
            $pro->setPersonne($personne);
            $em = $this->getDoctrine()->getManager();
            $em->persist($pro);
            $em->flush();
            return $this->render('SariAppBundle:Front:index.html.twig');
        }
        return $this->render('SariAppBundle:Front/pages/profil:profil_professionnel.html.twig', array(

            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/showType", name="show_type")
     */
    public function showAction(Request $request)
    {

        $user = $this->getUser();
        $personne = $user->getPersonne();

        $etudiant = $this->getDoctrine()->getRepository('SariAppBundle:Etudiant')->findOneBy(['personne' => $personne->getId()]);
        $professionnel = $this->getDoctrine()->getRepository('SariAppBundle:Professionnel')->findOneBy(['personne' => $personne->getId()]);
        $enseignant = $this->getDoctrine()->getRepository('SariAppBundle:Enseignant')->findOneBy(['personne' => $personne->getId()]);
        if ($personne)
            return $this->render('SariAppBundle:Front/pages:show_content.html.twig', array(
                'personne' => $personne,
                'etudiant' => $etudiant,
                'professionnel' => $professionnel,
                'enseignant' => $enseignant
            ));
        else
            return $this->redirectToRoute('fos_user_profile_edit', array('user' => $user));

    }

    /**
     * @Route("/showTypeEtudiant/{id}", name="sari_show_etudiant")
     * @Method({"GET", "POST"})
     */
    public function showEtudiantAction(Personne $personne)
    {
        $etudiant = $this->getDoctrine()->getRepository('SariAppBundle:Etudiant')->findOneBy(['personne' => $personne->getId()]);
        return $this->render('SariAppBundle:Front/pages/show:show_etudiant.html.twig', array('etudiant' => $etudiant));

    }

    /**
     * @Route("/showTypeEnseignant/{id}", name="sari_show_enseignant")
     * @Method({"GET", "POST"})
     */
    public function showEnseignantAction(Personne $personne)
    {
        $enseignant = $this->getDoctrine()->getRepository('SariAppBundle:Enseignant')->findOneBy(['personne' => $personne->getId()]);
        return $this->render('SariAppBundle:Front/pages/show:show_enseignant.html.twig', array(
            'enseignant' => $enseignant
        ));
    }

    /**
     * @Route("/showTypeProfessionnel/{id}", name="sari_show_professionnel")
     * @Method({"GET", "POST"})
     * @param Professionnel $professionnel
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showProfessionnelAction(Personne $personne)
    {
        $pro = $this->getDoctrine()->getRepository('SariAppBundle:Professionnel')->findOneBy(['personne' => $personne->getId()]);
        return $this->render('SariAppBundle:Front/pages/show:show_professionnel.html.twig', array(
            'professionnel' => $pro
        ));
    }

    /**
     * @Route("/showTypePersonne/{id}", name="sari_show_personne")
     * @Method({"GET", "POST"})
     */
    public function showPersonneAction(Personne $personne)
    {
        return $this->render('SariAppBundle:Front/pages/show:show_personne.html.twig', array(
            'personne' => $personne
        ));
    }


    /**
     * @Route("/editType", name="edit_type")
     */
    public
    function editAction(Request $request)
    {

        $user = $this->getUser();
        $personne = $user->getPersonne();

        $etudiant = $this->getDoctrine()->getRepository('SariAppBundle:Etudiant')->findOneBy(['personne' => $personne->getId()]);
        $professionnel = $this->getDoctrine()->getRepository('SariAppBundle:Professionnel')->findOneBy(['personne' => $personne->getId()]);
        $enseignant = $this->getDoctrine()->getRepository('SariAppBundle:Enseignant')->findOneBy(['personne' => $personne->getId()]);
        if ($personne)
            return $this->render('SariAppBundle:Front/pages:edit_content.html.twig', array(
                'personne' => $personne,
                'etudiant' => $etudiant,
                'professionnel' => $professionnel,
                'enseignant' => $enseignant
            ));
        else
            return $this->redirectToRoute('fos_user_profile_edit', array('user' => $user));

    }

    /**
     * @Route("/editTypeEtudiant/{id}", name="sari_edit_etudiant")
     * @Method({"GET", "POST"})
     */
    public
    function editEtudiantAction(Request $request, Etudiant $etudiant)
    {

        $form = $this->createFormBuilder($etudiant)
            ->add('etablissement', EntityType::class, [
                'class' => 'SariAppBundle:Etablissement',
                'choice_label' => function ($etablissement) {
                    return $etablissement->getNom();
                },
                'required' => false
            ])
            ->add('NumIne', TextType::class)
            ->add('NumEtudiant', TextType::class)
            ->add('save', 'submit', array('label' => "Editer votre profil"))
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($etudiant);
            $em->flush();
            return $this->render('SariAppBundle:Front:index.html.twig');
        }
        return $this->render('SariAppBundle:Front/pages/edit:edit_etudiant.html.twig', array(

            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/editTypeEnseignant/{id}", name="sari_edit_enseignant")
     * @Method({"GET", "POST"})
     */
    public
    function editEnseignantAction(Request $request, Enseignant $enseignant)
    {

        $form = $this->createFormBuilder($enseignant)
            ->add('etablissements', EntityType::class, array(
                'required' => false,
                'multiple' => true,
                'class' => 'SariAppBundle:Etablissement',
                'choice_label' => function ($etablissement) {
                    return $etablissement->getNom() . ' à ' . $etablissement->getAdresse()->getVille();
                }))
            ->add('statut')
            ->add('save', 'submit', array('label' => "Editer votre profil"))
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($enseignant);
            $em->flush();
            return $this->render('SariAppBundle:Front:index.html.twig');
        }
        return $this->render('SariAppBundle:Front/pages/edit:edit_enseignant.html.twig', array(

            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/editTypeProfessionnel/{id}", name="sari_edit_professionnel")
     * @Method({"GET", "POST"})
     */
    public
    function editProfessionnelAction(Request $request, Professionnel $Professionnel)
    {

        $form = $this->createFormBuilder($Professionnel)
            ->add('poste')
            ->add('service')
            ->add('entreprise', 'entity', array(
                'class' => 'SariAppBundle:Entreprise',
                'choice_label' => function ($entreprise) {
                    return $entreprise->getRaisonSociale();
                }
            ))
            ->add('adrProfessionnel', AdresseType::class, ['data_class' => 'Sari\AppBundle\Entity\Adresse', 'label' => 'Adresse professionnelle'])
            ->add('save', 'submit', array('label' => "Editer votre profil"))
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($Professionnel);
            $em->flush();
            return $this->render('SariAppBundle:Front:index.html.twig');
        }
        return $this->render('SariAppBundle:Front/pages/edit:edit_Professionnel.html.twig', array(

            'form' => $form->createView(),
        ));
    }

}
