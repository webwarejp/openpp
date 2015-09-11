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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Util\SecureRandom;
use FOS\UserBundle\Util\UserManipulator;
use Symfony\Component\HttpFoundation\JsonResponse;

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

        return new JsonResponse([
            'objectId' => $me->getId()
            , 'userName' => $me->getUsername()]);
    }

    /**
     * ユーザー登録
     *
     * anonymousのみ実装
     * http://mb.cloud.nifty.com/doc/current/rest/user/userRegistration.html
     *
     * @TODO facebook等を追加する
     * @param Request $request
     * @Security("has_role('ROLE_API_USER')")
     * @ApiDoc(
     *  description="create user",
     * )
     */
    public function postAction(Request $request)
    {
        $params = array();
        $content = $this->get("request")->getContent();
        if (!empty($content))
        {
            $params = json_decode($content, true); // 2nd param to get as array
        }
        $uuid = $params['authData']['anonymous']['id'];
        $pw   = $params['authData']['anonymous']['pw'];
        /* @var $user UserInterface */
        $user = $this->registerAnonymous($uuid, $pw);

        return new JsonResponse([
            'createDate'=> $user->getCreatedAt()
            , 'objectId'=> $user->getId()
            , 'userName'=> $user->getUsername()
            , 'authData'=> $params['authData']
            , 'updateDate'=> $user->getUpdatedAt()
        ]);
    }

    /**
     * anonymous user
     *
     * @param $uuid
     * @param $pw
     * @return UserInterface
     */
    private function registerAnonymous($uuid, $pw)
    {
        $username   = $uuid;
        $email      = $uuid;
        $password   = $pw;
        $inactive   = false;
        $superadmin = false;

        /* @var $manipulator UserManipulator */
        $manipulator = $this->get('fos_user.util.user_manipulator');
        return $manipulator->create($username, $password, $email, !$inactive, $superadmin);
    }


}
