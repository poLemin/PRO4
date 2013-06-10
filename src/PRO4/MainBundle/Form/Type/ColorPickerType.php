<?php

namespace PRO4\MainBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ColorPickerType extends AbstractType
{
	
	public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'attr' => array("class" => "colorSelector")
        ));
    }
    
    public function getParent()
    {
        return 'text';
    }

    public function getName()
    {
        return 'colorPicker';
    }
}