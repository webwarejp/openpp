<?php

namespace Acme\HelpBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ContactController extends Controller
{
    public function indexAction()
    {

        return $this->render('AcmeHelpBundle:Contact:index.html.twig');
    }

}
