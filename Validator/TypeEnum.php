<?php
 
namespace Eud\ToolBundle\Validator;
 
use Symfony\Component\Validator\Constraint;
 
/**
 * @Annotation
 */
class TypeEnum extends Constraint
{
    public $enumName;
    public $message = 'This value should be in {{ possibleValues }}, but {{ value }} found';
}