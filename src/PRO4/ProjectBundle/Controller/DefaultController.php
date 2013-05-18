<?php

namespace PRO4\ProjectBundle\Controller;

use PRO4\MainBundle\Controller\MyController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

use PRO4\ProjectBundle\Form\Type\ProjectType;
use PRO4\ProjectBundle\Entity\Project;

use PRO4\ProjectBundle\Form\Type\MilestonePlanType;
use PRO4\ProjectBundle\Entity\MilestonePlan;

class DefaultController extends MyController {
    public function indexAction() {
        return $this->noProjectIndex();
    }
    
   	public function noProjectIndex() {  		
   		return $this->render('PRO4ProjectBundle:Default:noProject.html.twig');
   	}
   	
   	public function projectFormAction(Request $request) {
   		$project = new Project();
    	$form = $this->createForm(new ProjectType(), $project);
    	
    	if ($request->isMethod('POST')) {
	        $form->bind($request);
	        if ($form->isValid()) {
	        	$em = $this->getDoctrine()->getManager();
   				$em->persist($project);
    			$em->flush();
    			
    			$this->get('session')->set("curProject", $project);
    			
    			$this->get('session')->getFlashBag()->add(
				    'success',
				    'You successfully created a project. Now you can add beginning and end date to it!'
				);
    			
    			return $this->redirect($this->generateUrl("milestone_plan_form"));
	        }
	    }
    	
   		return $this->render('PRO4ProjectBundle:Default:projectForm.html.twig', array("form" => $form->createView()));
   	}
   	
   	public function milestonePlanFormAction(Request $request) {   		
   		$milestonePlan = new MilestonePlan();
    	$form = $this->createForm(new MilestonePlanType(), $milestonePlan);
    	
    	if ($request->isMethod('POST')) {
	        $form->bind($request);
	
	        if ($form->isValid()) {
	        	$em = $this->getDoctrine()->getManager();
   				$em->persist($milestonePlan);
    			$em->flush();
	        }
	    }
	    
	    return $this->render('PRO4ProjectBundle:Default:milestonePlanForm.html.twig', array("form" => $form->createView()));
   	}
}
