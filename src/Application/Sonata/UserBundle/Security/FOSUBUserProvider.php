<?php

namespace Application\Sonata\UserBundle\Security;

use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider as BaseProvider;
use Symfony\Component\Security\Core\User\UserInterface;

class FOSUBUserProvider extends BaseProvider
{
    /**
     * (non-PHPdoc)
     * @see \HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider::loadUserByOAuthUserResponse()
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $username = $response->getUsername();
        $service = $response->getResourceOwner()->getName();

        $user = $this->userManager->findUserBy(array($this->getProperty($response) => $username));
        //when the user is registrating
        if (null === $user) {
            $setter = 'set'.ucfirst($this->getProperty($response));
            // create new user here
            $user = $this->userManager->createUser();
            $user->$setter($username);
            //I have set all requested data with the user's username
            //modify here with relevant data
            $user->setUsername($response->getEmail());
            $user->setEmail($response->getEmail());
            $setter_name = 'set'.ucfirst($service).'Name';
            $user->$setter_name($response->getRealName());
            $user->setPassword($username);
            $user->setEnabled(true);
            $this->userManager->updateUser($user);
        }

        return $user;
    }

    /**
     * (non-PHPdoc)
     * @see \HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider::connect()
     */
    public function connect(UserInterface $user, UserResponseInterface $response)
    {
        $property = $this->getProperty($response);
        $setter = 'set'.ucfirst($property);

        if (!method_exists($user, $setter)) {
            throw new \RuntimeException(sprintf("Class '%s' should have a method '%s'.", get_class($user), $setter));
        }

        $username = $response->getUsername();

        if (null !== $previousUser = $this->userManager->findUserBy(array($property => $username))) {
            $previousUser->$setter(null);
            $this->userManager->updateUser($previousUser);
        }

        $user->$setter($username);

        $service = $response->getResourceOwner()->getName();
        $setter_name = 'set'.ucfirst($service).'Name';
        $user->$setter_name($response->getRealName());

        $this->userManager->updateUser($user);
    }
}