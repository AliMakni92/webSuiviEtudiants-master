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
use Sari\AppBundle\Entity\Etudiant;


class LoadEtudiantData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $etudiant = new Etudiant();
        $etudiant->setNumEtudiant('20132576');
        $etudiant->setNumIne('0905037458T');
        $etudiant->setEtablissement($this->getReference('iutlensEtablissement'));
        $etudiant->setPersonne($this->getReference('alexandrePersonne'));

        $manager->persist($etudiant);
        $manager->flush();

        $this->addReference('alexandreEtudiant', $etudiant);
    }

    public function getOrder()
    {
        // the order in which fixtures will be loaded
        // the lower the number, the sooner that this fixture is loaded
        return 35;
    }
}