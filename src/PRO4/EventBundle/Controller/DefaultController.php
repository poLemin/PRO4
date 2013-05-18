<?php

namespace PRO4\EventBundle\Controller;

use PRO4\MainBundle\Controller\MyController;

class DefaultController extends MyController
{
    public function indexAction()
    {
        return $this->render('PRO4EventBundle:Default:index.html.twig');
    }
}