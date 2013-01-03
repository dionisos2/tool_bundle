<?php

namespace Eud\ToolBundle\Service;


/**
 * Assert type of variable and throw exception
 *
 * @api
 */ 
class AssertDataType
{

    public function AssertString($x, $index = 0, $acceptNull = false)
    {
        $this->AssertType("String", is_string($x), $x, $index, $acceptNull);
    }

    public function AssertInt($x, $index = 0, $acceptNull = false)
    {
        $this->AssertType("Int", is_int($x), $x, $index, $acceptNull);
    }

    public function AssertBool($x, $index = 0, $acceptNull = false)
    {
        $this->AssertType("Bool", is_bool($x), $x, $index, $acceptNull);
    }

    public function AssertFloat($x, $index = 0, $acceptNull = false)
    {
        $this->AssertType("Float", is_float($x) , $x, $index, $acceptNull);
    }

    public function AssertFloatOrInt($x, $index = 0, $acceptNull = false)
    {
        $this->AssertType("FloatOrInt", is_float($x) || is_int($x) , $x, $index, $acceptNull);
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
    protected function AssertType($type, $typeValid, $x, $index = 0, $acceptNull = false)
    {

        if(!is_int($index)) {
            throw new \InvalidArgumentException("$type expected in 2th argument in Assert$type");
        }

        if(!is_bool($acceptNull)) {
            throw new \InvalidArgumentException("bool expected in 3th argument in Assert$type");
        }

        if($acceptNull) {
            $msgAdd = "or null";
        } else {
            $msgAdd = "";
        }
        
        if ((!$typeValid) and (($x !== null) or (!$acceptNull))) {
            if($index != 0) {
                throw new \InvalidArgumentException("$type $msgAdd expected in " . $index ."th argument, " . gettype($x) . " found");
            } else {
                throw new \InvalidArgumentException("$type $msgAdd expected, " . gettype($x) . " found");
            }
        }
    }
}


