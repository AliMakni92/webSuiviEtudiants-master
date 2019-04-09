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
use Sari\AppBundle\Entity\Entreprise;


class LoadEntrepriseData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {

        $ent = new Entreprise();
        $ent->setRaisonSociale('Pavy company');
        $ent->setSecteurActivite('Informatique');
        $ent->setTypeEntreprise('Micro-entrepreneur');
        $ent->setEffectif('1');
        $ent->setStatutJuridique('libéral');
        $ent->setCodeNAF('');
        $ent->setSiret('818 127 607 00013');
        $ent->setUrlWeb('http://pavy.org/');

        $adresse = new Adresse();
        $adresse->setAdr('73 Rue Pierre Mendès France');
        $adresse->setComplement('');
        $adresse->setCodePostal('62232');
        $adresse->setVille('Vendin-lès-béthune');
        $adresse->setPays('France');
        $adresse->setTelPort('0652227305');
        $ent->setAdresse($adresse);


        $ent2 = new Entreprise();
        $ent2->setRaisonSociale('Unknown Corporation');
        $ent2->setSecteurActivite('Informatique');
        $ent2->setTypeEntreprise('SARL');
        $ent2->setEffectif('2500');
        $ent2->setStatutJuridique('StatuJuridique');
        $ent2->setCodeNAF('123');
        $ent2->setSiret('818 xxx xxx xxxx');
        $ent2->setUrlWeb('http://unkown-entreprise.fr/');

        $adresse2 = new Adresse();
        $adresse2->setAdr('Rue de l\'entreprise');
        $adresse2->setComplement('Bâtiment C');
        $adresse2->setCodePostal('62300');
        $adresse2->setVille('Lens');
        $adresse2->setPays('France');
        $adresse2->setTelPort('06.00.00.00.00');
        $ent2->setAdresse($adresse2);

        $manager->persist($ent);
        $manager->persist($ent2);
        $manager->flush();

        $this->addReference('pavyEntreprise', $ent);
        $this->addReference('unknownEntreprise', $ent2);
    }

    public function getOrder()
    {
        // the order in which fixtures will be loaded
        // the lower the number, the sooner that this fixture is loaded
        return 15;
    }
}