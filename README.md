Application Suivi des étudiants
===========

Version : 1.0.0-Beta
Version Symfony : 2.8.2

Symfony 2.8 est une version LTS (long term support). La version 2.8 sera maintenu jusqu'à novembre 2018 pour les bugs fix et fin novembre 2019 pour security update.

### Commandes utiles

* `php app/console doctrine:database:create` : Creation de la base de données (Configuration dans `app/config/parameters.yml`)
* `php app/console doctrine:database:drop --force` : supprime la base de données (Configuration dans `app/config/parameters.yml`)
* `php app/console doctrine:generate:entity` : Génère une nouvelle entitée doctrine, nouvelle table
* `php app/console doctrine:generate:entities Sari/AppBundle/Entity` : Génère les accesseurs doctrine (getters et setters)
* `php app/console doctrine:schema:update --force` : Création des tables dans la base de données
* `php app/console security:check` - Symfony provides a command to check whether your project`s dependencies contain any known security vulnerability
* `php app/console doctrine:fixtures:load` - Sauvegarde dans la base de données des fixtures
* `php app/console assets:install web` - Copie les ressources des bundle dans le dossier public web
* `php app/console assetic:dump` - Compilation des assetic
* `php app/console server:run` - Lance le serveur web interne sur http://127.0.0.1:8000
* `php app/console generate:doctrine:crud` - Generating a CRUD Controller Based on a Doctrine Entity 

#### Contact :
| Prénom    | Nom        | Rôle        | Adresse Email                        |
| --------- | ---------- | ----------- | ------------------------------------ |
| Fred      | HEMERY     | Responsable | fred.hemery@univ-artois.fr           |
| Arnaud    | MORGAN     | Développeur | arnaud_morgan@ens.univ-artois.fr     |
| Alexandre | SZYMKIW    | Développeur | alexandre_szymkiw@ens.univ-artois.fr |
| Alexandre | PAVY       | Développeur | alexandre_pavy@ens.univ-artois.fr    |