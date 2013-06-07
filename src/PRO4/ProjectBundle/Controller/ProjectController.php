<?php

namespace PRO4\ProjectBundle\Controller;

use PRO4\MainBundle\Controller\MyController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

use PRO4\ProjectBundle\Form\Type\ProjectType;
use PRO4\ProjectBundle\Entity\Project;

use PRO4\ProjectBundle\Form\Type\MilestonePlanType;
use PRO4\ProjectBundle\Entity\MilestonePlan;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

class ProjectController extends MyController {
    public function indexAction() {
    	if($this->getUser()->getProjects()->count() > 0) {
    		return $this->overviewAction();
    	} else {
    		return $this->noProjectIndex();
    	}
    }
    
   	public function noProjectIndex() {	
   		return $this->render('PRO4ProjectBundle:Project:noProject.html.twig');
   	}
   	
   	public function overviewAction() {
    	$projects = $this->getUser()->getProjects();
    	
    	return $this->render("PRO4ProjectBundle:Project:overview.html.twig", array("projects" => $projects));
   	}
   	
   	public function projectFormAction(Request $request) {
   		$project = new Project();
    	$form = $this->createForm(new ProjectType(), $project);
    	
    	if ($request->isMethod('POST')) {
	        $form->bind($request);
	        if ($form->isValid()) {
	        	$project->addUser($this->getUser());
	        	$em = $this->getDoctrine()->getManager();
   				$em->persist($project);
    			$em->flush();
    			
    			// creating the ACL
	            $aclProvider = $this->get('security.acl.provider');
	            $objectIdentity = ObjectIdentity::fromDomainObject($project);
	            $acl = $aclProvider->createAcl($objectIdentity);
	
	            // retrieving the security identity of the currently logged-in user
	            $securityContext = $this->get('security.context');
	            $securityIdentity = UserSecurityIdentity::fromAccount($this->getUser());
	
	            // grant owner access
	            $acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OPERATOR);
	            $aclProvider->updateAcl($acl);
    			
    			$this->get('session')->getFlashBag()->add(
				    'success',
				    'You successfully created a project. Now you can add beginning and end date to it!'
				);
    			
    			return $this->redirect($this->generateUrl("milestone_plan_form", array("id" => $project->getId())));
	        }
	    }
    	
   		return $this->render('PRO4ProjectBundle:Project:projectForm.html.twig', array("form" => $form->createView(), "action" => "Add"));
   	}
   	
   	public function projectDetailAction(Request $request, $id) {
   		$project = $this->find("PRO4\ProjectBundle\Entity\Project", $id);
   		$this->checkPermission("VIEW", $project);
   		
    	$form = $this->createForm(new ProjectType(), $project, array("attr" => array('disabled' => true)));
    	
        $showButton = $this->get('security.context')->isGranted('EDIT', $project);
    	
    	if ($request->isMethod('POST')) {
    		return $this->redirect($this->generateUrl("edit_project_detail", array("id" => $project->getId())));
	    }
    	
    	return $this->render('PRO4ProjectBundle:Project:projectForm.html.twig', array("form" => $form->createView(), "showButton" => $showButton, "action" => "Edit"));
   	}
   	
   	public function editProjectDetailAction(Request $request, $id) {
   		$project = $this->find("PRO4\ProjectBundle\Entity\Project", $id);
   		$this->checkPermission("EDIT", $project);
   		
   		$form = $this->createForm(new ProjectType(), $project);
   		
   		if ($request->isMethod('POST')) {
	        $form->bind($request);
	   		if ($form->isValid()) {
	        	$em = $this->getDoctrine()->getManager();
				$em->persist($project);
				$em->flush();
				
				$this->get('session')->getFlashBag()->add(
				    'success',
				    'Project was successfully edited.'
				);
				
				return $this->redirect($this->generateUrl("project_detail", array("id" => $project->getId())));
	        }
   		}

   		return $this->render("PRO4ProjectBundle:Project:projectForm.html.twig", array("form" => $form->createView(), "action" => "Edit"));
   	}
}
