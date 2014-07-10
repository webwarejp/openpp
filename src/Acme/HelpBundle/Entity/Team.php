<?php

namespace Acme\HelpBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Acme\HelpBundle\Entity\Contact;
/**
 * Test
 * @ORM\Entity
 * @ORM\Table(name="team")
 */
class Team
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\Column(type="string")
     */
    private $league;

    public function __toString()
    {
        return $this->getName();
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
     * Set id
     *
     * @param integer $id
     * @return Team
     */
    public function setId($id)
    {
        $this->id = $id;
    
        return $this;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Team
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set league
     *
     * @param string $league
     * @return Team
     */
    public function setLeague($league)
    {
        $this->league = $league;
    
        return $this;
    }

    /**
     * Get league
     *
     * @return string 
     */
    public function getLeague()
    {
        return $this->league;
    }
}