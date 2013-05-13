<?php

namespace PRO4\LoginBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserInProject
 *
 * @ORM\Table(name="user_in_project")
 * @ORM\Entity
 */
class UserInProject
{
    /**
     * @var integer
     *
     * @ORM\Column(name="user_in_project_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $userInProjectId;

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
     * @var \Project
     *
     * @ORM\ManyToOne(targetEntity="Project")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="project_id", referencedColumnName="project_id")
     * })
     */
    private $project;

    /**
     * @var \Role
     *
     * @ORM\ManyToOne(targetEntity="Role")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="role_id", referencedColumnName="role_id")
     * })
     */
    private $role;



    /**
     * Get userInProjectId
     *
     * @return integer 
     */
    public function getUserInProjectId()
    {
        return $this->userInProjectId;
    }

    /**
     * Set user
     *
     * @param \PRO4\LoginBundle\Entity\User $user
     * @return UserInProject
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
     * Set project
     *
     * @param \PRO4\LoginBundle\Entity\Project $project
     * @return UserInProject
     */
    public function setProject(\PRO4\LoginBundle\Entity\Project $project = null)
    {
        $this->project = $project;
    
        return $this;
    }

    /**
     * Get project
     *
     * @return \PRO4\LoginBundle\Entity\Project 
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * Set role
     *
     * @param \PRO4\LoginBundle\Entity\Role $role
     * @return UserInProject
     */
    public function setRole(\PRO4\LoginBundle\Entity\Role $role = null)
    {
        $this->role = $role;
    
        return $this;
    }

    /**
     * Get role
     *
     * @return \PRO4\LoginBundle\Entity\Role 
     */
    public function getRole()
    {
        return $this->role;
    }
}