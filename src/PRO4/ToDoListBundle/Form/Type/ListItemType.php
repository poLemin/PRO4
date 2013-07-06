<?php
namespace PRO4\ToDoListBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class ListItemType extends AbstractType {
	
	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder->add("name", "text", array("label" => "Name"));
	}

	public function getName() {
		return 'listItem';
	}

	public function setDefaultOptions(OptionsResolverInterface $resolver) {
		$resolver->setDefaults(array (
			'data_class' => 'PRO4\ToDoListBundle\Entity\ListItem',			
		));
	}
}