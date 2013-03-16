<?php

namespace Ukratio\ToolBundle\Tests\Service;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Ukratio\ToolBundle\Service\ArrayHandling as ArrayHandling;

class_alias("Ukratio\ToolBundle\Service\ArrayHandling", "ArrayHandling");

class ArrayHandlingTest extends \PHPUnit_Framework_TestCase
{

	protected function setUp()
	{
        $this->ah = new ArrayHandling();
	}

    /**
     * @covers ArrayHandling::getValuesRecursively
     */
	public function testgetValuesRecursively()
	{
        $ah = $this->ah;

        $array = array('A', 'B', array('CA', 'CB', array('CCA', 'CCB'), 'CD'), 'D', array('EA','EB'));

        $planeArray = $this->ah->getValuesRecursively($array);

        $this->assertEquals(array('A', 'B', 'CA', 'CB', 'CCA', 'CCB', 'CD', 'D', 'EA', 'EB'), $planeArray);

        $planeArray = $this->ah->getValuesRecursively($array, null, 1);

        $this->assertEquals(array('CA', 'CB', 'CCA', 'CCB', 'CD', 'EA', 'EB'), $planeArray);

        $planeArray = $this->ah->getValuesRecursively($array, null, 2);

        $this->assertEquals(array('CCA', 'CCB'), $planeArray);

        $planeArray = $this->ah->getValuesRecursively($array, null, 3);

        $this->assertEquals(array(), $planeArray);
	}

}