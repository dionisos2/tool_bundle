<?php

namespace Ukratio\ToolBundle\Tests\Service;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Ukratio\ToolBundle\Service\ArrayHandling as ArrayHandling;

class_alias("Ukratio\ToolBundle\Service\ArrayHandling", "ArrayHandling");


class Graph
{
    public $name;
    private $graphs;

    public function __construct($name)
    {
        $this->graphs = array();
        $this->name = $name;
    }

    public function getGraphs()
    {
        return $this->graphs;
    }

    public function addGraph(Graph $graph)
    {
        $this->graphs[] = $graph;
    }
}

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

        $array = $this->basicArray();

        $planeArray = $this->ah->getValuesRecursively($array);

        $this->assertEquals(array('A', 'B', 'CA', 'CB', 'CCA', 'CCB', 'CD', 'D', 'EA', 'EB'), $planeArray);

        $planeArray = $this->ah->getValuesRecursively($array, null, 1);

        $this->assertEquals(array('CA', 'CB', 'CCA', 'CCB', 'CD', 'EA', 'EB'), $planeArray);

        $planeArray = $this->ah->getValuesRecursively($array, null, 2);

        $this->assertEquals(array('CCA', 'CCB'), $planeArray);

        $planeArray = $this->ah->getValuesRecursively($array, null, 3);

        $this->assertEquals(array(), $planeArray);
	}

    public function getCyclicGraphs()
    {
        return array(array(array($this->cyclicGraph1())),
                     array(array($this->cyclicGraph2())));
    }

    /**
     * @covers ArrayHandling::getValuesRecursively
     * @dataProvider getCyclicGraphs
     * @expectedException \OutOfRangeException
     */
    public function testGetValuesRecursivelyWithCycle($array)
    {
        $closure = $this->getClosure();
        $this->ah->getValuesRecursively($array, $closure);
    }

    /**
     * @covers ArrayHandling::getValuesRecursively
     */
    public function testHasTrueCycle()
    {
        $closure = $this->getClosure();

        $cyclicGraph = array($this->cyclicGraph2());
        $this->assertTrue($this->ah->hasTrueCycle($cyclicGraph, $closure));

        $cyclicGraph = array($this->cyclicGraph2());
        $this->assertTrue($this->ah->hasTrueCycle($cyclicGraph, $closure));

        $noCyclicGraph = array($this->noCyclicGraph1());
        $this->assertFalse($this->ah->hasTrueCycle($noCyclicGraph, $closure));

        $noCyclicGraph = array($this->noCyclicGraph2());
        $this->assertFalse($this->ah->hasTrueCycle($noCyclicGraph, $closure));

    }

    private function getClosure()
    {
        $closure = function (Graph $graph)
        {
            return $graph->getGraphs();
        };

        return $closure;
    }


    private function noCyclicGraph1()
    {
        $graph1 = new Graph('graph1');

        return $graph1;
    }

    private function noCyclicGraph2()
    {
        $graphA = new Graph('graphA_Nc');
        $graphB = new Graph('graphB');
        $graphB_ = new Graph('graphB_');
        $graphC = new Graph('graphC');

        $graphA2 = new Graph('graphA2');
        $graphB2 = new Graph('graphB2');
        $graphC2 = new Graph('graphC2');

        $graphA3 = new Graph('graphA3');
        $graphB3 = new Graph('graphB3');
        $graphC3 = new Graph('graphC3');

        $graphA->addGraph($graphB);
        $graphB_->addGraph($graphB);
        $graphB->addGraph($graphC);

        $graphB->addGraph($graphA2);
        $graphA2->addGraph($graphB2);
        $graphB2->addGraph($graphC2);

        $graphA2->addGraph($graphA3);
        $graphA2->addGraph($graphB3);
        $graphA3->addGraph($graphC3);
        $graphB3->addGraph($graphC3);

        return $graphA;
    }

    private function cyclicGraph1()
    {
        $graph1 = new Graph('graph1');
        $graph1->addGraph($graph1);

        return $graph1;
    }

    private function cyclicGraph2()
    {
        $graphA = new Graph('graphA');
        $graphB = new Graph('graphB');
        $graphB_ = new Graph('graphB_');
        $graphC = new Graph('graphC');

        $graphA2 = new Graph('graphA2');
        $graphB2 = new Graph('graphB2');
        $graphC2 = new Graph('graphC2');

        $graphA3 = new Graph('graphA3');
        $graphB3 = new Graph('graphB3');
        $graphC3 = new Graph('graphC3');

        $graphA->addGraph($graphB);
        $graphB->addGraph($graphC);
        $graphB->addGraph($graphB_);
        $graphC->addGraph($graphA);

        $graphA->addGraph($graphA2);
        $graphA2->addGraph($graphB2);
        $graphB2->addGraph($graphC2);
        $graphC2->addGraph($graphA2);

        $graphB->addGraph($graphA3);
        $graphA3->addGraph($graphB3);
        $graphB3->addGraph($graphC3);
        $graphC3->addGraph($graphA3);

        return $graphA;
    }

    private function basicArray()
    {
        return array('A', 'B', array('CA', 'CB', array('CCA', 'CCB'), 'CD'), 'D', array('EA','EB'));
    }
}