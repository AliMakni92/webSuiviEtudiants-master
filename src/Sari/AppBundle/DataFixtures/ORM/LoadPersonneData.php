<?php
/**
 * Created by PhpStorm.
 * User: Alexandre Pavy
 * Date: 03/01/2016
 * Time: 04:40
 */

namespace Sari\ApplicationBundle\DataFixtures\ORM;


use DateTime;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Sari\AppBundle\Entity\Adresse;
use Sari\AppBundle\Entity\Personne;


class LoadPersonneData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $alexandre = new Personne();
        $alexandre->setNom('PAVY');
        $alexandre->setPrenom('Alexandre');
        $alexandre->setSexe('M');
        $alexandre->setDateNaissance(new DateTime('11-07-1994'));
        $alexandre->setPhotoName('56d730703b61a.jpg');
        $adresse = new Adresse();
        $adresse->setAdr('73 Rue Pierre Mendès France');
        $adresse->setCodePostal('62232');
        $adresse->setVille('Vendin-lès-béthune');
        $adresse->setPays('France');
        $adresse->setTelPort('0652227305');
        $alexandre->setAdrPersonnel($adresse);
        $manager->persist($alexandre);

        $utilisateur = new Personne();
        $utilisateur->setNom('Unknown');
        $utilisateur->setPrenom('Utilisateur');
        $utilisateur->setSexe('F');
        $utilisateur->setDateNaissance(new DateTime('01-01-1980'));
        $manager->persist($utilisateur);

        /*
        for ($i = 0; $i < 250; $i++) {
            $personne = new Personne();
            $personne->setNom('nom' . $i);
            $personne->setPrenom('prénom' . $i);
            $personne->setDateNaissance(new DateTime('11-5-1990'));
            $personne->setSexe('M');
            $manager->persist($personne);
        }
        */

        $manager->flush();
        $this->addReference('alexandrePersonne', $alexandre);
        $this->addReference('utilisateurPersonne', $utilisateur);
    }

    public function getOrder()
    {
        // the order in which fixtures will be loaded
        // the lower the number, the sooner that this fixture is loaded
        return 5;
    }
}