<?php
namespace PRO4\ToDoListBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use PRO4\ProjectBundle\Entity\DepartmentRepository;

use Symfony\Bridge\Doctrine\RegistryInterface;


class ToDoListType extends AbstractType {
	
	private $project;
	private $doctrine;

    public function __construct(\PRO4\ProjectBundle\Entity\Project $project, RegistryInterface $doctrine) {
    	$this->project = $project;
        $this->doctrine = $doctrine;
    }
	
	public function buildForm(FormBuilderInterface $builder, array $options) {
		$required = false;
		if(isset($options["attr"]["required"])) {
			$required = $options["attr"]["required"];
		}

		$builder->add("name", "text", array("label" => "Name"));
		$builder->add('department', 'entity', array(
			    'class' => 'PRO4ProjectBundle:Department',
			    'property' => 'name',
			    'query_builder' => $this->doctrine->getRepository('PRO4ProjectBundle:Department')->findDepartmentsInProject($this->project),
    			'empty_value' => "Select Department",
    			'required' => $required,
    			'label' => "Department",
			));
		
	}

	public function getName() {
		return 'toDoList';
	}

	public function setDefaultOptions(OptionsResolverInterface $resolver) {
		$resolver->setDefaults(array (
			'data_class' => 'PRO4\ToDoListBundle\Entity\ToDoList',			
		));
	}
}