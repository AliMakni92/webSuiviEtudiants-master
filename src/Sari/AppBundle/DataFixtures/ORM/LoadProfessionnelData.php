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
use Sari\AppBundle\Entity\Professionnel;


class LoadProfessionnelData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $pro = new Professionnel();
        $pro->setPersonne($this->getReference('alexandrePersonne'));
        $pro->setEntreprise($this->getReference('pavyEntreprise'));
        $pro->setPoste("Directeur");
        $pro->setService("Informatique");

        $manager->persist($pro);
        $manager->flush();

        $this->addReference('alexandrePro', $pro);
    }

    public function getOrder()
    {
        // the order in which fixtures will be loaded
        // the lower the number, the sooner that this fixture is loaded
        return 30;
    }
}