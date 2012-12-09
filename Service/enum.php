<?php

abstract class Enum
{
	public function __construct($valeur = null)
	{
		$this->id = self::$nbr_id;
		$this->valeur = $valeur;
		Enum::$nbr_id++;
	}

	public function __toString()
	{
		return get_class($this) . ":" . $this->valeur . ":" . $this->id;
	}
	
	public function get_id()
	{
		return $this->id;
	}

	static protected $nbr_id = 0;
	protected $id, $valeur;
	
}

function enum($name, $elements)
{
	if(!is_string($name))
	{
		throw new InvalidArgumentException('the first argument $name, have to be a string');
	}

	foreach ($elements as $element)
	{
		if(!is_string($element))
		{
					throw new InvalidArgumentException('second argument $elements, have to be array that contain only string');
		}
	}

	$dynamique_code = "class $name extends Enum {";
	foreach ($elements as $element)
	{
		$dynamique_code .= "public static \$$element;";
	}

	$dynamique_code .= "}";
	foreach ($elements as $element)
	{
		$dynamique_code .= "$name::\$$element = new $name(\"$element\");";
	}

	if(eval($dynamique_code)!==null)
	{
		throw new InvalidArgumentException();
	}
}
