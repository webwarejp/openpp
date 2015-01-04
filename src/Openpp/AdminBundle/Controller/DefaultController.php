<?php

namespace Openpp\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('OpenppAdminBundle:Default:index.html.twig');
    }

    public function loginAction($name)
    {
        return $this->render('OpenppAdminBundle:Default:index.html.twig');
    }
}
