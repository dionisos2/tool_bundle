<?php

namespace Eud\ToolBundle\Tests\Enum;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

require_once("src/Eud/ToolBundle/Service/enum.php");

enum("type_a", array("a1", "a2", "a3"));
enum("type_b", array("a1", "a2", "b3"));


class EnumTest extends \PHPUnit_Framework_TestCase
{
	protected function setUp()
	{
		$this->ta_a2 = \type_a::$a2;
		$this->tb_a2 = \type_b::$a2;
		$this->tb_b3 = \type_b::$b3;
	}

	protected function assertPreConditions()
	{
	}

	public function testStrictComparaison()
	{
		$this->assertTrue(\type_a::$a1 !== \type_a::$a2);
		$this->assertTrue($this->ta_a2 === \type_a::$a2);
		$this->assertTrue($this->ta_a2 !== \type_a::$a3);
		$this->assertTrue($this->ta_a2 !== $this->tb_a2);
	}

	public function test_To_String()
	{
		$this->assertEquals("type_a:a2:1", (string)$this->ta_a2);
		$this->assertEquals("type_b:a2:4", (string)$this->tb_a2);
		$this->assertEquals("type_b:b3:5", (string)$this->tb_b3);
	}
}