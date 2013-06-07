<?php

namespace PRO4\MilestoneBundle\Controller;

use PRO4\MainBundle\Controller\MyController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

use PRO4\MilestoneBundle\Form\Type\MilestonePlanType;
use PRO4\MilestoneBundle\Entity\MilestonePlan;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

class MilestonePlanController extends MyController {
   	
   	public function indexAction(Request $request, $id) {
		$em = $this->getDoctrine()->getManager();
		$milestonePlan = new MilestonePlan();
		$project = $this->find("PRO4\ProjectBundle\Entity\Project", $id);
		$this->checkPermission("EDIT", $project);

		
		$milestonePlan->setProject($project);
    	$form = $this->createForm(new MilestonePlanType(), $milestonePlan);

    	if ($request->isMethod("POST")) {
	        $form->bind($request);

	        if ($form->isValid()) {
   				$em->persist($milestonePlan);
    			$em->flush();
			
    			$this->get('session')->getFlashBag()->add(
				    'success',
				    'You successfully added a milestone-plan. Now you can add other users to your project!'
				);
				
				return $this->redirect($this->generateUrl("users_in_project", array("id" => $project->getId())));
	        }
	    }

	    return $this->render("PRO4MilestoneBundle:MilestonePlan:milestonePlanForm.html.twig", array("form" => $form->createView()));	
   	}
}