<?php

namespace Eud\ToolBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

use Symfony\Component\Form\Exception\UnexpectedTypeException;


class StringToChoiceOrTextTransformer implements DataTransformerInterface
{
    private $choices;

    public function __construct(array $choices)
    {
        $this->choices = $choices;
    }

    public function transform($value)
    {
        if (in_array($value, $this->choices, true)) {
            return array('choice' => $value, 'text' => '');
        }

        return array('choice' => 'other', 'text' => $value);
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
