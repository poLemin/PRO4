<?php

namespace PRO4\LoginBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

use PRO4\LoginBundle\Entity\User;

class LoginController extends Controller {

    public function indexAction(Request $request) {	
		return $this->redirect($this->generateUrl("login"));
    }
	
	public function logoutAction() {
		// security-layer will do the rest
	}
	
	public function loginAction()	{
		$request = $this->getRequest();
        $session = $request->getSession();

        // get the login error if there is one
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(
                SecurityContext::AUTHENTICATION_ERROR
            );
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }
		
		$error = $error ? "E-Mail and Password do not match!" : "";
		
        return $this->render(
            'PRO4LoginBundle:Login:login.html.twig',
            array(
                "last_email" => $session->get(SecurityContext::LAST_USERNAME),
                "error"      => $error
            )
        );
	}
	
	public function registerAction(Request $request) {
		$form = $this->createFormBuilder()
			->add('email', 'email', array(
			   'constraints' => array(new NotBlank(), new Email()),
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
				$data = $form->getData();
				$user = new User();
				$user->setEMail($data["email"]);
				
				$factory = $this->get('security.encoder_factory');
				$encoder = $factory->getEncoder($user);
				$password = $encoder->encodePassword($data["password"], $user->getSalt());
				$user->setPassword($password);
				
				$em = $this->getDoctrine()->getManager();
				$em->persist($user);
				$em->flush();
				
				return $this->redirect($this->generateUrl("login"));
			}
        }
		
		return $this->render('PRO4LoginBundle:Login:register.html.twig', array("form" => $form->createView()));
	}
}
