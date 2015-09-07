<?php

namespace Application\Sonata\UserBundle\Controller\Api;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sonata\UserBundle\Model\UserInterface;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
//use Sonata\UserBundle\Controller\Api\UserController as BaseUserController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class UserController extends Controller
{
    /**
     * OAuth2 認証後、ユーザー情報提供エンドポイント
     *
     * @Security("has_role('ROLE_API_USER_ME')")
     * @ApiDoc(
     *  description="Retrieves a specific user",
     * )
     */
    public function getMeAction()
    {
        $tokenManager = $this->get('fos_oauth_server.access_token_manager');
        $accessToken = $tokenManager->findTokenByToken(
            $this->get('security.context')->getToken()->getToken()
        );
        /* @var $me UserInterface */
        $me = $accessToken->getUser();

        if (null === $me) {
            throw new NotFoundHttpException('User is null.');
        }
        if (false === $me instanceof UserInterface) {
            throw new NotFoundHttpException('User not found.');
        }

        $view = View::create();
        $view->setData([
            'uid' => $me->getId()
            , 'username' => $me->getUsername()
        ])
             ->setFormat('json');

        return $view;
    }
}
