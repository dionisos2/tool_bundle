<?php

namespace Ukratio\ToolBundle\Service;

/**
 * tool for manipuling different types
 *
 * @api
 */
class ArrayHandling
{

    public function hasCycle($array, \Closure $getChilds = null, $dephBegin = 0)
    {
        throw new Exception('has Cycle is unimplemented');
    }

    public function hasTrueCycle($array, \Closure $getChilds)
    {
        $partition = $this->tarjanPartition($array, $getChilds);

        foreach($partition as $arrayValue) {
            $value = current($arrayValue);

            if ((count($arrayValue) > 1) or (in_array($value, $getChilds($value)))) {
                return true;
            }
        }
        return false;
    }

    public function tarjanPartition($array, \Closure $getChilds)
    {
        $result = array();
        $indexDFS = 0;
        $indexArray = array();
        $stack = array();

        foreach($array as $value) {
            $id = $this->getId($value);
            if (! isset($indexArray[$id])) {
                $newResult = $this->tarjan($value, $indexDFS, $indexArray, $stack, $getChilds);
                $result = array_merge($result, $newResult);
            }
        }
        return $result;
    }


    /**
     * Return a plane array with all the value of $array get recursively
     *
     * @param mixed $array the array
     * @param \Closure $getChilds function that have to return a array that will be recursively had to the result.
     * @param int $dephBegin the deph at will the function will begin to 'sum' the arrays
     *
     * @return boolean
     */     
    public function getValuesRecursively($array, \Closure $getChilds = null, $dephBegin = 0)
    {
        if ($getChilds === null) {
            $self = $this;
            $getChilds = function ($array) use ($self)
            {
                return $self->arrayIdentity($array);
            };
        }

        if ($this->hasTrueCycle($array, $getChilds)) {
            throw new \OutOfRangeException('they are cycle in the $array !');
        } else {
            return 10;
        }


        $result = array();

        foreach($array as $value) {
            $subArray = $getChilds($value);
            if ($subArray === array()) {
                if ($dephBegin <= 0) {
                    $result[] = $value;
                }
            } else {
                $result = array_merge($result, $this->getValuesRecursively($subArray, $getChilds, $dephBegin - 1));
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

    private function getId($value)
    {
        if(gettype($value) == 'object') {
            return spl_object_hash($value);
        } else {
            throw new \Exception('unimplemented getId for (not object)');
        }
    }

    private function tarjan($value, &$indexDFS, &$indexArray, &$stack, \Closure $getChilds)
    {
        $id = $this->getId($value);
        $result = array();

        $indexArray[$id] = array('index' => $indexDFS,
                                 'lowLink' => $indexDFS);
        $indexDFS++;
        $stack[] = $value;

        foreach($getChilds($value) as $childValue) {
            $childId = $this->getId($childValue);
            if(! isset($indexArray[$childId])) {
                $newResult = $this->tarjan($childValue, $indexDFS, $indexArray, $stack, $getChilds);

                $result = array_merge($result, $newResult);
                $indexArray[$id]['lowLink'] = min($indexArray[$id]['lowLink'], $indexArray[$childId]['lowLink']);
            } elseif(in_array($childValue, $stack)) {
                $indexArray[$id]['lowLink'] = min($indexArray[$id]['lowLink'], $indexArray[$childId]['index']);
            }
        }

        if ($indexArray[$id]['lowLink'] == $indexArray[$id]['index']) {

            $result[] = array();
            end($result);
            $lastKey = key($result);

            do {
                $childValue = array_pop($stack);
                $result[$lastKey][] = $childValue;
            } while ($value !== $childValue);
        }

        return $result;        
    }
}
