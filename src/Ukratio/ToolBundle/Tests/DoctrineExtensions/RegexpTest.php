<?php

namespace Ukratio\ToolBundle\Tests\DoctrineExtensions;

use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Configuration;
use Doctrine\Common\Cache\ArrayCache;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Ukratio\ToolBundle\Entity\SimpleEntity;
use Ukratio\TrouveToutBundle\Entity\SimpleEntityRepository;

class RegexpTest extends WebTestCase
{

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;    
    private $repo;

    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();
        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getEntityManager()
        ;
        if ($this->em == null) {
            throw new Exception('problem with database test');
        }
        $this->repo = $this->em->getRepository('ToolBundle:SimpleEntity');
    }

    public function testRegexp()
    {
        $simpleEntity = $this->repo->findByRegexp('PLOP+');
        $this->assertCount(2, $simpleEntity);

        $simpleEntity = $this->repo->findByRegexp('^PLOP$');
        $this->assertCount(1, $simpleEntity);
    }

    /**
     * just to see if all are ok with the database
     */
    public function testFindAll()
    {
        $simpleEntity = $this->repo->findAll();
        $this->assertCount(6, $simpleEntity);
    }
}
