<?php
namespace Acme\HelpBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\Type;
use Acme\HelpBundle\Entity\Team;

/**
 * @ORM\Entity(repositoryClass="Acme\HelpBundle\Entity\Repository\ContactRepository"))
 * @ORM\Table(name="contact")
 * @ORM\HasLifecycleCallbacks()
 * @ExclusionPolicy("none")
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
     * @Type("string")
     * @ORM\Column(type="string")
     */
    protected $username;
    /**
     * @Type("string")
     * @ORM\Column(type="string")
     */
    protected $mailaddress;
    /**
     * @Type("string")
     * @ORM\Column(type="string")
     */
    protected $body;

    /**
     * @Type("string")
     * @ORM\Column(type="string")
     */
    protected $gender;

    /**
     * **
     * @ORM\ManyToOne(targetEntity="Team")
     * @ORM\JoinColumn(name="team_id", referencedColumnName="id")
     **/
    protected $team;

    /**
     * @Type("array")
     * @ORM\Column(type="array")
     */
    protected $availability;
    /**
     * @Type("DateTime")
     * @ORM\Column(type="datetime")
     */
    protected $created;

    function __construct()
    {
        $this->setCreated(new \DateTime());
    }
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

    /**
     * Set gender
     *
     * @param string $gender
     * @return Contact
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    
        return $this;
    }

    /**
     * Get gender
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set availability
     *
     * @param string $availability
     * @return Contact
     */
    public function setAvailability($availability)
    {
        $this->availability = $availability;
    
        return $this;
    }

    /**
     * Get availability
     *
     * @return string 
     */
    public function getAvailability()
    {
        return $this->availability;
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedValue()
    {
        $this->setCreated(new \DateTime());
    }

    /**
     * Set team
     *
     * @param \Acme\HelpBundle\Entity\Team $team
     * @return Contact
     */
    public function setTeam(\Acme\HelpBundle\Entity\Team $team = null)
    {
        $this->team = $team;
    
        return $this;
    }

    /**
     * Get team
     *
     * @return \Acme\HelpBundle\Entity\Team 
     */
    public function getTeam()
    {
        return $this->team;
    }
}