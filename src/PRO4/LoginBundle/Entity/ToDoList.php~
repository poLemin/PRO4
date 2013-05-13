<?php

namespace PRO4\LoginBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ToDoList
 *
 * @ORM\Table(name="to-do-list")
 * @ORM\Entity
 */
class ToDoList
{
    /**
     * @var integer
     *
     * @ORM\Column(name="to-do-list_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $toDoListId;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=40, nullable=false)
     */
    private $name;

    /**
     * @var boolean
     *
     * @ORM\Column(name="completed", type="boolean", nullable=false)
     */
    private $completed;

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
     * @var \Project
     *
     * @ORM\ManyToOne(targetEntity="Project")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="project_id", referencedColumnName="project_id")
     * })
     */
    private $project;



    /**
     * Get toDoListId
     *
     * @return integer 
     */
    public function getToDoListId()
    {
        return $this->toDoListId;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return ToDoList
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
     * Set completed
     *
     * @param boolean $completed
     * @return ToDoList
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
     * Set department
     *
     * @param \PRO4\LoginBundle\Entity\Department $department
     * @return ToDoList
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

    /**
     * Set project
     *
     * @param \PRO4\LoginBundle\Entity\Project $project
     * @return ToDoList
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
}