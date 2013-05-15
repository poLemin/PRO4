<?php

namespace PRO4\ProjectBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('PRO4ProjectBundle:Default:index.html.twig');
    }
}
