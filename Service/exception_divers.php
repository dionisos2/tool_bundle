<?php

function is_float_or_int($x)
{
	return (is_float($x) || is_int($x));
}

function have_to_be($type, $x, $index = 0, $accept_null = false)
{
	if(!is_int($index))
	{
		throw new InvalidArgumentException("$type expected in 2th argument in have_to_be_$type");
	}

	if($accept_null)
	{
		$msg_add = "or null";
	}
	else
	{
		$msg_add = "";
	}

	switch ($type) 
	{
	case "string":
		$is_type = "is_string";
		break;
	case "int":
		$is_type = "is_int";
		break;
	case "bool":
		$is_type = "is_bool";
		break;
	case "float":
		$is_type = "is_float_or_int";
		break;
	default:
		throw InvalidArgumentException("\$type have to be int or string, $type found");
	}

	if((!$is_type($x))and(($x !== null) or (!$accept_null)))
	{
		if($index != 0)
		{
			throw new InvalidArgumentException("$type $msg_add expected in " . $index ."th argument, " . gettype($x) . " found");
		}
		else
		{
			throw new InvalidArgumentException("$type $msg_add expected, " . gettype($x) . " found");
		}
		
	}
}

function have_to_be_string($x, $index = 0, $accept_null = false)
{
	have_to_be("string", $x, $index, $accept_null);
}

function have_to_be_int($x, $index = 0, $accept_null = false)
{
	have_to_be("int", $x, $index, $accept_null);
}

function have_to_be_bool($x, $index = 0, $accept_null = false)
{
	have_to_be("bool", $x, $index, $accept_null);
}

function have_to_be_float($x, $index = 0, $accept_null = false)
{
	have_to_be("float", $x, $index, $accept_null);
}
