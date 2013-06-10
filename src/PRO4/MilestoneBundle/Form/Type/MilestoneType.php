<?php
namespace PRO4\MilestoneBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MilestonePlanType extends AbstractType {
	
	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder->add("name", "text", array("label" => "Name"));
		$builder->add("start_date", "date", array("label" => "Start date"));
		$builder->add("end_date", "date", array("label" => "End date"));
		$builder->add("color", "color", array("label" => "End date"));
	}

	public function getName() {
		return 'MilestonePlan';
	}

	public function setDefaultOptions(OptionsResolverInterface $resolver) {
		$resolver->setDefaults(array (
			'data_class' => 'PRO4\MilestoneBundle\Entity\Milestone',
		));
	}
}