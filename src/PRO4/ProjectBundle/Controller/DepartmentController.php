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
    				$this->addPermission($department, MaskBuilder::MASK_OPERATOR, $this->getUser());
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
   	
   	public function userInDepartmentAction(Request $request, $projectId, $departmentId) {
   		$project = $this->find("PRO4\ProjectBundle\Entity\Project", $projectId);
   		$this->checkPermission("EDIT", $project);
   		$isAdmin = $this->hasPermission("EDIT", $project);
   		$department = $this->find("PRO4\ProjectBundle\Entity\Department", $departmentId);
   		
   		$em = $this->getDoctrine()->getManager();
   		$form = $this->createFormBuilder()
	        ->add('users', 'entity', array(
			    'class' => 'PRO4UserBundle:User',
			    'property' => 'eMail',
			    'query_builder' => $em->getRepository("PRO4UserBundle:User")->findUsersInProject($project),
			))
			->getForm();
   		
   		$users = $department->getUsers();
   		
   		
   		
   		return $this->render('PRO4ProjectBundle:Department:userInDepartment.html.twig', array("form" => $form->createView(), "isAdmin" => $isAdmin, "project" => $project, "department" => $department, "users" => $users));
   	}
   	
   	public function findBySuperCategoryName($superCategoryName) {
	    return $this->createQueryBuilder('c')
	            ->innerJoin('c.superCategories', 's', 'WITH', 's.name = :superCategoryName')
	            ->setParameter('superCategoryName', $superCategoryName);
	}
   
}
