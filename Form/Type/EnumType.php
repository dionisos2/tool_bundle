<?php

namespace Eud\ToolBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Eud\ToolBundle\Service\Enum;


class EnumType extends AbstractType
{
    private $enumChoices;
    
    public function __construct($enumName)
    {
        $choices = call_user_func($enumName . '::getListOfElement');
        $choices = array_combine($choices, $choices);
        $this->enumChoices = $choices;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => null,
            'choices' => $this->enumChoices));
    }

    public function getParent()
    {
        return 'choice';
    }

    public function getName()
    {
        return 'Tool_enum';
    }
}
