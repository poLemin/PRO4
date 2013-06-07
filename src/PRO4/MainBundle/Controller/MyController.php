<?php

namespace PRO4\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

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
    
    public function checkPermission($permission, $object) {
    	if($this->get('security.context')->isGranted($permission, $object) === FALSE) {
   			throw new AccessDeniedException();
   		}
    }
}
