<?php

namespace Openpp\ToppageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($id = null)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user->hasRole('ROLE_USER')) {
            return $this->render('OpenppToppageBundle:Default:index.html.twig');
        }

        $targetUser = $user;
        if ($id && $id != $user->getId()) {
            $targetUser = $this->get('fos_user.user_manager')->findUserBy(array('id' => $id));
            if (!$targetUser) {
                throw $this->createNotFoundException();
            }
        }

        return $this->render('ApplicationSonataUserBundle::user.html.twig', array(
            'user'   => $user,
            'targetUser' => $targetUser
        ));
    }
}
