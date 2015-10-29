<?php

namespace Application\Openpp\OAuthServerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Openpp\OAuthServerBundle\Entity\AccessToken as BaseAccessToken;

/**
 * @ORM\Table(name="oauth_access_token")
 * @ORM\Entity
 */
class AccessToken extends BaseAccessToken
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Openpp\OAuthServerBundle\Entity\Client")
     * @ORM\JoinColumn(name="client_id",referencedColumnName="id",nullable=false)
     */
    protected $client;

    /**
     * @ORM\ManyToOne(targetEntity="Application\Sonata\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id",referencedColumnName="id")
     */
    protected $user;

}