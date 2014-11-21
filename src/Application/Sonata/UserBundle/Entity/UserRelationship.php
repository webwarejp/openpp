<?php

namespace Application\Sonata\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserRelationship
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Application\Sonata\UserBundle\Entity\UserRelationshipRepository")
 */
class UserRelationship
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_friend", type="boolean")
     */
    private $isFriend;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_friend_pre", type="boolean")
     */
    private $isFriendPre;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_access_block", type="boolean")
     */
    private $isAccessBlock;

    /**
     * @var \Application\Sonata\UserBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id_from", referencedColumnName="id")
     */
    private $userFrom;

    /**
     * @var \Application\Sonata\UserBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id_to", referencedColumnName="id")
     */
    private $userTo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;

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
     * Set isFriend
     *
     * @param boolean $isFriend
     * @return UserRelationship
     */
    public function setIsFriend($isFriend)
    {
        $this->isFriend = $isFriend;
    
        return $this;
    }

    /**
     * Get isFriend
     *
     * @return boolean 
     */
    public function getIsFriend()
    {
        return $this->isFriend;
    }

    /**
     * Set isFriendPre
     *
     * @param boolean $isFriendPre
     * @return UserRelationship
     */
    public function setIsFriendPre($isFriendPre)
    {
        $this->isFriendPre = $isFriendPre;

        return $this;
    }

    /**
     * Get isFriendPre
     *
     * @return boolean 
     */
    public function getIsFriendPre()
    {
        return $this->isFriendPre;
    }

    /**
     * Set isAccessBlock
     *
     * @param boolean $isAccessBlock
     * @return UserRelationship
     */
    public function setIsAccessBlock($isAccessBlock)
    {
        $this->isAccessBlock = $isAccessBlock;

        return $this;
    }

    /**
     * Get isAccessBlock
     *
     * @return boolean 
     */
    public function getIsAccessBlock()
    {
        return $this->isAccessBlock;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return UserRelationship
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return UserRelationship
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set userFrom
     *
     * @param \Application\Sonata\UserBundle\Entity\User $userFrom
     * @return UserRelationship
     */
    public function setUserFrom($userFrom)
    {
        $this->userFrom = $userFrom;

        return $this;
    }

    /**
     * Get userFrom
     *
     * @return \Application\Sonata\UserBundle\Entity\User
     */
    public function getUserFrom()
    {
        return $this->userFrom;
    }

    /**
     * Set userTo
     *
     * @param \Application\Sonata\UserBundle\Entity\User $userTo
     * @return UserRelationship
     */
    public function setUserTo($userTo)
    {
        $this->userTo = $userTo;

        return $this;
    }

    /**
     * Get user_to
     *
     * @return \Application\Sonata\UserBundle\Entity\User
     */
    public function getUserTo()
    {
        return $this->userTo;
    }
}
