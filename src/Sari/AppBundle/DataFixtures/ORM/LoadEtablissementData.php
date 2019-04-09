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

class LoadEtablissementData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $etablissement = new Etablissement();
        $etablissement->setNom('IUT de Lens');
        $etablissement->setDescription('Université de lens avec plusieurs formations');
        $etablissement->setTypeEta('publique');
        $etablissement->setUrlWeb('http://www.iut-lens.univ-artois.fr/');

        $adresse = new Adresse();
        $adresse->setAdr("IUT de Lens Rue de l'université");
        $adresse->setComplement('SP 16');
        $adresse->setCodePostal('62307');
        $adresse->setVille('Lens Cedex');
        $adresse->setPays('France');
        $adresse->setTelFixe('0321793232');
        $adresse->setTelPort('');

        $etablissement->setAdresse($adresse);

        $etablissement2 = new Etablissement();
        $etablissement2->setNom('IUT de Béthune');
        $etablissement2->setDescription('Institut Universitaire de Technologie de Béthune');
        $etablissement2->setTypeEta('publique');
        $etablissement2->setUrlWeb('http://www.iutbethune.org/');

        $adresse2 = new Adresse();
        $adresse2->setAdr("1230 rue de l'Université");
        $adresse2->setComplement('CS 20819');
        $adresse2->setCodePostal('62408');
        $adresse2->setVille('Béthune Cédex');
        $adresse2->setPays('France');
        $adresse2->setTelFixe('03.21.63.23.00');
        $adresse2->setTelPort('');

        $etablissement2->setAdresse($adresse2);

        $etablissement3 = new Etablissement();
        $etablissement3->setNom('Faculté des sciences Jean Perrin');
        $etablissement3->setDescription('Faculté des sciences Jean Perrin');
        $etablissement3->setTypeEta('publique');
        $etablissement3->setUrlWeb('http://www.univ-artois.fr/L-universite/UFR-et-IUT/Sciences/Presentation/');

        $adresse3 = new Adresse();
        $adresse3->setAdr("Rue Jean Souvraz");
        $adresse3->setComplement('SP 18');
        $adresse3->setCodePostal('62307 ');
        $adresse3->setVille('Lens Cédex');
        $adresse3->setPays('France');
        $adresse3->setTelFixe('03 21 79 17 00');
        $adresse3->setTelPort('');

        $etablissement3->setAdresse($adresse3);


        $formation = new Formation();
        $formation->setLibelle('Sécurité des Applications et des Réseaux Informatique');
        $formation->setLibelleCourt('SARI');
        $formation->setDescription('Licence professionnelle');

        $formation2 = new Formation();
        $formation2->setLibelle('Informatique');
        $formation2->setLibelleCourt('INFO');
        $formation2->setDescription('Formation Informatique');

        $formation3 = new Formation();
        $formation3->setLibelle('Réseau');
        $formation3->setLibelleCourt('RX');
        $formation3->setDescription('Diplôme universitaire réseaux');

        $etablissement->addFormation($formation);
        $formation->addEtablissement($etablissement);

        $etablissement->addFormation($formation2);
        $formation2->addEtablissement($etablissement);

        $etablissement2->addFormation($formation3);
        $formation3->addEtablissement($etablissement2);

        $etablissement3->addFormation($formation2);
        $formation2->addEtablissement($etablissement3);

        $manager->persist($formation);
        $manager->persist($formation2);
        $manager->persist($formation3);
        $manager->persist($etablissement);
        $manager->persist($etablissement2);
        $manager->persist($etablissement3);
        $manager->flush();

        $this->addReference('iutlensEtablissement', $etablissement);
        $this->addReference('iutbethuneEtablissement', $etablissement2);
        $this->addReference('sariFormation', $formation);
        $this->addReference('informatiqueFormation', $formation2);
    }

    public function getOrder()
    {
        // the order in which fixtures will be loaded
        // the lower the number, the sooner that this fixture is loaded
        return 20;
    }
}