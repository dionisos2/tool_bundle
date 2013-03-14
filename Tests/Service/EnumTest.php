<?php

namespace Eud\ToolBundle\Tests\Service;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Eud\ToolBundle\Service\Enum;
use Eud\ToolBundle\Tests\Service\AutoloadEnum;


Enum::enum('type_a', array('a1', 'a2', 'a3'), 'my\name\space');
Enum::enum('type_b', array('b1', 'b2', 'b3'), 'my\name\space');
Enum::enum('type_a2', array('a1', 'a2', 'a3'), 'my\name\space');

Enum::enum('typeWithValue', array('a1' => 'value1','a2' => 'value1','a3' => 'value2', 'number' => 10, 'float' => pow(10,-3)), 'my\name\space');

class_alias('my\name\space\type_a', 'type_a', true);

class EnumTest extends \PHPUnit_Framework_TestCase
{
	protected function setUp()
	{
		$this->ta_a2 = \type_a::$a2;
		$this->tb_b2 = \my\name\space\type_b::$b2;
		$this->tb_b3 = \my\name\space\type_b::$b3;
        $this->ta2_a2 = \my\name\space\type_a2::$a2;
	}

    public function testAutoloadEnum()
    {
        $this->autoloadEnum = AutoloadEnum::$a1;
    }

    /**
     * @covers Enum::getValue
     */
    public function testGetValue()
    {
        $this->assertEquals('value1', \my\name\space\typeWithValue::$a1->getValue());
        $this->assertEquals('value1', \my\name\space\typeWithValue::$a2->getValue());
        $this->assertEquals('value2', \my\name\space\typeWithValue::$a3->getValue());
        $this->assertTrue(10 === \my\name\space\typeWithValue::$number->getValue());
        $this->assertEquals(0.001, \my\name\space\typeWithValue::$float->getValue(), null, 0.000001);
    }

    /**
     * @covers Enum::enum
     * @covers Enum::getValue
	 * @expectedException InvalidArgumentException
     */
    public function testEnumWithWrongValue()
    {
        Enum::enum('enumName', array('a1' => 1, 'a2' => array()), '\my\name\space');
    }

    /**
     * @covers Enum::getListOfElement
     */
    public function testGetListOfElement()
    {
        $this->assertEquals(array('a1', 'a2', 'a3'), \my\name\space\type_a::getListOfElement());
        $this->assertEquals(array('b1', 'b2', 'b3'), \my\name\space\type_b::getListOfElement());
    }

    /**
     * @covers Enum::getListOfElement
	 * @expectedException BadFunctionCallException
     */
    public function testGetListOfElementOnEnum()
    {
        Enum::getListOfElement();
    }

    /**
     * @covers Enum::getEnumerator
     */
    public function testGetEnumerator()
    {
        $this->assertEquals(\my\name\space\type_a::$a2, \my\name\space\type_a::getEnumerator('a2'));
        $this->assertEquals(\my\name\space\type_b::$b1, \my\name\space\type_b::getEnumerator('b1'));
        $this->assertEquals(\my\name\space\type_b::$b3, \my\name\space\type_b::getEnumerator('b3'));
        $this->assertEquals(null, \my\name\space\type_a::getEnumerator('dont_exist'));
    }

    /**
     * @covers Enum::getEnumerator
	 * @expectedException BadFunctionCallException
     */
    public function testgetEnumeratorOnEnum()
    {
        Enum::getEnumerator('plop');
    }

    /**
     * @covers Enum::__construct
     */
    public function testCreateEnum()
    {
        Enum::enum('enumName', array('a1', 'a2'), 'my\name\space');
    }

    /**
     * @covers Enum::enum
	 * @expectedException InvalidArgumentException
	 */
    public function testEnumWithWrongName()
    {
        Enum::enum(10, array('a1', 'a2'), 'my\name\space');
    }

    /**
     * @covers Enum::enum
	 * @expectedException InvalidArgumentException
	 */
    public function testEnumWithWrongTypeElement()
    {
        Enum::enum('enumName', array('a1', 'a2', 10), 'my\name\space');
    }


    /**
     * @covers Enum::getEnumerator
	 * @expectedException InvalidArgumentException
	 */
    public function testGetEnumeratorWrongArgument()
    {
        \my\name\space\type_a::getEnumerator(10);
    }

    /**
     * @coversNothing
     */
	public function testStrictComparaison()
	{
		$this->assertTrue(\my\name\space\type_a::$a1 !== \my\name\space\type_a::$a2);
		$this->assertTrue($this->ta_a2 === \my\name\space\type_a::$a2);
		$this->assertTrue($this->ta_a2 !== \my\name\space\type_a::$a3);
		$this->assertTrue($this->ta_a2 !== $this->ta2_a2);
	}

    private function withoutId($str)
    {
        $part = explode(':', $str);
        return $part[0] . ':' . $part[1];
    }

    /**
     * @covers Enum::__toString
     */
	public function test__toString()
	{
		$this->assertEquals('my\name\space\type_a:a2', $this->withoutId((string)$this->ta_a2));
		$this->assertEquals('my\name\space\type_b:b2', $this->withoutId((string)$this->tb_b2));
		$this->assertEquals('my\name\space\type_b:b3', $this->withoutId((string)$this->tb_b3));
	}
    
    /**
     * @covers Enum::getName
     */
    public function testGetName()
    {
		$this->assertEquals('a2', $this->ta_a2->getName());
    }

    /**
     * @covert Enum::getId
     */
    public function testGetId()
    {
        $this->ta_a2->getId();
    }
}