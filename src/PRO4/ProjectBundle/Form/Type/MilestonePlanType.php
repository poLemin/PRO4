<?php
namespace PRO4\ProjectBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MilestonePlanType extends AbstractType {
	
	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder->add("start_date", "date", array("label" => "Start date"));
		$builder->add("end_date", "date", array("label" => "End date"));
	}

	public function getName() {
		return 'MilestonePlan';
	}

	public function setDefaultOptions(OptionsResolverInterface $resolver) {
		$resolver->setDefaults(array (
			'data_class' => 'PRO4\ProjectBundle\Entity\MilestonePlan',
		));
	}
}