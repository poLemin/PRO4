<?php

namespace PRO4\ProjectBundle\Controller;

use PRO4\MainBundle\Controller\MyController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

use PRO4\ProjectBundle\Form\Type\MilestonePlanType;
use PRO4\ProjectBundle\Entity\MilestonePlan;

class MilestonePlanController extends MyController {
   	
   	public function indexAction(Request $request) {
   		$project = $this->get("session")->get("curProject");
   		if($project !== null) {
   			$milestonePlan = new MilestonePlan();
   			$milestonePlan->setProject($project);
	    	$form = $this->createForm(new MilestonePlanType(), $milestonePlan);
	    	
	    	if ($request->isMethod("POST")) {
		        $form->bind($request);
		
		        if ($form->isValid()) {
		        	$em = $this->getDoctrine()->getManager();
	   				$em->persist($milestonePlan);
	    			$em->flush();
		        }
		    }
		    
		    return $this->render("PRO4ProjectBundle:Default:milestonePlanForm.html.twig", array("form" => $form->createView()));	
   		} else {
   			return $this->redirect($this->generateUrl("project"));
   		}
   	}
}
