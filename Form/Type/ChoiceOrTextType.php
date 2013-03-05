<?php

namespace Eud\ToolBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Eud\ToolBundle\Form\DataTransformer\StringToChoiceOrTextTransformer;

class ChoiceOrTextType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('choice', 'choice', array('choices' => $options['choices'] + array('other' => 'other',), 
                                                'label' => ' '))
                ->add('text', 'text', array('label' => 'or',
                                            'required' => false))
                ->addViewTransformer(new StringToChoiceOrTextTransformer());

    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired(array('choices'));
        $resolver->setAllowedTypes(array('choices' => 'array'));
    }

    public function getName()
    {
        return 'Tool_ChoiceOrText';
    }
}
