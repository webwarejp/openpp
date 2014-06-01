<?php

namespace Acme\HelpBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Acme\HelpBundle\Entity\Contact;
use Acme\HelpBundle\Form\ContactType;

class ContactController extends Controller
{
    public function indexAction()
    {
        $contact = new Contact();
        $form = $this->createFormBuilder($contact)
            ->getForm();
        return $this->render('AcmeHelpBundle:Contact:index.html.twig', array('form' => $form->createView()));
    }

}
