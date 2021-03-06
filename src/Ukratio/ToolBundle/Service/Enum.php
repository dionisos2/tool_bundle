<?php

namespace Ukratio\ToolBundle\Service;

/**
 * Abstract class on which are based the others enum class
 *
 * /!\ create enum in separate file for autoloading purpose /!\
 */ 
abstract class Enum
{
    
    protected static $nbrId = 0;
    protected $enumId;
    protected $enumName;
    protected $enumValue;

    public function __construct($enumName, $enumValue)
    {
        $this->enumId = self::$nbrId;
        $this->enumName = $enumName;
        $this->enumValue = $enumValue;
        Enum::$nbrId++;
    }

    public function __toString()
    {
        return get_class($this) . ":" . $this->enumName . ":" . $this->enumId;
    }
    
    public function getName()
    {
        return $this->enumName;
    }

    public function getValue()
    {
        return $this->enumValue;
    }

    public function getId()
    {
        return $this->enumId;
    }   

    public static function getEnumerator($enumName)
    {
        if (!is_string($enumName)) {
            throw new \InvalidArgumentException('the first argument $enumName, have to be a string');
        }

        if (get_called_class() === __CLASS__) {
            throw new \BadFunctionCallException('getEnumerator can’t be call from the Enum abstract class, only from child');
        }

        if (in_array($enumName, static::$listOfElements)) {
            return static::$$enumName;
        } else {
            return null;
        }
    }

    public static function getListOfElement()
    {
        if (get_called_class() === __CLASS__) {
            throw new \BadFunctionCallException('getListOfElement can’t be call from the Enum abstract class, only from child');
        }

        return static::$listOfElements;
    }

    /**
     * Create a enum class
     *
     * Enum::enum("enum_name", array("enumerator1", "enumerator2", "enumerator3"));
     * $a = enum_name::$enumerator2
     * get_class($a) === "enum_name" -> true
     * $a === enum_name::$enumerator1 -> false
     * $a === enum_name::$enumerator2 -> true
     * look at EnumTest for more info
     *
     * @api
     *
     * @return void
     *
     * @codeCoverageIgnore
     */ 
    public static function enum($name, $elements, $nameSpace)
    {
        if(!is_string($name)) {
            throw new \InvalidArgumentException('the first argument $name, have to be a string');
        }

        if (array_keys($elements) == array_keys(array_keys($elements))) {
            $elements = array_flip($elements);
        }                

        foreach ($elements as $element => $value) {
            if(!is_string($element)) {
                throw new \InvalidArgumentException('second argument $elements, have to be array that contain only string');
            }
        }
        if ($nameSpace != null) {
            $dynamique_code = 'namespace ' . $nameSpace . ';';
        } else {
            $dynamique_code = '';
        }

        $dynamique_code .= "use Ukratio\ToolBundle\Service\Enum as Enum;";
        $dynamique_code .= "class $name extends Enum {";
        $dynamique_code .= 'public static $listOfElements;';
        foreach ($elements as $element => $value) {
            $dynamique_code .= "public static \$$element;";
        }

        $dynamique_code .= "}";
        $elements_in_string = "array('" . implode("','", array_keys($elements)) . "')";
        $dynamique_code .= "$name::\$listOfElements = $elements_in_string;";
        foreach ($elements as $element => $value) {
            if (is_string($value)) {
                $dynamique_code .= "$name::\$$element = new $name(\"$element\", \"$value\");";
            } elseif(is_int($value) or is_float($value)) {
                $dynamique_code .= "$name::\$$element = new $name(\"$element\", $value);";
            } else {
                throw new \InvalidArgumentException('the value of Enum have to be string, int, or float');
            }
        }

        if(eval($dynamique_code)!==null) {
            throw new \InvalidArgumentException();
        }
    }

}
