<?php

namespace Eud\ToolBundle\Tests\Service;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Eud\ToolBundle\Service\AssertData;


class AssertDataTest extends \PHPUnit_Framework_TestCase
{

	protected function setUp()
	{
        $this->ad = new AssertData();
	}

    /**
	 * @expectedException DomainException
	 */
    public function testAssertTrueWithFalse()
    {
        $this->ad->assertTrue(false);
    }

    public function testAssertTrueWithTrue()
    {
        $this->ad->assertTrue(true);
    }

    /**
	 * @expectedException InvalidArgumentException
	 */	
    public function testAssertBoolWithWrongAcceptNull()
    {
        $this->ad->assertBool(true, 0, 0);
    }

    /**
	 * @expectedException InvalidArgumentException
	 */	
    public function testAssertStringWithNullWrong()
    {
        $this->ad->assertString(null);
    }

    /**
	 * @expectedException InvalidArgumentException
	 */	
    public function testAssertStringWithNullWrong2()
    {
        $this->ad->assertString(null, 1);
    }


    public function testAssertStringWithNull()
    {
        $this->ad->assertString(null, 0, true);
    }

    /**
	 * @expectedException InvalidArgumentException
	 */
    public function testAssertStringWithWrongIndex()
    {
        $this->ad->assertString(null, "10");
    }

    /**
	 * @expectedException InvalidArgumentException
	 */	 
	public function testAssertIntWithString()
	{
        $this->ad->assertInt("10");
	}

    public function testAssertIntWithInt()
    {
        $this->ad->assertInt(10);
    }

    /**
	 * @expectedException InvalidArgumentException
	 */	 
	public function testAssertBoolWithInt()
	{
        $this->ad->assertBool(0);
	}

    public function testAssertBoolWithBool()
    {
        $this->ad->assertBool(false);
    }

    /**
	 * @expectedException InvalidArgumentException
	 */	 
	public function testAssertFloatWithString()
	{
        $this->ad->assertFloat("10");
	}

    /**
	 * @expectedException InvalidArgumentException
	 */	
	public function testAssertFloatWithInt()
	{
        $this->ad->assertFloat(10);
	}

    public function testAssertFloatWithFloat()
    {
        $this->ad->assertFloat(10.5);
    }

    /**
	 * @expectedException InvalidArgumentException
	 */	 
	public function testAssertFloatOrIntWithString()
	{
        $this->ad->assertFloatOrInt("10");
	}

	public function testAssertFloatOrIntWithInt()
	{
        $this->ad->assertFloatOrInt(10);
	}

    public function testAssertFloatOrIntWithFloat()
    {
        $this->ad->assertFloatOrInt(10.5);
    }

}