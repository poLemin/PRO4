<?php

namespace PRO4\ProjectBundle\Controller;

use PRO4\MainBundle\Controller\MyController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

use PRO4\ProjectBundle\Entity\Project;
use PRO4\UserBundle\Entity\User;
use PRO4\UserBundle\Form\Type\UserType;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class UsersInProjectController extends MyController {
    public function indexAction(Request $request, $id) {
    	$project = $this->find("PRO4\ProjectBundle\Entity\Project", $id);
    	$this->checkPermission("VIEW", $project);
    	$users = $project->getUsers();
    	
    	$form = $this->createFormBuilder()
	        ->add("eMail", "email",array(
			    "label"  => "E-Mail",
			    "constraints" => array(new Email(), new NotBlank())
			))
			->getForm();
    	
    	$showForm = $this->get('security.context')->isGranted('EDIT', $project);

    	
    	if ($request->isMethod('POST')) {
    		$this->checkPermission("EDIT", $project);
	        $form->bind($request);
	        if ($form->isValid()) {
	        	$data = $form->getData();
	        	$user = $this->getDoctrine()->getRepository('PRO4UserBundle:User')->findOneByEMail($data["eMail"]);
	        	if(!$user) {
	        		$user = new User();
	        		$user->setEMail($data["eMail"]);
	        		
    		    	$factory = $this->get('security.encoder_factory');
					$encoder = $factory->getEncoder($user);
					$password = $encoder->encodePassword("test1234", $user->getSalt());
    				$user->setPassword($password);
    				
	        		$em = $this->getDoctrine()->getManager();
   					$em->persist($user);
    				$em->flush();
    				
    				$user = $this->getDoctrine()->getRepository('PRO4UserBundle:User')->findOneByEMail($data["eMail"]);
	        	}
	        	
	        	$project->addUser($user);
	            $this->addPermission($project, MaskBuilder::MASK_VIEW, $user);
	            
	            $em = $this->getDoctrine()->getManager();
   				$em->persist($project);
    			$em->flush();
    			
    			$this->get('session')->getFlashBag()->add(
				    'success',
				    'You successfully added ' . $user->getEmail() . ' to project!'
				);
				
				return $this->redirect($this->generateUrl("users_in_project", array("id" => $project->getId())));
	        }
	    }
    	
    	return $this->render("PRO4ProjectBundle:UsersInProject:userForm.html.twig", array("form" => $form->createView(), "showForm" => $showForm, "users" => $users));
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
