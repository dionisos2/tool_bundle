<?php

/**
 * tool for manipuling different types
 *
 * @api
 */
class DataChecking
{

    /**
     * Return true if $x is a float or a int
     *
     * @param mixed $x
     *
     * @return boolean
     */     
    public function isFloatOrInt($x)
    {
        return (is_float($x) || is_int($x));
    }

    /**
     * @param mixed $x
     * @param mixed $v
     *
     * @return boolean true when $x is set and equal to $v
     */
    public function issetAndEqual($x, $v)
    {
        return isset($x) and ($x === $v);
    }

    /**
     * Returns true if $text is strictly convertible in integer.
     *
     * @param string $text
     *
     * @return boolean
     */
    public function isInteger($text)
    {
        $text = strval($text);
        if ($text === '') {
            return false;
        }
        if (in_array($text[0], array('-', '+')) ) {
            $text = substr($text,1);
        }
        if ($text === '') {
            return false;
        }

        return chiffres($text);
    }

    /** 
     * indique si la chaine ne contient que des chiffres.
     *
     * contrairement à is_int, n'exige pas que l'on ait une donnée de type "int".
     *
     * @param string $text
     *
     * @return boolean
     */
    public function numbers($text)
    {
        $text = (string)$text;
        return preg_match('/^\d+$/',$text); 
    }

    /**
     * check if the $key exist in the $tab, and is equal to $value
     *
     * @param array $tab
     * @param mixed $key
     * @param mixed $value
     *
     * @return boolean
     */     
    public function keyExistsAndEqual($tab, $key, $value)
    {
        return array_key_exists($key, $tab) and ($tab[$key] === $value);
    }

    /**
     * give the last key of the $array
     *
     * @param array $array
     *
     * @return mixed 
     */     
    public function lastKey(array $array)
    {
        end($array);
        $key = key($array);
        reset($array);
        return $key;
    }
}