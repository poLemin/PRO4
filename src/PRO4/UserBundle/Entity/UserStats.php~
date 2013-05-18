<?php

namespace PRO4\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserStats
 *
 * @ORM\Table(name="user_stats")
 * @ORM\Entity
 */
class UserStats
{
    /**
     * @var integer
     *
     * @ORM\Column(name="user_stats_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $userStatsId;

    /**
     * @var boolean
     *
     * @ORM\Column(name="online", type="boolean", nullable=false)
     */
    private $online;

    /**
     * @var \User
     *
     * @ORM\OneToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="user_id", nullable=false, unique=true)
     * })
     */
    private $user;



    /**
     * Get userStatsId
     *
     * @return integer 
     */
    public function getUserStatsId()
    {
        return $this->userStatsId;
    }

    /**
     * Set online
     *
     * @param boolean $online
     * @return UserStats
     */
    public function setOnline($online)
    {
        $this->online = $online;
    
        return $this;
    }

    /**
     * Get online
     *
     * @return boolean 
     */
    public function getOnline()
    {
        return $this->online;
    }

    /**
     * Set user
     *
     * @param \PRO4\UserBundle\Entity\User $user
     * @return UserStats
     */
    public function setUser(\PRO4\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \PRO4\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}