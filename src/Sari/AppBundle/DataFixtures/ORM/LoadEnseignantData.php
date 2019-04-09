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
use Sari\AppBundle\Entity\Enseignant;
use Sari\AppBundle\Entity\Etablissement;


class LoadEnseignantData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $enseignant = new Enseignant();
        $enseignant->setStatut('Enseignant');
        $enseignant->setPersonne($this->getReference('alexandrePersonne'));
        $enseignant->addEtablissement($this->getReference('iutlensEtablissement'));
        $enseignant->addEtablissement($this->getReference('iutbethuneEtablissement'));

        $manager->persist($enseignant);
        $manager->flush();

        $this->addReference('alexandreEnseignant', $enseignant);
    }

    public function getOrder()
    {
        // the order in which fixtures will be loaded
        // the lower the number, the sooner that this fixture is loaded
        return 25;
    }
}