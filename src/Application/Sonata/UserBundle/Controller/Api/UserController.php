<?php

namespace Application\Sonata\UserBundle\Controller\Api;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
        $tokenManager = $this->container->get('fos_oauth_server.access_token_manager.default');
        $accessToken = $tokenManager->findTokenByToken(
            $this->container->get('security.context')->getToken()->getToken()
        );
        $me = $accessToken->getUser();

        if (null === $me) {
            throw new NotFoundHttpException('User is null.');
        }
        if (false === $me instanceof UserInterface) {
            throw new NotFoundHttpException('User not found.');
        }

        $view = View::create();
        $view->setData(array('uid' => $me->getId()))
             ->setFormat('json');

        return $view;
    }
}
