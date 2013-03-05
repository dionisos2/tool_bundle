<?php

namespace Eud\ToolBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

use Symfony\Component\Form\Exception\UnexpectedTypeException;


class StringToChoiceOrTextTransformer implements DataTransformerInterface
{
    public function transform($value)
    {
        return array('choice' => 'other', 'text' => '',);
    }

    public function reverseTransform($value)
    {
        if ($value['choice'] === 'other') {
            return $value['text'];
        } else {
            return $value['choice'];
        }
    }

}
