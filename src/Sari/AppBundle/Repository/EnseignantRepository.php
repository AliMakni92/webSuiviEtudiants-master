<?php

namespace Sari\AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * EnseignantRepository
 */
class EnseignantRepository extends EntityRepository
{
    /**
     * Compte le nombre de résultat dans la table
     * @return mixed
     */
    public function count()
    {
        return $this->createQueryBuilder('e')->select('COUNT(e)')->getQuery()->getSingleScalarResult();
    }
}
