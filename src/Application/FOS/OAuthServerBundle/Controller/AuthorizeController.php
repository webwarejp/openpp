<?php
/**
 * Created by PhpStorm.
 * User: taniguchi
 * Date: 8/12/15
 * Time: 19:24
 */
namespace Application\FOS\OAuthServerBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use FOS\OAuthServerBundle\Controller\AuthorizeController as BaseAuthorizeController;
use Application\FOS\OAuthServerBundle\Form\Model\Authorize;
use Application\FOS\OAuthServerBundle\Entity\Client;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\UserBundle\Model\UserInterface;

/**
 * Class AuthorizeController
 * @package Application\FOS\OAuthServerBundle\Controller
 */
class AuthorizeController extends BaseAuthorizeController
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function authorizeAction(Request $request)
    {
        if (!$request->get('client_id')) {
            throw new NotFoundHttpException("Client id parameter {$request->get('client_id')} is missing.");
        }

        $clientManager = $this->container->get('fos_oauth_server.client_manager.default');

        /* @var $client Application\FOS\OAuthServerBundle\Entity\Client　*/
        $client = $clientManager->findClientByPublicId($request->get('client_id'));
        if (!($client instanceof Client)) {
            throw new NotFoundHttpException("Client {$request->get('client_id')} is not found.");
        }

        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $form = $this->container->get('application_fos_oauth_server.authorize.form');
        $formHandler = $this->container->get('application_fos_oauth_server.authorize.form_handler');

        $authorize = new Authorize();

        if (($response = $formHandler->process($authorize)) !== false) {
            return $response;
        }

        return $this->container->get('templating')->renderResponse('ApplicationFOSOAuthServerBundle:Authorize:authorize.html.twig', array(
            'form'          => $form->createView(),
            'client'        => $client,
            'action'          => $this->container->get('router')->generate('fos_oauth_server_authorize', array(
                    'client_id' => $request->get('client_id'),
                    'response_type' => $request->get('response_type'),
                    'redirect_uri'  => $request->get('redirect_uri'),
                    'state'         => $request->get('state'),
                    'scope'         => $request->get('scope'),
                    )
                )
            )
        );
    }
}
