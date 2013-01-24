<?php

namespace Eud\ToolBundle\Service;

/**
 * Abstract class on which are based the others enum class
 */ 
abstract class Enum
{
    
    protected static $nbrId = 0;
    protected $id;
    protected $value;

    public function __construct($value = null)
    {
        $this->id = self::$nbrId;
        $this->value = $value;
        Enum::$nbrId++;
    }

    public function __toString()
    {
        return get_class($this) . ":" . $this->value . ":" . $this->id;
    }
    
    public function getValue()
    {
        return $this->value;
    }

    public function getId()
    {
        return $this->id;
    }   

    public static function getEnumerator($enumName)
    {
        if(!is_string($enumName)) {
            throw new \InvalidArgumentException('the first argument $enumName, have to be a string');
        }

        if(in_array($enumName, static::$list_of_elements)) {
            return static::$$enumName;
        } else {
            return null;
        }
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
    public static function enum($name, $elements)
    {
        if(!is_string($name)) {
            throw new \InvalidArgumentException('the first argument $name, have to be a string');
        }

        foreach ($elements as $element) {
            if(!is_string($element)) {
                throw new \InvalidArgumentException('second argument $elements, have to be array that contain only string');
            }
        }

        $dynamique_code = "use Eud\ToolBundle\Service\Enum as Enum;";
        $dynamique_code .= "class $name extends Enum {";
        $dynamique_code .= 'public static $list_of_elements;';
        foreach ($elements as $element) {
            $dynamique_code .= "public static \$$element;";
        }

        $dynamique_code .= "}";
        $elements_in_string = "array('" . implode("','", $elements) . "')";
        $dynamique_code .= "$name::\$list_of_elements = $elements_in_string;";
        foreach ($elements as $element) {
            $dynamique_code .= "$name::\$$element = new $name(\"$element\");";
        }

        if(eval($dynamique_code)!==null) {
            throw new \InvalidArgumentException();
        }
    }

}
