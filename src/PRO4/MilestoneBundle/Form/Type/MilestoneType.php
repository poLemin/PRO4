<?php
namespace PRO4\MilestoneBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use PRO4\MainBundle\Form\Type\ColorPickerType;

class MilestoneType extends AbstractType {
	
	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder->add("name", "text", array("label" => "Name"));
		$builder->add("start_date", "date", array("label" => "Start date"));
		$builder->add("end_date", "date", array("label" => "End date"));
		$builder->add("color", new ColorPickerType(), array("label" => "Color"));
	}

	public function getName() {
		return 'Milestone';
	}

	public function setDefaultOptions(OptionsResolverInterface $resolver) {
		$resolver->setDefaults(array (
			'data_class' => 'PRO4\MilestoneBundle\Entity\Milestone',
		));
	}
}