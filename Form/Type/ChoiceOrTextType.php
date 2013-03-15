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

        if ($options['textType']) {
            $builder->add('text', $options['textType'], array('label' => 'or',
                                                'required' => false));
        } else {
            $builder->add('text', 'text', array('label' => 'or',
                                                'required' => false));
        }

        $builder->addViewTransformer(new StringToChoiceOrTextTransformer($options['choices']));

    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array('textType' => false));
        $resolver->setRequired(array('choices'));
        $resolver->setAllowedTypes(array('choices' => 'array'));
    }

    public function getName()
    {
        return 'Tool_ChoiceOrText';
    }
}
