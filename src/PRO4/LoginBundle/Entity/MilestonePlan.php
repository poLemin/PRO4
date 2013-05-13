<?php

namespace PRO4\LoginBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MilestonePlan
 *
 * @ORM\Table(name="milestone_plan")
 * @ORM\Entity
 */
class MilestonePlan
{
    /**
     * @var integer
     *
     * @ORM\Column(name="milestone_plan_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $milestonePlanId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_date", type="date", nullable=false)
     */
    private $startDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_date", type="date", nullable=false)
     */
    private $endDate;

    /**
     * @var \Project
     *
     * @ORM\OneToOne(targetEntity="Project")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="project_id", referencedColumnName="project_id")
     * })
     */
    private $project;



    /**
     * Get milestonePlanId
     *
     * @return integer 
     */
    public function getMilestonePlanId()
    {
        return $this->milestonePlanId;
    }

    /**
     * Set startDate
     *
     * @param \DateTime $startDate
     * @return MilestonePlan
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
    
        return $this;
    }

    /**
     * Get startDate
     *
     * @return \DateTime 
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set endDate
     *
     * @param \DateTime $endDate
     * @return MilestonePlan
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
    
        return $this;
    }

    /**
     * Get endDate
     *
     * @return \DateTime 
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set project
     *
     * @param \PRO4\LoginBundle\Entity\Project $project
     * @return MilestonePlan
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