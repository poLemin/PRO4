<?php
namespace PRO4\UserBundle\Form\Type;

use Symfony\Component\Security\Core\Validator\Constraints;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType {
	
	public function buildForm(FormBuilderInterface $builder, array $options) {	
		$builder->add("eMail", "email", array("label" => "Email"));
		
		if(!isset($options["attr"]["eMailOnly"]) || !$options["attr"]["eMailOnly"]) {
			$builder->add("password", "repeated",
				array(
					"type" => "password",
					"invalid_message" => "The password fields must match.",
					"options" => array(
					   "label" => "Password"
					)
				)
			);
			
			if(!isset($options["attr"]["register"]) || !$options["attr"]["register"]) {
			 $builder->add("oldPassword", "password", array("label" => "Old Password", "constraints" => array(new UserPassword())));
			}
		}
		
		
	}

	public function getName() {
		return "user";
	}

	public function setDefaultOptions(OptionsResolverInterface $resolver) {
		$resolver->setDefaults(array (
			"data_class" => "PRO4\UserBundle\Entity\User",			
		));
	}
}