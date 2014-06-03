<?php

namespace Acme\HelpBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Acme\HelpBundle\Entity\Contact;
use Acme\HelpBundle\Form\ContactType;
use Symfony\Component\BrowserKit\Request;

class ContactController extends Controller
{
    public function indexAction()
    {
        $contact = new Contact();
        $form = $this->createForm(new ContactType(), $contact);
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->submit($request);
            if ($form->isValid()) {
                /*
                $message = \Swift_Message::newInstance()
                    ->setSubject('Contact enquiry from OpenPP')
                    ->setFrom('contact@openpp.jp')
                    ->setTo($this->container->getParameter('blogger_blog.emails.contact_email'))
                    ->setBody($this->renderView('AcmeHelpBundle:Contact:contactEmail.txt.twig', array('contact' => $contact)));
                $this->get('mailer')->send($message);
                */
                $em = $this->getDoctrine()
                    ->getManager();
                $em->persist($contact);
                $em->flush();
                $this->get('session')->getFlashBag()->add('contact-notice', 'Your contact enquiry was successfully sent. Thank you!');
            }
        }

        return $this->render('AcmeHelpBundle:Contact:index.html.twig', array('form' => $form->createView()));
    }

}
