<?php

namespace Openpp\TimelineBundle\Entity;

use Spy\TimelineBundle\Entity\Action as BaseAction;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="timeline_action")
 */
class Action extends BaseAction
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="Openpp\TimelineBundle\Entity\ActionComponent", mappedBy="action", cascade={"persist"})
     */
    protected $actionComponents;

    /**
     * @ORM\OneToMany(targetEntity="Openpp\TimelineBundle\Entity\Timeline", mappedBy="action")
     */
    protected $timelines;
}