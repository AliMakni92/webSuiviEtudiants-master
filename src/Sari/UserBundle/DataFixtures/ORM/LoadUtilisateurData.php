<?php
/**
 * Created by PhpStorm.
 * User: Alexandre Pavy
 * Date: 03/01/2016
 * Time: 04:40
 */

namespace Sari\UtilisateursBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Sari\UserBundle\Entity\Utilisateur;

class LoadUtilisateurData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Création de données Utilisateurs
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $admin = new Utilisateur();
        $admin->setUsername('admin');
        $admin->setEmail('admin@email.fr');
        $admin->setEnabled(1);
        $admin->setSuperAdmin(true);
        $admin->setPlainPassword('admin');
        $manager->persist($admin);

        $alexandre = new Utilisateur();
        $alexandre->setUsername('alexandre_pavy');
        $alexandre->setEmail('pavy.alexandre@gmail.com');
        $alexandre->setEnabled(1);
        $alexandre->addRole('ROLE_ADMIN');
        $alexandre->setPersonne($this->getReference('alexandrePersonne'));
        $alexandre->setPlainPassword('alexandre');
        $manager->persist($alexandre);

        $utilisateur = new Utilisateur();
        $utilisateur->setUsername('user');
        $utilisateur->setEmail('utilisateur@gmail.com');
        $utilisateur->setEnabled(1);
        $utilisateur->setPersonne($this->getReference('utilisateurPersonne'));
        $utilisateur->setPlainPassword('user');
        $manager->persist($utilisateur);

        /*
            for ($i = 0; $i < 20; $i++) {
            $user = new Utilisateur();
            $user->setUsername('user' . $i);
            $user->setEmail('user' . $i . '@email.fr');
            $user->setPassword('salut');
            $user->setEnabled(1);
            //$user->addRole('ETUDIANTS');
            //$user->setPersonne($this->getReference('dupontPersonne'));
            $user->setPlainPassword('user');
            $manager->persist($user);
        }
        */
        $manager->flush();
    }

    public function getOrder()
    {
        // the order in which fixtures will be loaded
        // the lower the number, the sooner that this fixture is loaded
        return 10;
    }
}