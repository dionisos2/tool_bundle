<?php

namespace Ukratio\ToolBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Ukratio\ToolBundle\Form\DataTransformer\StringToChoiceOrTextTransformer;

class ChoiceOrTextType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('choice', 'choice', array('choices' => $options['choices'] + array('other' => 'other',), 
                                                'label' => ' '));

        $optionsText =  array('label' => 'or', 'required' => false);
        
        if ($options['textType']) {
            $optionsText = array_merge($optionsText, $options['options']);
            $builder->add('text', $options['textType'], $optionsText);
        } else {
            $builder->add('text', 'text', $optionsText);
        }

        $builder->addViewTransformer(new StringToChoiceOrTextTransformer($options['choices']));

    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array('textType' => false,
                                     'options' => array()));
        $resolver->setRequired(array('choices'));
        $resolver->setAllowedTypes(array('choices' => 'array',
                                         'options' => 'array'));
    }

    public function getName()
    {
        return 'Tool_ChoiceOrText';
    }
}
