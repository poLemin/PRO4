<?php

namespace PRO4\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ActivationCode
 *
 * @ORM\Table(name="activation_code")
 * @ORM\Entity
 */
class ActivationCode
{
    /**
     * @var integer
     *
     * @ORM\Column(name="activation_code_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $activationCodeId;
	
	/**
     * @var \User
     *
     * @ORM\OneToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="user_id", nullable=false)
     * })
     */
    private $userId;

    /**
     * @var string
     *
     * @ORM\Column(name="activation_code", type="string", length=40, nullable=true)
     */
    private $activationCode;

    /**
     * Get activationCodeId
     *
     * @return integer 
     */
    public function getActivationCodeId()
    {
        return $this->activationCodeId;
    }

    /**
     * Set activationCode
     *
     * @param string $activationCode
     * @return ActivationCode
     */
    public function setActivationCode($activationCode)
    {
        $this->activationCode = $activationCode;
    
        return $this;
    }

    /**
     * Get activationCode
     *
     * @return string 
     */
    public function getActivationCode()
    {
        return $this->activationCode;
    }

    /**
     * Set userId
     *
     * @param \PRO4\UserBundle\Entity\User $userId
     * @return ActivationCode
     */
    public function setUserId(\PRO4\UserBundle\Entity\User $userId = null)
    {
        $this->userId = $userId;
    
        return $this;
    }

    /**
     * Get userId
     *
     * @return \PRO4\UserBundle\Entity\User 
     */
    public function getUserId()
    {
        return $this->userId;
    }
}