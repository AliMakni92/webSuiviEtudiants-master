<?php
/**
 * Created by PhpStorm.
 * User: Alexandre Pavy
 * Date: 03/01/2016
 * Time: 04:40
 */

namespace Sari\ApplicationBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Sari\AppBundle\Entity\Adresse;
use Sari\AppBundle\Entity\Etablissement;
use Sari\AppBundle\Entity\Formation;
use Sari\AppBundle\Entity\Inscription;

class LoadInscriptionData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $inscription = new Inscription();
        $inscription->setAnneeInscription("2014-2015");
        $inscription->setEtudiant($this->getReference('alexandreEtudiant'));
        $inscription->setFormation($this->getReference('informatiqueFormation'));
        $inscription->setResultat('14');

        $inscription2 = new Inscription();
        $inscription2->setAnneeInscription("2015-2016");
        $inscription2->setEtudiant($this->getReference('alexandreEtudiant'));
        $inscription2->setFormation($this->getReference('sariFormation'));
        $inscription2->setResultat('14');

        $manager->persist($inscription);
        $manager->persist($inscription2);
        $manager->flush();

    }

    public function getOrder()
    {
        // the order in which fixtures will be loaded
        // the lower the number, the sooner that this fixture is loaded
        return 45;
    }
}