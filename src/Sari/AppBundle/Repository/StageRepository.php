<?php

namespace Sari\AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * StageRepository
 */
class StageRepository extends EntityRepository
{
    /**
     * Compte le nombre de résultat dans la table
     * @return mixed
     */
    public function count()
    {
        return $this->createQueryBuilder('s')->select('COUNT(s)')->getQuery()->getSingleScalarResult();
    }
}
