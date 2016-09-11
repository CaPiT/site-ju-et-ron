<?php

namespace RJSite\PlatformBundle\Repository\CV;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * ProfileRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProfileRepository extends EntityRepository
{
    public function getProfiles($page, $nbPerPage, $order='ASC')
    {
        $query = $this->createQueryBuilder('p')
            ->orderBy('p.id', $order)
            ->getQuery()
        ;
    
        $query
            ->setFirstResult(($page-1) * $nbPerPage)
            ->setMaxResults($nbPerPage)
        ;
    
        return new Paginator($query, true);
    }
}
