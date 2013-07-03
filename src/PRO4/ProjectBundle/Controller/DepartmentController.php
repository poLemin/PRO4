<?php

namespace PRO4\ProjectBundle\Controller;

use PRO4\MainBundle\Controller\MyController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

use Doctrine\ORM\EntityRepository;

use PRO4\ProjectBundle\Entity\Project;
use PRO4\UserBundle\Entity\User;

use PRO4\ProjectBundle\Form\Type\DepartmentType;
use PRO4\ProjectBundle\Entity\Department;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

class DepartmentController extends MyController {
	
    public function indexAction(Request $request, $projectId, $departmentId = null) {
    	$project = $this->find("PRO4\ProjectBundle\Entity\Project", $projectId);
   		$this->checkPermission("VIEW", $project);
   		$departments = $project->getDepartments();
   		
   		if($departmentId !== null) {
   			$this->checkPermission("EDIT", $project);
   			$department = $this->find("PRO4\ProjectBundle\Entity\Department", $departmentId);
   		} else {
   			$department = new Department();
   		}
   		
   		$form = $this->createForm(new DepartmentType(), $department);
    	
    	$isAdmin = $this->hasPermission("EDIT", $project);

    	
    	if ($request->isMethod("POST")) {
    		$this->checkPermission("EDIT", $project);
	        $form->bind($request);
	        if ($form->isValid()) {
	        	if($departmentId === null) {	        		
	        		$project->addDepartment($department);
	        		$department->addUser($this->getUser());
	        	}
	        	
        		$em = $this->getDoctrine()->getManager();
				$em->persist($project);
				$em->flush();
	        	
	        	$em = $this->getDoctrine()->getManager();
   				$em->persist($department);
    			$em->flush();
    			
    			if($departmentId === null) {
    				$this->makeOperator($department, $this->getUser());
    				
    				// add project owner as department owner
	        		$users = $project->getUsers();
	        		foreach($users AS $user) {
	        			if($this->isUserOwner($project, $user)) {
	        				$this->makeOwner($department, $user);
	        			}
	        		}
    			}
    			
    			$action = ($departmentId === null ? "added" : "edited");
    			
    			$this->get('session')->getFlashBag()->add(
				    "success",
				    "You successfully " . $action . " a department."
				);
				
				return $this->redirect($this->generateUrl("department_overview", array("projectId" => $projectId)));
	        }
	    }
	    return $this->render('PRO4ProjectBundle:Department:departmentForm.html.twig', array("form" => $form->createView(), "isAdmin" => $isAdmin, "project" => $project, "departments" => $departments));
    }
    
    public function removeAction(Request $request, $projectId, $departmentId) {
   		$project = $this->find("PRO4\ProjectBundle\Entity\Project", $projectId);
    	$this->checkPermission("EDIT", $project);
    	$department = $this->find("PRO4\ProjectBundle\Entity\Department", $departmentId);

    	$project->removeDepartment($department);
    	$department->removeUser($this->getUser());
	    
	    $this->removePermissions($department, $this->getUser());
	    
        $em = $this->getDoctrine()->getManager();
        $em->remove($department);
		$em->persist($project);
		$em->flush();
    	
    	$this->get('session')->getFlashBag()->add(
				    'success',
				    'You successfully removed the department!'
				);
				
		return $this->redirect($this->generateUrl("department_overview", array("projectId" => $projectId)));
   	}
   	
   	public function usersInDepartmentAction(Request $request, $projectId, $departmentId) {
   		$project = $this->find("PRO4\ProjectBundle\Entity\Project", $projectId);
   		$this->checkPermission("VIEW", $project);
   		$isAdmin = $this->hasPermission("EDIT", $project);
   		$department = $this->find("PRO4\ProjectBundle\Entity\Department", $departmentId);
   		
   		$em = $this->getDoctrine()->getManager();
   		$form = $this->createFormBuilder()
	        ->add('user', 'entity', array(
			    'class' => 'PRO4UserBundle:User',
			    'property' => 'eMail',
			    'query_builder' => $em->getRepository("PRO4UserBundle:User")->findUsersInProjectNotInDepartment($project, $department),
    			'empty_value' => "Select User",
			))
			->getForm();
   		
   		$users = $department->getUsers();
   		foreach($users AS $user) {
   			$user->setIsOwner($this->isUserOwner($department, $user));
   			if(!$user->isOwner()) {
   				$user->setIsOperator($this->isUserOperator($department,$user));
   				if(!$user->isOperator()) {
	   				$user->setIsAdmin($this->isUserAdmin($department, $user));
	   			}
   			}
   		}
   		
   		if ($request->isMethod("POST")) {
    		$this->checkPermission("EDIT", $project);
	        $form->bind($request);
	        if ($form->isValid()) {
	        	
	        	$data = $form->getData();
	        	$user = $data["user"];
	        	
	        	$department->addUser($user);
	        	$this->makeViewer($department, $user);
	        	
	        	$em = $this->getDoctrine()->getManager();
   				$em->persist($department);
    			$em->flush();
    			
    			$this->get('session')->getFlashBag()->add(
				    "success",
				    "You successfully added " . $user->getEmail() . " to the department."
				);
				
				return $this->redirect($this->generateUrl("users_in_department", array("projectId" => $projectId, "departmentId" => $departmentId)));
	        }
        }
   		
   		return $this->render('PRO4ProjectBundle:Department:usersInDepartment.html.twig', array("form" => $form->createView(), "isAdmin" => $isAdmin, "project" => $project, "department" => $department, "users" => $users));
   	}
   	
   	public function removeUserFromDepartmentAction($projectId, $departmentId, $userId) {
   		$project = $this->find("PRO4\ProjectBundle\Entity\Project", $projectId);
   		$department = $this->find("PRO4\ProjectBundle\Entity\Department", $departmentId);
   		$user = $this->find("PRO4\UserBundle\Entity\User", $userId);
   		
   		// check if user has sufficient permissions to delete a user
   		if($this->isUserAdmin($department, $user)) {
   			$this->checkPermission("OPERATOR", $department);
   		} else {
   			$this->checkPermission("EDIT", $department);
   		}
    	
    	if($this->getUser()->getUserId() == $userId || $this->isUserOperator($department, $user) || !$project->getUsers()->contains($user)) {
    		throw new InvalidArgumentException();
    	}
    	$department->removeUser($user);
    	$this->removePermissions($department, $user);
	            
        $em = $this->getDoctrine()->getManager();
		$em->persist($project);
		$em->flush();
    	
    	$this->get('session')->getFlashBag()->add(
				    'success',
				    'You successfully removed ' . $user->getEmail() . ' from this department!'
				);
				
		return $this->redirect($this->generateUrl("users_in_department", array("projectId" => $project->getProjectId(), "departmentId" => $department->getDepartmentId())));
   	}
   	
   	public function grantAdminInDepartmentAction($projectId, $departmentId, $userId) {
   		$this->checkPermission("OPERATOR", $department);
   		
   		$project = $this->find("PRO4\ProjectBundle\Entity\Project", $projectId);
    	$department = $this->find("PRO4\ProjectBundle\Entity\Department", $departmentId);
   		$user = $this->find("PRO4\UserBundle\Entity\User", $userId);
   		
    	if($this->getUser()->getUserId() == $userId || $this->isUserAdmin($department, $user) || !$department->getUsers()->contains($user)) {
    		throw new InvalidArgumentException();
    	}
    	
    	$this->makeAdmin($department, $user);
    	
    	$this->get('session')->getFlashBag()->add(
				    'success',
				    'You successfully gave ' . $user->getEmail() . ' admin-rights for this department!'
				);
				
		return $this->redirect($this->generateUrl("users_in_department", array("projectId" => $project->getProjectId(), "departmentId" => $department->getDepartmentId())));
   	}
   	
   	public function revokeAdminInDepartmentAction() {
   		
   	}
   
}
