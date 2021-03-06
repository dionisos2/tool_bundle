<?php

namespace Ukratio\ToolBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Ukratio\ToolBundle\DoctrineExtensions\Regexp;

/**
 * SimpleEntityRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SimpleEntityRepository extends EntityRepository
{

    public function findByRegexp($regexp)
    {
        $queryBuilder = $this->createQueryBuilder('entity')
                             ->where("REGEXP(entity.value, :regexp) = 1")
                             ->setParameter('regexp', $regexp);
        
        return $queryBuilder->getQuery()->getResult();
    }

}
