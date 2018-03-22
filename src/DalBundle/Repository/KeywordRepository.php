<?php

namespace DalBundle\Repository;

/**
 * KeywordRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class KeywordRepository extends \Doctrine\ORM\EntityRepository
{
    public function findByLibelle($search)
    {
        $query = $this->createQueryBuilder('k')
            ->select('k.id, k.libelle AS text')
            ->where('k.libelle LIKE :search')
            ->setParameter('search', $search . '%')
            ->orderBy('k.libelle', 'ASC');
        return $query->getQuery()->getResult();

    }
}
