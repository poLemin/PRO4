<?php

namespace PRO4\ToDoListBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('PRO4ToDoListBundle:Default:index.html.twig', array('name' => $name));
    }
}
