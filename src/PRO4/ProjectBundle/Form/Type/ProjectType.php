<?php
namespace PRO4\ProjectBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface; // data_class!

class ProjectType extends AbstractType {
	
	public function buildForm(FormBuilderInterface $builder, array $options) {
		if(!isset($options["attr"]["disabled"])) {
			 $options["attr"]["disabled"] = false;
		}
		
		$builder->add("name", "text", array("label" => "Name", "disabled" => $options["attr"]["disabled"]));
		$builder->add("description", "textarea", array("label" => "Description", "disabled" => $options["attr"]["disabled"], "attr" => array("rows" => 10, "cols" => 40)));
		
	}

	public function getName() {
		return 'project';
	}

	public function setDefaultOptions(OptionsResolverInterface $resolver) {
		$resolver->setDefaults(array (
			'data_class' => 'PRO4\ProjectBundle\Entity\Project',			
		));
	}
}