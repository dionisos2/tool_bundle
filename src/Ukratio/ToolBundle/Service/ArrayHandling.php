<?php

namespace Ukratio\ToolBundle\Service;


/**
 * tool for manipuling different types
 *
 * @api
 */
class ArrayHandling
{
    /**
     * Return a plane array with all the value of $array get recursively
     *
     * @param mixed $array the array
     * @param \Closure $getChilds function that have to return a array that will be recursively had to the result.
     * @param int $deph the deph at will the function will begin to 'sum' the arrays
     *
     * @return boolean
     */     
    public function getValuesRecursively($array, \Closure $getChilds = null, $deph = 0)
    {
        $self = $this;
        if ($getChilds === null)
        {
            $getChilds = function ($array) use ($self)
            {
                return $self->arrayIdentity($array);
            };
        }

        $result = array();

        foreach($array as $value) {
            $subArray = $getChilds($value);
            if ($subArray === array()) {
                if ($deph <= 0) {
                    $result[] = $value;
                }
            } else {
                $result = array_merge($result, $this->getValuesRecursively($subArray, $getChilds, $deph - 1));
            }
        }

        return $result;
    }

    public function arrayIdentity($array)
    {
        if (is_array($array)) {
            return $array;
        } else {
            return array();
        }
    }
}
