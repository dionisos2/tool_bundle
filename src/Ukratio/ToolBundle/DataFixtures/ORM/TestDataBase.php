<?php

namespace Ukratio\ToolBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Ukratio\ToolBundle\Entity\SimpleEntity;

class TestDataBase implements FixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $this->createSimpleEntity($manager);

        $manager->flush();
    }

    private function createSimpleEntity(ObjectManager $manager)
    {
        $values = array('PLOP', 'PL', 'OP', 'PLOPPLOP','AUIE','AUIEAUIE');

        foreach($values as $value)
        {
            $simpleEntity = new SimpleEntity($value);
            $manager->persist($simpleEntity);
        }
    }
}