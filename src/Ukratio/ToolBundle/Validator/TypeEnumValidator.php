<?php
 
namespace Ukratio\ToolBundle\Validator;
 
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
 
class TypeEnumValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        $possibleValues =  implode('", "', call_user_func($constraint->enumName .'::getListOfElement'));

        if ((!is_string($value)) or (call_user_func($constraint->enumName . '::getEnumerator', $value) === null)) {
            $this->context->addViolation($constraint->message,
                                         array('{{ possibleValues }}' => '{"' . $possibleValues . '"}',
                                               '{{ value }}' => $value));
        }
    }
}