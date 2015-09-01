<?php
namespace Application\FOS\OAuthServerBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Application\Sonata\UserBundle\Entity\User;
use FOS\OAuthServerBundle\Event\OAuthEvent;

/**
 * UserClientRepository
 *
 */
class UserClientRepository extends EntityRepository
{
    /**
     * @param OAuthEvent $event
     * @return UserClient
     */
    public function getUserClient(OAuthEvent $event)
    {
        $user_client = $this->findOneBy([
            'user' => $event->getUser()->getId()
            , 'client' => $event->getClient()->getId()]);

        if($user_client == null)
        {
            $user_client = new UserClient();
            $user_client->setUser($event->getUser());
            $user_client->setClient($event->getClient());
        }

        return $user_client;
    }
}
