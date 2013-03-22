<?php

namespace Ukratio\ToolBundle\Service;


/**
 * Assert type of variable or value of expression and throw exception when needed.
 *
 * @api
 */ 
class AssertData
{

    /**
     * Throw a DomainException with message $message, if $bool is false.
     *
     * @param boolean $bool the tested variable.
     * @param string $message specifie the message of the exception.
     *
     * @return void
     */
    public function assertTrue($bool, $message = "")
    {
        $this->assertBool($bool, 1);
        $this->assertString($message, 2);

        if (!$bool) {
            throw new \DomainException($message);
        }
    }

    public function assertString($x, $index = 0, $acceptNull = false)
    {
        $this->assertType("String", is_string($x), $x, $index, $acceptNull);
    }

    public function assertInt($x, $index = 0, $acceptNull = false)
    {
        $this->assertType("Int", is_int($x), $x, $index, $acceptNull);
    }

    public function assertBool($x, $index = 0, $acceptNull = false)
    {
        $this->assertType("Bool", is_bool($x), $x, $index, $acceptNull);
    }

    public function assertFloat($x, $index = 0, $acceptNull = false)
    {
        $this->assertType("Float", is_float($x) , $x, $index, $acceptNull);
    }

    public function assertFloatOrInt($x, $index = 0, $acceptNull = false)
    {
        $this->assertType("FloatOrInt", is_float($x) || is_int($x) , $x, $index, $acceptNull);
    }

    public function assertArray($x, $index = 0, $acceptNull = false)
    {
        $this->assertType("Array", is_array($x) , $x, $index, $acceptNull);
    }

    /**
     * throw a InvalidArgumentException if $x is not a $type.
     *
     * You can specify the $index argument to indicate what is, the calling function argument, being asserted.
     * If $acceptNull is true, will accept null in addition to the $type type.
     *
     * @param string $type the expected type
     * @param boolean $typeValid must specifie if what we get is of the expected type
     * @param mixed $x the variable being checked
     * @param integer $index additionnal info for the throw exception
     * @param boolean $acceptNull doesn’t throw exception if it’s true
     *
     * @return void
     */ 
    protected function assertType($type, $typeValid, $x, $index = 0, $acceptNull = false)
    {

        if (!is_int($index)) {
            throw new \InvalidArgumentException("$type expected in 2th argument in assert$type");
        }

        if (!is_bool($acceptNull)) {
            throw new \InvalidArgumentException("bool expected in 3th argument in assert$type");
        }

        if ($acceptNull) {
            $msgAdd = "or null";
        } else {
            $msgAdd = "";
        }
        
        if ((!$typeValid) and (($x !== null) or (!$acceptNull))) {
            if ($index != 0) {
                throw new \InvalidArgumentException("$type $msgAdd expected in " . $index ."th argument, " . gettype($x) . " found");
            } else {
                throw new \InvalidArgumentException("$type $msgAdd expected, " . gettype($x) . " found");
            }
        }
    }
}


