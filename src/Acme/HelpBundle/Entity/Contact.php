<?php
namespace Acme\Help\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Acme\Help\Entity\Repository\ContactRepository"))
 * @ORM\Table(name="contact")
 * @ORM\HasLifecycleCallbacks()
 **/
class Contact
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * */
    protected $id;
    /**
     * @ORM\Column(type="string")
     */
    protected $username;
    /**
     * @ORM\Column(type="string")
     */
    protected $mailaddress;
    /**
     * @ORM\Column(type="string")
     */
    protected $body;
    /**
     * @ORM\Column(type="datetime")
     */
    protected $created;

}

