<?php

namespace Sari\AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * FormationRepository
 */
class FormationRepository extends EntityRepository
{
    /**
     * Compte le nombre de résultat dans la table
     * @return mixed
     */
    public function count()
    {
        return $this->createQueryBuilder('f')->select('COUNT(f)')->getQuery()->getSingleScalarResult();
    }
}
