<?php
namespace Openpp\UserBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;

use Doctrine\ORM\Mapping as ORM;

use Fp\OpenIdBundle\Entity\UserIdentity as BaseUserIdentity;
use Fp\OpenIdBundle\Model\UserIdentityInterface;
use Acme\UserBundle\Entity\User;

/**
 * @ORM\Entity
 * @ORM\Table(name="openid_identities")
 */
class OpenIdIdentity extends BaseUserIdentity
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
      * The relation is made eager by purpose. 
      * More info here: {@link https://github.com/formapro/FpOpenIdBundle/issues/54}
      * 
      * @var Symfony\Component\Security\Core\User\UserInterface
      *
      * @ORM\ManyToOne(targetEntity="Openpp\UserBundle\Entity\User", fetch="EAGER")
      * @ORM\JoinColumns({
      *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
      * })
      */
    protected $user;

    /*
     * It inherits an "identity" string field,
     * and an "attributes" text field
     */

    public function __construct()
    {
        parent::__construct();
        // your own logic (nothing for this example)
    }
}
