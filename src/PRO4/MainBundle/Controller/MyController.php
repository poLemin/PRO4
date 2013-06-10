<?php

namespace PRO4\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use Symfony\Component\Security\Acl\Exception\AclNotFoundException;

class MyController extends Controller {
	public function getUser() {
		return $this->get('security.context')->getToken()->getUser();
	}

    public function render($view, array $parameters = array(), Response $response = null) {
    	
    	$status = array();
    	$session = $this->get("session");
    	
    	if ($session->isStarted()) {
	   		foreach ($session->getFlashBag()->all() as $type => $messages) {
			    foreach ($messages as $message) {
			        $status[$type][] = $message;
			    }
			}
    	}
		
		$parameters["status"] = $status;
		
		return parent::render($view, $parameters, $response);
    }
    
    public function isAuthenticatedFully() {
    	return $this->get('security.context')->isGranted("IS_AUTHENTICATED_FULLY");
    }
    
    public function find($class, $id) {
    	$em = $this->getDoctrine()->getManager();
   		$object = $em->find($class, $id);
		if (!$object) {
	        throw new AccessDeniedException();
	    }
	    
	    return $object;
    }
    
    public function addPermission($object, $mask, $user) {
    	$aclProvider = $this->get('security.acl.provider');
    	$objectIdentity = ObjectIdentity::fromDomainObject($object);
    	
    	try {
		    $acl = $aclProvider->findAcl($objectIdentity);
		} catch (AclNotFoundException $e) {
		    $acl = $aclProvider->createAcl($objectIdentity);
		}

		$securityIdentity = UserSecurityIdentity::fromAccount($user);
        $acl->insertObjectAce($securityIdentity, $mask);
        
        $aclProvider->updateAcl($acl);
    }
    
    public function checkPermission($permission, $object) {
    	if($this->hasPermission($permission, $object) === FALSE) {
   			throw new AccessDeniedException();
   		}
    }
    
    public function hasPermission($permission, $object) {
    	return $this->get('security.context')->isGranted($permission, $object);
    }
}
