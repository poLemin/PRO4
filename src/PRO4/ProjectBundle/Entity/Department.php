<?php

namespace PRO4\ProjectBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Department
 *
 * @ORM\Table(name="department")
 * @ORM\Entity
 */
class Department
{
    /**
     * @var integer
     *
     * @ORM\Column(name="department_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $departmentId;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=40, nullable=false)
     * @Assert\NotBlank()
     * @Assert\Length(min = "3", max = "40")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="color", type="string", length=6, nullable=false)
     * 
     * @Assert\NotBlank()
     * @Assert\Length(min = "6", max = "6")
     */
    private $color;

    /**
     * @var \Project
     *
     * @ORM\ManyToOne(targetEntity="Project", inversedBy="departments")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="project_id", referencedColumnName="project_id", nullable=false)
     * })
     */
    private $project;
	
	/**
     * @ORM\ManyToMany(targetEntity="PRO4\UserBundle\Entity\User")
     * @ORM\JoinTable(name="user_in_department",
     *      joinColumns={@ORM\JoinColumn(name="department_id", referencedColumnName="department_id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="user_id")}
     *      )
     **/
	private $users;

	public function __construct()
	{
		$this->users = new ArrayCollection();
	}

    /**
     * Get departmentId
     *
     * @return integer 
     */
    public function getDepartmentId()
    {
        return $this->departmentId;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Department
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
     * Set color
     *
     * @param string $color
     * @return Department
     */
    public function setColor($color)
    {
        $this->color = $color;
    
        return $this;
    }

    /**
     * Get color
     *
     * @return string 
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set projekt
     *
     * @param \PRO4\ProjectBundle\Entity\Project $project
     * @return Department
     */
    public function setProject(\PRO4\ProjectBundle\Entity\Project $project = null)
    {
        $this->project = $project;
    
        return $this;
    }

    /**
     * Get projekt
     *
     * @return \PRO4\ProjectBundle\Entity\Project 
     */
    public function getProject()
    {
        return $this->project;
    }
	
	public function getUsers()
	{
		return $this->users;
	}

    /**
     * Add users
     *
     * @param \PRO4\UserBundle\Entity\User $users
     * @return Department
     */
    public function addUser(\PRO4\UserBundle\Entity\User $users)
    {
        $this->users[] = $users;
    
        return $this;
    }

    /**
     * Remove users
     *
     * @param \PRO4\UserBundle\Entity\User $users
     */
    public function removeUser(\PRO4\UserBundle\Entity\User $users)
    {
        $this->users->removeElement($users);
    }
}