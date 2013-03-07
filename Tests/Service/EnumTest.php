<?php

namespace Eud\ToolBundle\Tests\Service;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Eud\ToolBundle\Service\Enum;

class_alias('Eud\ToolBundle\Service\Enum', 'Enum');

Enum::enum('type_a', array('a1', 'a2', 'a3'));
Enum::enum('type_b', array('b1', 'b2', 'b3'));
Enum::enum('type_a2', array('a1', 'a2', 'a3'));

Enum::enum('typeWithValue', array('a1' => 'value1','a2' => 'value1','a3' => 'value2', 'number' => 10, 'float' => pow(10,-3)));


class EnumTest extends \PHPUnit_Framework_TestCase
{
	protected function setUp()
	{
		$this->ta_a2 = \type_a::$a2;
		$this->tb_b2 = \type_b::$b2;
		$this->tb_b3 = \type_b::$b3;
        $this->ta2_a2 = \type_a2::$a2;
	}

    /**
     * @covers Enum::getValue
     */
    public function testGetValue()
    {
        $this->assertEquals('value1', \typeWithValue::$a1->getValue());
        $this->assertEquals('value1', \typeWithValue::$a2->getValue());
        $this->assertEquals('value2', \typeWithValue::$a3->getValue());
        $this->assertTrue(10 === \typeWithValue::$number->getValue());
        $this->assertEquals(0.001, \typeWithValue::$float->getValue(), null, 0.000001);
    }

    /**
     * @covers Enum::enum
     * @covers Enum::getValue
	 * @expectedException InvalidArgumentException
     */
    public function testEnumWithWrongValue()
    {
        Enum::enum('enumName', array('a1' => 1, 'a2' => array()));
    }

    /**
     * @covers Enum::getListOfElement
     */
    public function testGetListOfElement()
    {
        $this->assertEquals(array('a1', 'a2', 'a3'), \type_a::getListOfElement());
        $this->assertEquals(array('b1', 'b2', 'b3'), \type_b::getListOfElement());
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
        $this->assertEquals(\type_a::$a2, \type_a::getEnumerator('a2'));
        $this->assertEquals(\type_b::$b1, \type_b::getEnumerator('b1'));
        $this->assertEquals(\type_b::$b3, \type_b::getEnumerator('b3'));
        $this->assertEquals(null, \type_a::getEnumerator('dont_exist'));
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
        Enum::enum('enumName', array('a1', 'a2'));
    }

    /**
     * @covers Enum::enum
	 * @expectedException InvalidArgumentException
	 */
    public function testEnumWithWrongName()
    {
        Enum::enum(10, array('a1', 'a2'));
    }

    /**
     * @covers Enum::enum
	 * @expectedException InvalidArgumentException
	 */
    public function testEnumWithWrongTypeElement()
    {
        Enum::enum('enumName', array('a1', 'a2', 10));
    }


    /**
     * @covers Enum::getEnumerator
	 * @expectedException InvalidArgumentException
	 */
    public function testGetEnumeratorWrongArgument()
    {
        \type_a::getEnumerator(10);
    }

    /**
     * @coversNothing
     */
	public function testStrictComparaison()
	{
		$this->assertTrue(\type_a::$a1 !== \type_a::$a2);
		$this->assertTrue($this->ta_a2 === \type_a::$a2);
		$this->assertTrue($this->ta_a2 !== \type_a::$a3);
		$this->assertTrue($this->ta_a2 !== $this->ta2_a2);
	}

    /**
     * @covers Enum::__toString
     */
	public function test__toString()
	{
		$this->assertEquals('type_a:a2:1', (string)$this->ta_a2);
		$this->assertEquals('type_b:b2:4', (string)$this->tb_b2);
		$this->assertEquals('type_b:b3:5', (string)$this->tb_b3);
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