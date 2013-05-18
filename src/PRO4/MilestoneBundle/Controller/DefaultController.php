<?php

namespace PRO4\MilestoneBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('PRO4MilestoneBundle:Default:index.html.twig', array('name' => $name));
    }
}
