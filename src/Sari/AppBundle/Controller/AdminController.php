<?php

namespace Sari\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Administration controller.
 *
 * @Route("/admin")
 */
class AdminController extends Controller
{
    /**
     * @Route("/", name="admin_homepage")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $nb['utilisateur'] = $em->getRepository('SariUserBundle:Utilisateur')->count();
        $nb['personne'] = $em->getRepository('SariAppBundle:Personne')->count();

        $nb['entreprise'] = $em->getRepository('SariAppBundle:Entreprise')->count();
        $nb['professionnel'] = $em->getRepository('SariAppBundle:Professionnel')->count();

        $nb['etablissement'] = $em->getRepository('SariAppBundle:Etablissement')->count();
        $nb['enseignant'] = $em->getRepository('SariAppBundle:Enseignant')->count();
        $nb['etudiant'] = $em->getRepository('SariAppBundle:Etudiant')->count();
        $nb['stage'] = $em->getRepository('SariAppBundle:Stage')->count();
        $nb['suiviStage'] = $em->getRepository('SariAppBundle:SuiviStage')->count();

        $nb['formation'] = $em->getRepository('SariAppBundle:Formation')->count();
        $nb['inscription'] = $em->getRepository('SariAppBundle:Inscription')->count();

        return $this->render('SariAppBundle:Admin:index.html.twig', compact('nb'));
    }
}
