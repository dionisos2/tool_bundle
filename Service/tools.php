<?php

/**
 * tool for manipuling different types
 *
 * @api
 */
class data_checking
{

    /**
     * @param mixed $x
     * @param mixed $v
     *
     * @return boolean true when $x is set and equal to $v
     */
    public function isset_and_equal($x,$v)
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
    function is_integer($text)
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
    function numbers($text)
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
    function key_exists_and_equal($tab, $key, $value)
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
    function last_key(array $array)
    {
        end($array);
        $key = key($array);
        reset($array);
        return $key;
    }
}