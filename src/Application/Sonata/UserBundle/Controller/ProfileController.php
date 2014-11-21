<?php

namespace Application\Sonata\UserBundle\Controller;

use FOS\UserBundle\Model\UserInterface;
use Sonata\UserBundle\Controller\ProfileController as BaseController;

class ProfileController extends BaseController
{
    /**
     * 
     * @throws AccessDeniedException
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editSnsAction()
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        return $this->render('ApplicationSonataUserBundle:Profile:edit_sns.html.twig', array('user' => $user));
    }
}