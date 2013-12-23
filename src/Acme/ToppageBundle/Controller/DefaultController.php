<?php

namespace Acme\ToppageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('AcmeToppageBundle:Default:index.html.twig');
    }
}
