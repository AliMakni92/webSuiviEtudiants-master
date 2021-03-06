<?php

namespace Sari\AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * PersonneRepository
 */
class PersonneRepository extends EntityRepository
{
    /**
     * Compte le nombre de résultat dans la table
     * @return mixed
     */
    public function count()
    {
        return $this->createQueryBuilder('p')->select('COUNT(p)')->getQuery()->getSingleScalarResult();
    }

    /**
     * Affiche les joueurs avec le champ deletedAt
     * @return array
     */
    public function findDeleted()
    {
        return $this->createQueryBuilder('p')->select('p')->where('p.deletedAt IS NOT NULL')->orderBy('p.deletedAt', 'DESC')->getQuery();
    }

    public function search($search)
    {
        return $this->createQueryBuilder('p')->select('p')->where('LOWER(p.nom) LIKE :search OR LOWER(p.prenom) LIKE :search')
            ->setParameter('search', '%' . $search . '%')->getQuery();
    }

}
