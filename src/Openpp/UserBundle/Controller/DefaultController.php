<?php

namespace Openpp\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('OpenppUserBundle:Default:index.html.twig', array('name' => $name));
    }
}
