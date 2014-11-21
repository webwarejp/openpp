<?php

namespace Application\Sonata\UserBundle\Controller;

use FOS\UserBundle\Model\UserInterface;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class FriendController extends FOSRestController
{
    public function requestAction(Request $request)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        if (!$id = $request->get('id', null)) {
            throw $this->createNotFoundException('Request parameter id is not found.');
        }

        if ($id == $user->getId()) {
            throw new BadRequestHttpException('Request parameter id is invalid.');
        }

        $targetUser = $this->get('fos_user.user_manager')->findUserBy(array('id' => $id));
        if (!is_object($targetUser) || !$targetUser instanceof UserInterface) {
            throw $this->createNotFoundException('Target user is not found.');
        }

        $actionManager = $this->get('spy_timeline.action_manager');
        $subject       = $actionManager->findOrCreateComponent($user);
        $from          = $actionManager->findOrCreateComponent($targetUser);
        $action        = $actionManager->create($subject, 'receive', array('indirectComplement' => $from));
        $actionManager->updateAction($action);

        return $this->view(array('id' => $id));
    }

    public function acceptAction(Request $request)
    {
        
    }
}