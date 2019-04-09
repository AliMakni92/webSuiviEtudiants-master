<?php

namespace Sari\AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * SuiviStageRepository
 */
class SuiviStageRepository extends EntityRepository
{
    /**
     * Compte le nombre de résultat dans la table
     * @return mixed
     */
    public function count()
    {
        return $this->createQueryBuilder('p')->select('COUNT(p)')->getQuery()->getSingleScalarResult();
    }
}
