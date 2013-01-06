<?php

namespace Eud\ToolBundle\Tests\Service;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Eud\ToolBundle\Service\AssertDataType as AssertDataType;


class AssertDataTypeTest extends \PHPUnit_Framework_TestCase
{

	protected function setUp()
	{
        $this->adt = new AssertDataType();
	}

	protected function assertPreConditions()
	{
	}

    /**
	 * @expectedException InvalidArgumentException
	 */	 
	public function testAssertStringWithInt()
	{
        $this->adt->AssertString(10);
	}

    public function testAssertStringWithString()
    {
        $this->adt->AssertString("10");
    }

    /**
	 * @expectedException InvalidArgumentException
	 */	
    public function testAssertStringWithNull()
    {
        $this->adt->AssertString(null);
    }

    public function testAssertStringWithNull2()
    {
        $this->adt->AssertString(null, 0, true);
    }

    /**
	 * @expectedException InvalidArgumentException
	 */
    public function testAssertStringWithWrongIndex()
    {
        $this->adt->AssertString(null, "10");
    }

    /**
	 * @expectedException InvalidArgumentException
	 */	 
	public function testAssertIntWithString()
	{
        $this->adt->AssertInt("10");
	}

    public function testAssertIntWithInt()
    {
        $this->adt->AssertInt(10);
    }

    /**
	 * @expectedException InvalidArgumentException
	 */	 
	public function testAssertBoolWithInt()
	{
        $this->adt->AssertBool(0);
	}

    public function testAssertBoolWithBool()
    {
        $this->adt->AssertBool(false);
    }

    /**
	 * @expectedException InvalidArgumentException
	 */	 
	public function testAssertFloatWithString()
	{
        $this->adt->AssertFloat("10");
	}

    /**
	 * @expectedException InvalidArgumentException
	 */	
	public function testAssertFloatWithInt()
	{
        $this->adt->AssertFloat(10);
	}

    public function testAssertFloatWithFloat()
    {
        $this->adt->AssertFloat(10.5);
    }

    /**
	 * @expectedException InvalidArgumentException
	 */	 
	public function testAssertFloatOrIntWithString()
	{
        $this->adt->AssertFloatOrInt("10");
	}

	public function testAssertFloatOrIntWithInt()
	{
        $this->adt->AssertFloatOrInt(10);
	}

    public function testAssertFloatOrIntWithFloat()
    {
        $this->adt->AssertFloatOrInt(10.5);
    }

}