<?php

namespace PRO4\ProjectBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Project
 *
 * @ORM\Table(name="project")
 * @ORM\Entity
 */
class Project
{
    /**
     * @var integer
     *
     * @ORM\Column(name="project_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $projectId;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=40, nullable=false)
     * 
     * @Assert\NotBlank()
     * @Assert\Length(min = "3", max = "40")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=false)
     * 
     * @Assert\NotBlank()
     * @Assert\Length(min = "20")
     */
    private $description;

    /**
     * @var boolean
     *
     * @ORM\Column(name="completed", type="boolean", nullable=false)
     */
    private $completed;
    
    /**
     * @ORM\ManyToMany(targetEntity="\PRO4\UserBundle\Entity\User", inversedBy="projects")
     * @ORM\JoinTable(name="user_in_project",
     *      joinColumns={@ORM\JoinColumn(name="project_id", referencedColumnName="project_id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="user_id")}
     *      )
     * @ORM\OrderBy({"eMail" = "ASC"})
     */
     private $users;
     
    /**
     * 
     * @ORM\OneToMany(targetEntity="PRO4\ProjectBundle\Entity\Department", mappedBy="project", cascade={"persist"})
     * @ORM\OrderBy({"name" = "ASC"})
     * 
     **/
     private $departments;


	public function __construct() {
		$this->completed = false;
		$this->users = new ArrayCollection();
		$this->departments = new ArrayCollection();
	}
	
	public function getId() {
		return $this->getProjectId();
	}


    /**
     * Get projectId
     *
     * @return integer 
     */
    public function getProjectId()
    {
        return $this->projectId;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Project
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
     * Set description
     *
     * @param string $description
     * @return Project
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set completed
     *
     * @param boolean $completed
     * @return Project
     */
    public function setCompleted($completed)
    {
        $this->completed = $completed;
    
        return $this;
    }

    /**
     * Get completed
     *
     * @return boolean 
     */
    public function getCompleted()
    {
        return $this->completed;
    }

    /**
     * Add users
     *
     * @param \PRO4\UserBundle\Entity\User $users
     * @return Project
     */
    public function addUser(\PRO4\UserBundle\Entity\User $user)
    {
    	if(!$this->users->contains($user)) {
    		$user->addProject($this);
        	$this->users[] = $user;
    	}
    	
        return $this;
    }

    /**
     * Remove users
     *
     * @param \PRO4\UserBundle\Entity\User $users
     */
    public function removeUser(\PRO4\UserBundle\Entity\User $user)
    {
    	$user->removeProject($this);
        $this->users->removeElement($user);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Add department
     *
     * @param \PRO4\ProjectBundle\Entity\Department $department
     * @return Project
     */
    public function addDepartment(\PRO4\ProjectBundle\Entity\Department $department)
    {
        $this->departments[] = $department;
        $department->setProject($this);
    
        return $this;
    }

    /**
     * Remove department
     *
     * @param \PRO4\ProjectBundle\Entity\Department $department
     */
    public function removeDepartment(\PRO4\ProjectBundle\Entity\Department $department)
    {
        $this->departments->removeElement($department);
        $department->setProject(null);
    }

    /**
     * Get departments
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDepartments()
    {
        return $this->departments;
    }
}