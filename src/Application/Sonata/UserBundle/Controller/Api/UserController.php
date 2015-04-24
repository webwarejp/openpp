<?php

namespace Application\Sonata\UserBundle\Controller\Api;

use Sonata\UserBundle\Model\UserManagerInterface;
use Symfony\Component\DependencyInjection\ContainerAware;
use Sonata\UserBundle\Model\UserInterface;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class UserController extends ContainerAware
{
    /**
     * @ApiDoc(
     *  description="Retrieves a specific user"
     * )
     */
    public function getMeAction()
    {
        $me = $this->get('security.context')->getToken()->getUser();

        if (false === $me instanceof UserInterface) {
            throw new NotFoundHttpException('User not found.');
        }

        $view = View::create();
        $view->setData(array('uid' => $me->getId()))
             ->setFormat('json');

        return $view;
    }
}