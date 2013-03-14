<?php

namespace Eud\ToolBundle\Tests\Service;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Eud\ToolBundle\Service\DataChecking as DataChecking;

class_alias("Eud\ToolBundle\Service\DataChecking", "DataChecking");

class DataCheckingTest extends \PHPUnit_Framework_TestCase
{

	protected function setUp()
	{
        $this->dt = new DataChecking();
	}

	protected function assertPreConditions()
	{
	}

    /**
     * @covers DataChecking::isFloatOrInt
     */
	public function testIsFloatOrInt()
	{
		$this->assertTrue($this->dt->isFloatOrInt(10));
		$this->assertTrue($this->dt->isFloatOrInt(10.5));
		$this->assertFalse($this->dt->isFloatOrInt("10"));
	}

    /**
     * @covers DataChecking::isNumbers
     */    
    public function testIsNumbers()
    {
        $this->assertFalse($this->dt->IsNumbers("10.5"));
        $this->assertFalse($this->dt->IsNumbers("-10"));
        $this->assertFalse($this->dt->IsNumbers(-10));
        $this->assertTrue($this->dt->IsNumbers(10));
        $this->assertTrue($this->dt->IsNumbers("10"));
    }

	/**
     * @covers DataChecking::isConvertIntoInt
	 * @depends testIsNumbers
	 */	 
	public function testIsConvertIntoInt()
	{
        $this->assertFalse($this->dt->isConvertIntoInt("10.5"));
        $this->assertFalse($this->dt->isConvertIntoInt("a10"));
        $this->assertFalse($this->dt->isConvertIntoInt("10a"));
        $this->assertFalse($this->dt->isConvertIntoInt(""));
        $this->assertFalse($this->dt->isConvertIntoInt("-"));
        $this->assertTrue($this->dt->isConvertIntoInt("10"));
        $this->assertTrue($this->dt->isConvertIntoInt("-10"));
	}

    /**
     * @covers DataChecking::keyExistsAndEqual
     */
    public function testKeyExistsAndEqual()
    {
        $a = array("a" => 10);
        $this->assertFalse($this->dt->keyExistsAndEqual($a, "b", "b"));
        $this->assertFalse($this->dt->keyExistsAndEqual($a, "b", 10));
        $this->assertFalse($this->dt->keyExistsAndEqual($a, "a", "10"));
        $this->assertTrue($this->dt->keyExistsAndEqual($a, "a", 10));
    }

    /**
     * @covers DataChecking::lastKey
     */
    public function testLastKey()
    {
        $a = array("k1" => "v1", "k2" => "v2", "k3" => "v3");
        $this->assertEquals("k3", $this->dt->lastKey($a));
    }
}