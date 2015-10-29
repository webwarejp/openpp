<?php

namespace Application\Openpp\OAuthServerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Openpp\OAuthServerBundle\Entity\AuthCode as BaseAuthCode;

/**
 * @ORM\Table(name="oauth_auth_code")
 * @ORM\Entity
 */
class AuthCode extends BaseAuthCode
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Openpp\OAuthServerBundle\Entity\Client")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $client;

    /**
     * @ORM\ManyToOne(targetEntity="Application\Sonata\UserBundle\Entity\User")
     */
    protected $user;
}