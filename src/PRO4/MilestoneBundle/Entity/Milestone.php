<?php

namespace PRO4\MilestoneBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Milestone
 *
 * @ORM\Table(name="milestone")
 * @ORM\Entity
 */
class Milestone
{
    /**
     * @var integer
     *
     * @ORM\Column(name="milestone_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $milestoneId;

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
     * @var \DateTime
     *
     * @ORM\Column(name="start_date", type="date", nullable=false)
     * 
     * @Assert\NotBlank()
     */
    private $startDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_date", type="date", nullable=false)
     * 
     * @Assert\NotBlank()
     */
    private $endDate;

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
     * @var \MilestonePlan
     *
     * @ORM\ManyToOne(targetEntity="MilestonePlan")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="milestone_plan_id", referencedColumnName="milestone_plan_id", nullable=false)
     * })
     */
    private $milestonePlan;



    /**
     * Get milestoneId
     *
     * @return integer 
     */
    public function getMilestoneId() {
        return $this->milestoneId;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Milestone
     */
    public function setName($name) {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set startDate
     *
     * @param \DateTime $startDate
     * @return Milestone
     */
    public function setStartDate($startDate) {
        $this->startDate = $startDate;
    
        return $this;
    }

    /**
     * Get startDate
     *
     * @return \DateTime 
     */
    public function getStartDate() {
        return $this->startDate;
    }

    /**
     * Set endDate
     *
     * @param \DateTime $endDate
     * @return Milestone
     */
    public function setEndDate($endDate) {
        $this->endDate = $endDate;
    
        return $this;
    }

    /**
     * Get endDate
     *
     * @return \DateTime 
     */
    public function getEndDate() {
        return $this->endDate;
    }

    /**
     * Set color
     *
     * @param string $color
     * @return Milestone
     */
    public function setColor($color) {
        $this->color = $color;
    
        return $this;
    }

    /**
     * Get color
     *
     * @return string 
     */
    public function getColor() {
        return $this->color;
    }

    /**
     * Set milestonePlan
     *
     * @param \PRO4\MilestoneBundle\Entity\MilestonePlan $milestonePlan
     * @return Milestone
     */
    public function setMilestonePlan(\PRO4\MilestoneBundle\Entity\MilestonePlan $milestonePlan = null) {
        $this->milestonePlan = $milestonePlan;
    
        return $this;
    }

    /**
     * Get milestonePlan
     *
     * @return \PRO4\MilestoneBundle\Entity\MilestonePlan 
     */
    public function getMilestonePlan() {
        return $this->milestonePlan;
    }
}