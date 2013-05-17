<?php

namespace PRO4\EventBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('PRO4EventBundle:Default:index.html.twig');
    }
}