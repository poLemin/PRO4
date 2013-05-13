<?php

namespace PRO4\LoginBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class LoginController extends Controller {
	private $email = "";
	private $pwd = "";
	private $rPwd = "";
	private $errors = array();

    public function indexAction(Request $request) {
	
		
		$form = $this->createFormBuilder()
			->add('email', 'email', array(
			   'constraints' => new NotBlank(),
			   'label' => "Email")
			)
			->add('password', 'password', array(
				   'constraints' => array(
					   new NotBlank(),
					   new Length(array('min' => 8, 'max' => 30))
				   ),
				   'label' => "Password"
			   )
			)
			->getForm();
		
        if ($request->isMethod('POST')) {
            $form->bind($request);
			if($form->isValid()) {
				processLogin($form->getData());
			}
        }

        return $this->render('PRO4LoginBundle:Login:login.html.twig', $this->getVars("Login", $form));
    }
	
	public function processLogin($data)	{
		return new Response("<html><head></head><body>" . $data . "</body></html>");
		//return $this->redirect($this->generateUrl('pro4_login_homepage'));
	}
	
	public function processRegistration() {
		return $this->redirect($this->generateUrl('pro4_login_homepage'));
	}
	
	public function registerAction(Request $request) {
		$form = $this->createFormBuilder()
			->add('email', 'email', array(
			   'constraints' => new NotBlank(),
			   'label' => "Email")
			)
			->add('password', 'repeated', array(
				'type' => 'password',
				'invalid_message' => 'The password fields must match.',
				'constraints' => new Length(array('min' => 8, 'max' => 30)),
				'required' => true,
				'options' => array(
				   'label' => "Password"
				)
			))->getForm();
	
		if ($request->isMethod('POST')) {
            $form->bind($request);
			if($form->isValid()) {
				processRegistration($form->getData());
			}
        }
		
		return $this->render('PRO4LoginBundle:Login:register.html.twig', $this->getVars("Register", $form));
	}
	
	private function getVars($title, $form) {
		return array(	"email" => $this->email,
						"errors" => $this->errors,
						"title" => $title,
						"form" => $form->createView()
					);
	}
}
