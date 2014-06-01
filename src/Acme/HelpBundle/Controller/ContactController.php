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
/*
        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            if ($form->isValid()) {
                // データベースへの保存など、何らかのアクションを実行する

                //return $this->redirect($this->generateUrl('store_product_success'));
            }
        }
*/
        return $this->render('AcmeHelpBundle:Contact:index.html.twig', array('form' => $form->createView()));
    }

}
