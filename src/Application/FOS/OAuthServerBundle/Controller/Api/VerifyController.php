<?php
namespace Application\FOS\OAuthServerBundle\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class VerifyController extends Controller
{
    /**
     * OAuth2 認証後、ユーザー情報提供エンドポイント
     * [POST] /api/varify/client
     * @ApiDoc(
     *  description="validate client id/client secret/client token and retrive user id",
     * )
     */
    public function postClientAction(Request $request)
    {
        $token = $this->get('security.token_storage')->getToken();

        $params = array();
        $content = $request->getContent();
        if (!empty($content))
        {
            $params = json_decode($content, true); // 2nd param to get as array
        }
        $client_id = $params['client_id'];
        $client_secret = $params['client_secret'];
        $access_token = $params['access_token'];


        if(! $client_id || ! $client_secret || ! $access_token)
        {
            return ['result' => false
                , 'err' => '0'
                , 'err_msg' => 'invalid parameter'
            ];
        }

        $user = $this->getDoctrine()->getRepository('ApplicationFOSOAuthServerBundle:AccessToken')
            ->findByClientAndToken($access_token, $client_id, $client_secret);
        if(! $user ) {
            return [
                'result' => false
                , 'err' => '0'
                , 'err_msg' => 'user not found'
            ];
        } else if (time() > $user['expiresAt']){
            return [
                'result' => false
                , 'err' => '0'
                , 'err_msg' => 'token expired.'
            ];
        } else {
            return [
                'result' => true
                , 'user_id' => $user['id']
                , 'expires_at' => $user['expiresAt']
            ];
        }
    }
}