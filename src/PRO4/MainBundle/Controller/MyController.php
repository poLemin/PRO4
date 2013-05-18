<?php

namespace PRO4\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class MyController extends Controller {

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
}
