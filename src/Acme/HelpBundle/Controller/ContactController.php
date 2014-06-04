<?php

namespace Acme\HelpBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Acme\HelpBundle\Entity\Contact;
use Acme\HelpBundle\Form\ContactType;
use Acme\HelpBundle\Form\ContactHiddenType;
use Symfony\Component\BrowserKit\Request;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerBuilder;
use Symfony\Component\Validator\Constraints\NotBlank;

/*
 * 【済み】一旦、確認画面のjsonでの組み上げをする
 * view data transformerを使って、viewに変換する。getViewDataでデータを変換できるようにする。
 * すべてのフォームタイプに対応する。（画像、コレクション）
 * カスタムフォームタイプに対応する方法の検討(captca)
 * jmsシリアライザーでjsonにシリアライズする？
 */

class ContactController extends Controller
{
    /*
     * @todo DIを使うと可読性が下がるかも。どこのサービスに依存しているかをコントローラーから紐解いていけるようにしたい。
     * @Todo captcha
     * @Todo fileType
     * @Todo collectionType
     * @Todo use entity manager
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $contact = new Contact();
        $form = $this->createForm('acme_helpbundle_contact', $contact, array(
            'em' => $this->getDoctrine()->getManager(),
        ));
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->submit($request);
            //hiddenにjsonをセットしつつ、attrにdisable=> trueを設定
            if ($form->isValid()) {
                $serializer = SerializerBuilder::create()->build();
                $jsonContent = $serializer->serialize($form->getData(), 'json', SerializationContext::create()->enableMaxDepthChecks());
                $this->get('session')->getFlashBag()->add('entity-json', $jsonContent);
                return $this->redirect($this->generateUrl('help_contact_confirm'));
            }
        }
        return $this->render('AcmeHelpBundle:Contact:index.html.twig', array('form' => $form->createView()));
    }

    /*
     * @Todo 多言語化
     * @Todo viewDataTranslater化
     * @Todo
    */
    public function confirmAction()
    {
        $flashBag = $this->get('session')->getFlashBag();
        $form = $this->createFormBuilder()->add('public', 'checkbox', array(
                'label' => '個人情報の取り扱いに同意する',
                'required' => false,
                'mapped' => false,
                'constraints' => new NotBlank(array('message' => '入力して下さい。')),
            ))->getForm();

        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->submit($request);
            if ($form->isValid()) {
                $serializer = SerializerBuilder::create()->build();
                $jsonContent = $flashBag->getFlashBag()->get('entity-json');
                $contact = $serializer->deserialize($jsonContent[0], 'Acme\HelpBundle\Entity\Contact', 'json');
                $em = $this->getDoctrine()
                    ->getManager();
                $em->persist($contact);
                $em->flush();
                $flashBag->add('contact-notice', 'Your contact enquiry was successfully sent. Thank you!');
                //完了画面へリダイレクト
                return $this->redirect($this->generateUrl('help_contact_confirm'));
            }
        }
        if ($this->get('session')->getFlashBag()->has('entity-json')) {
            //セッションに再設定
            $flashBag->set('entity-json', $flashBag->get('entity-json'));
        }
        /*
         * @Todo dataがうまくjavascrit側に渡っていない
         */
        return $this->render('AcmeHelpBundle:Contact:confirm.html.twig', array('form' => $form->createView(),
            'mydata' => $this->get('session')->get('sessionjson')));
    }

}
