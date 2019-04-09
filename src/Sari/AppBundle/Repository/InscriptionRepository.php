<?php

namespace Sari\AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * InscriptionRepository
 */
class InscriptionRepository extends EntityRepository
{
    /**
     * Compte le nombre de résultat dans la table
     * @return mixed
     */
    public function count()
    {
        return $this->createQueryBuilder('i')->select('COUNT(i)')->getQuery()->getSingleScalarResult();
    }
}
