<?php

/**
 * Abstract class on which are based the others enum class
 */ 
abstract class Enum
{
    
    protected static $nbrId = 0;
    protected $id;
    protected $valeur;

    public function __construct($valeur = null)
    {
        $this->id = self::$nbrId;
        $this->valeur = $valeur;
        Enum::$nbrId++;
    }

    public function __toString()
    {
        return get_class($this) . ":" . $this->valeur . ":" . $this->id;
    }
    
    public function getId()
    {
        return $this->id;
    }   
}

/**
 * Create a enum class
 *
 * enum("enum_name", array("enumerator1", "enumerator2", "enumerator3"));
 * $a = enum_name::$enumerator2
 * get_class($a) === "enum_name" -> true
 * $a === enum_name::$enumerator1 -> false
 * $a === enum_name::$enumerator2 -> true
 * look at EnumTest for more info
 *
 * @api
 *
 * @return void
 */ 
function enum($name, $elements)
{
    if(!is_string($name)) {
        throw new InvalidArgumentException('the first argument $name, have to be a string');
    }

    foreach ($elements as $element) {
        if(!is_string($element)) {
            throw new InvalidArgumentException('second argument $elements, have to be array that contain only string');
        }
    }

    $dynamique_code = "class $name extends Enum {";
    foreach ($elements as $element) {
        $dynamique_code .= "public static \$$element;";
    }

    $dynamique_code .= "}";
    foreach ($elements as $element) {
        $dynamique_code .= "$name::\$$element = new $name(\"$element\");";
    }

    if(eval($dynamique_code)!==null) {
        throw new InvalidArgumentException();
    }
}
