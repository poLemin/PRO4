<?php

namespace PRO4\ProjectBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use PRO4\ProjectBundle\Form\Type\ProjectType;
use PRO4\ProjectBundle\Entity\Project;

class DefaultController extends Controller {
    public function indexAction() {
        return $this->noProjectIndex();
    }
    
   	public function noProjectIndex() {  		
   		return $this->render('PRO4ProjectBundle:Default:noProject.html.twig');
   	}
   	
   	public function addProjectAction(Request $request) {
   		$project = new Project();
    	$form = $this->createForm(new ProjectType(), $project);
    	
    	if ($request->isMethod('POST')) {
	        $form->bind($request);
	
	        if ($form->isValid()) {
	        	var_dump($project);
	        }
	    }
    	
   		return $this->render('PRO4ProjectBundle:Default:addProject.html.twig', array("form" => $form->createView()));
   	}
}
