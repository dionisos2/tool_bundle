<?php

require_once '../load.php';
load("./enum.php");


$array_enum_a = array("auieuaie","eiuaeiua","aaaaaa","uuuuuu","eiuaauieeiua");
$array_enum_b = array("tsrtntsrn","nrstnrst","tttt","trntsrntsrntsrn","nrstssrnrstsrn");
enum("type_a", $array_enum_a);
enum("type_b", $array_enum_b);

$iterations = 1000000;



$start = microtime(true);
for ($i = 0; $i < $iterations; ++$i)
{
	$auie = 0;
	if(true)
	{
		$auie++;
	}

	if(true)
	{
		$auie++;
	}
}

$finis = microtime(true);

$time_to_fill = $finis - $start;

echo "temps pour base = $time_to_fill <br/>";


$start = microtime(true);
for ($i = 0; $i < $iterations; ++$i)
{
	$auie = 0;
	$str = "eiuaauieeiua";
	if($str == "eiuaauieeiua")
	{
		$auie++;
	}
	else
	{
		$auie++;
	}
	$str = "tttttttttt";

	if($str == "ttttttt")
	{
		$auie++;
	}
	else
	{
		$auie++;
	}
}

$finis = microtime(true);

$time_to_fill = $finis - $start;

echo "temps pour array = $time_to_fill <br/>";


$start = microtime(true);
for ($i = 0; $i < $iterations; ++$i)
{
	$auie = 0;
	if(type_a::$auieuaie === type_a::$auieuaie)
	{
		$auie++;
	}
	else
	{
		$auie++;
	}

	if(type_b::$tttt === type_b::$nrstssrnrstsrn)
	{
		$auie++;
	}
	else
	{
		$auie++;
	}
}

$finis = microtime(true);

$time_to_fill = $finis - $start;

echo "temps pour enum = $time_to_fill <br/>";