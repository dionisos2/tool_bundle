<?php


/**
 * Assert type of variable and throw exception
 *
 * @api
 */ 
class AssertDataType
{

    public function AssertString($x, $index = 0, $acceptNull = false)
    {
        $this->AssertType("string", $x, $index, $acceptNull);
    }

    public function AssertInt($x, $index = 0, $acceptNull = false)
    {
        $this>AssertType("int", $x, $index, $acceptNull);
    }

    public function AssertBool($x, $index = 0, $acceptNull = false)
    {
        $this->AssertType("bool", $x, $index, $acceptNull);
    }

    public function AssertFloat($x, $index = 0, $acceptNull = false)
    {
        $this->AssertType("float", $x, $index, $acceptNull);
    }

    /**
     * throw a InvalidArgumentException if $x is not a $type.
     *
     * You can specify the $index argument to indicate what is, the calling function argument, being asserted.
     * If $acceptNull is true, will accept null in addition to the $type type.
     *
     * @param string $type the expected type
     * @param mixed $x the variable being checked
     * @param integer $index additionnal info for the throw exception
     * @param boolean $acceptNull doesn’t throw exception if it’s true
     *
     * @return void
     */ 
    protected function AssertType($type, $x, $index = 0, $acceptNull = false)
    {
        if(!is_int($index)) {
            throw new InvalidArgumentException("$type expected in 2th argument in Assert$type");
        }

        if($acceptNull) {
            $msgAdd = "or null";
        } else {
            $msgAdd = "";
        }

        switch ($type) {
            case "string":
                $isType = "is_string";
                break;
            case "int":
                $isType = "is_int";
                break;
            case "bool":
                $isType = "is_bool";
                break;
            case "float":
                $isType = "isFloatOrInt";
                break;
            default:
                throw InvalidArgumentException("\$type have to be int or string, $type found");
        }
        
        if ((!$isType($x)) and (($x !== null) or (!$acceptNull))) {
            if($index != 0) {
                throw new InvalidArgumentException("$type $msgAdd expected in " . $index ."th argument, " . gettype($x) . " found");
            } else {
                throw new InvalidArgumentException("$type $msgAdd expected, " . gettype($x) . " found");
            }
        }
    }
}

/**
 * Just a utility function
 */ 
function isFloatOrInt($x)
{
    return (is_float($x) || is_int($x));
}
