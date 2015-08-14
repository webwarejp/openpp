<?php
/**
 * Created by PhpStorm.
 * User: taniguchi
 * Date: 8/12/15
 * Time: 18:15
 */
namespace Application\FOS\OAuthServerBundle\Form\Handler;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Application\FOS\OAuthServerBundle\Form\Model\Authorize;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use OAuth2\OAuth2;
use OAuth2\OAuth2ServerException;
use OAuth2\OAuth2RedirectException;

class AuthorizeFormHandler
{
    protected $request;
    protected $form;
    protected $token;
    protected $oauth2;

    public function __construct(Form $form, Request $request, TokenStorageInterface $token, OAuth2 $oauth2)
    {
        $this->form = $form;
        $this->request = $request;
        $this->token = $token;
        $this->oauth2 = $oauth2;
    }

    public function process(Authorize $authorize)
    {
        $this->form->setData($authorize);

        if ($this->request->getMethod() == 'POST') {

            $this->form->handleRequest($this->request);

            if ($this->form->isValid()) {

                try {
                    $user = $this->token->getToken()->getUser();

                    //@TODO $user の型の確認

                    return $this->oauth2->finishClientAuthorization(true, $user, $this->request, null);
                } catch (OAuth2ServerException $e) {
                    return $e->getHttpResponse();
                }

            }

        }

        return false;
    }

}
