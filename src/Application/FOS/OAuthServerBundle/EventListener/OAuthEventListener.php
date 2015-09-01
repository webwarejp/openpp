<?php

namespace Application\FOS\OAuthServerBundle\EventListener;

use Application\FOS\OAuthServerBundle\Entity\UserClient;
use FOS\OAuthServerBundle\Event\OAuthEvent;
use Symfony\Component\DependencyInjection\Container;

/**
 * Class OAuthEventListener
 * @package Application\FOS\OAuthServerBundle\EventListener
 */
class OAuthEventListener
{
    /**
     * @var Container
     */
    private $container;
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->em = $this->container->get('doctrine')->getManager();
    }

    /**
     * called fos_oauth_server.pre_authorization_process
     *
     * 1. user_client の日付が null でなければ認可する。
     * 2. client が isPrivate trueのとき認可する。
     *
     * @param OAuthEvent $event
     */
    public function onPreAuthorizationProcess(OAuthEvent $event)
    {
        if ($user_client = $this->getUserClient($event))
        {
            if($user_client->getCreatedAt() !== null)
            {
                $event->setAuthorizedClient(true);
            }

            if(null !== $client = $event->getClient())
            {
                if ($client->isPrivate())
                {
                    $event->setAuthorizedClient(true);
                }
            }
        }
    }

    /**
     * called fos_oauth_server.post_authorization_process
     *
     * @param OAuthEvent $event
     */
    public function onPostAuthorizationProcess(OAuthEvent $event)
    {
        if ($event->isAuthorizedClient())
        {
            if (null !== $client = $event->getClient())
            {
                $user_client = $this->getUserClient($event);
                if($user_client->getCreatedAt() == null)
                {
                    $this->em->persist($user_client);
                    $this->em->flush();
                }
            }
        }
    }

    /**
     * retrive UserClient from event or create
     *
     * @param OAuthEvent $event
     * @return UserClient
     */
    protected function getUserClient(OAuthEvent $event)
    {
        return $this->em->getRepository('ApplicationFOSOAuthServerBundle:UserClient')->getUserClient($event);
    }
}