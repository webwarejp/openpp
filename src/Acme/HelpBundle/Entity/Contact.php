<?php
namespace Acme\HelpBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Acme\HelpBundle\Entity\Repository\ContactRepository"))
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


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set username
     *
     * @param string $username
     * @return Contact
     */
    public function setUsername($username)
    {
        $this->username = $username;
    
        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set mailaddress
     *
     * @param string $mailaddress
     * @return Contact
     */
    public function setMailaddress($mailaddress)
    {
        $this->mailaddress = $mailaddress;
    
        return $this;
    }

    /**
     * Get mailaddress
     *
     * @return string 
     */
    public function getMailaddress()
    {
        return $this->mailaddress;
    }

    /**
     * Set body
     *
     * @param string $body
     * @return Contact
     */
    public function setBody($body)
    {
        $this->body = $body;
    
        return $this;
    }

    /**
     * Get body
     *
     * @return string 
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Contact
     */
    public function setCreated($created)
    {
        $this->created = $created;
    
        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }
}