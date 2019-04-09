<?php

namespace Sari\AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * EtablissementRepository
 */
class EtablissementRepository extends EntityRepository
{
    /**
     * Compte le nombre de résultat dans la table
     * @return mixed
     */
    public function count()
    {
        return $this->createQueryBuilder('e')->select('COUNT(e)')->getQuery()->getSingleScalarResult();
    }

    /**
     * Affiche les joueurs avec le champ deletedAt
     * @return array
     */
    public function findDeleted()
    {
        return $this->createQueryBuilder('e')->select('e')->where('e.deletedAt IS NOT NULL')->orderBy('e.deletedAt', 'DESC')->getQuery();
    }

    public function search($search)
    {
        return $this->createQueryBuilder('e')->select('e')->where('LOWER(e.nom) LIKE :search')
            ->setParameter('search', '%' . $search . '%')->getQuery();
    }
}
