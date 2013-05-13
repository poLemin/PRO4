<?php

namespace PRO4\LoginBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ListItem
 *
 * @ORM\Table(name="list_item")
 * @ORM\Entity
 */
class ListItem
{
    /**
     * @var integer
     *
     * @ORM\Column(name="list_item_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $listItemId;

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
     * @var \ToDoList
     *
     * @ORM\ManyToOne(targetEntity="ToDoList")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="to-do-list_id", referencedColumnName="to-do-list_id")
     * })
     */
    private $toDoList;



    /**
     * Get listItemId
     *
     * @return integer 
     */
    public function getListItemId()
    {
        return $this->listItemId;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return ListItem
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
     * @return ListItem
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
     * Set toDoList
     *
     * @param \PRO4\LoginBundle\Entity\ToDoList $toDoList
     * @return ListItem
     */
    public function setToDoList(\PRO4\LoginBundle\Entity\ToDoList $toDoList = null)
    {
        $this->toDoList = $toDoList;
    
        return $this;
    }

    /**
     * Get toDoList
     *
     * @return \PRO4\LoginBundle\Entity\ToDoList 
     */
    public function getToDoList()
    {
        return $this->toDoList;
    }
}