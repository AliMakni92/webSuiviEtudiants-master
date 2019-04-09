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
use Sari\AppBundle\Entity\Stage;


class LoadStageData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $stage = new Stage();
        $stage->setEtudiant($this->getReference('alexandreEtudiant'));
        $stage->setEntreprise($this->getReference('pavyEntreprise'));
        $stage->setEnseignant($this->getReference('alexandreEnseignant'));
        $stage->setProfessionnel($this->getReference('alexandrePro'));
        $stage->setDateDebut(new \DateTime('07-03-2016 08:30:00'));
        $stage->setDateFin(new \DateTime('24-06-2016 17:30:00'));
        $stage->setDateSoutenance(new \DateTime('30-06-2016 13:30:00'));
        $stage->setSujet('Developpement application windev');
        $stage->setProjet('Projet création notation');
        $stage->setDescription('Développement d\'une application au sein de l\'équipe informatique');
        $stage->setFonction('Développeur');
        $stage->setNoteProjet('19');
        $stage->setNoteRapport('19');
        $stage->setNoteSoutenance('20');
        $stage->setNoteTravail('19');


        $manager->persist($stage);
        $manager->flush();

        $this->addReference('alexandreStage', $stage);
    }

    public function getOrder()
    {
        // the order in which fixtures will be loaded
        // the lower the number, the sooner that this fixture is loaded
        return 40;
    }
}