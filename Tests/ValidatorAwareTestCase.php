<?php

namespace Eud\ToolBundle\Tests;
use Symfony\Component\Validator\Validation;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

class ValidatorAwareTestCase extends \PHPUnit_Framework_TestCase
{
    protected static $validator;


    public static function setUpBeforeClass()
    {
        static::$validator = Validation::createValidatorBuilder()->enableAnnotationMapping()->getValidator();
    }

    protected function valide($object)
    {
        echo static::$validator->validate($object);
        $this->assertEquals(0, static::$validator->validate($object)->count());
    }

    protected function notValide($object, $propertyPath)
    {
        $constraintViolationList = static::$validator->validate($object);
        $this->assertEquals(1, $constraintViolationList->count());
        $this->assertEquals($propertyPath, $constraintViolationList[0]->getPropertyPath());
    }

}