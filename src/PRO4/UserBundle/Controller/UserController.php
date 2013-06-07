<?php

namespace PRO4\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('PRO4UserBundle:Default:index.html.twig', array('name' => $name));
    }
}
