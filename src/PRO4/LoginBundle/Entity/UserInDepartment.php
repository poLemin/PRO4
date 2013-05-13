<?php

namespace PRO4\LoginBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserInDepartment
 *
 * @ORM\Table(name="user_in_department")
 * @ORM\Entity
 */
class UserInDepartment
{
    /**
     * @var integer
     *
     * @ORM\Column(name="user_in_department_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $userInDepartmentId;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="user_id")
     * })
     */
    private $user;

    /**
     * @var \Department
     *
     * @ORM\ManyToOne(targetEntity="Department")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="department_id", referencedColumnName="department_id")
     * })
     */
    private $department;



    /**
     * Get userInDepartmentId
     *
     * @return integer 
     */
    public function getUserInDepartmentId()
    {
        return $this->userInDepartmentId;
    }

    /**
     * Set user
     *
     * @param \PRO4\LoginBundle\Entity\User $user
     * @return UserInDepartment
     */
    public function setUser(\PRO4\LoginBundle\Entity\User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \PRO4\LoginBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set department
     *
     * @param \PRO4\LoginBundle\Entity\Department $department
     * @return UserInDepartment
     */
    public function setDepartment(\PRO4\LoginBundle\Entity\Department $department = null)
    {
        $this->department = $department;
    
        return $this;
    }

    /**
     * Get department
     *
     * @return \PRO4\LoginBundle\Entity\Department 
     */
    public function getDepartment()
    {
        return $this->department;
    }
}