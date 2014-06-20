<?php

namespace CW\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * HumanJobLead
 */
class HumanJobLead
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $date_presented;

    /**
     * @var \CW\Entities\Human
     */
    private $human;

    /**
     * @var \CW\Entities\JobLead
     */
    private $jobLead;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set date_presented
     *
     * @param \DateTime $datePresented
     * @return HumanJobLead
     */
    public function setDatePresented($datePresented)
    {
        $this->date_presented = $datePresented;
    
        return $this;
    }

    /**
     * Get date_presented
     *
     * @return \DateTime 
     */
    public function getDatePresented()
    {
        return $this->date_presented;
    }

    /**
     * Set human
     *
     * @param \CW\Entities\Human $human
     * @return HumanJobLead
     */
    public function setHuman(\CW\Entities\Human $human = null)
    {
        $this->human = $human;
    
        return $this;
    }

    /**
     * Get human
     *
     * @return \CW\Entities\Human 
     */
    public function getHuman()
    {
        return $this->human;
    }

    /**
     * Set jobLead
     *
     * @param \CW\Entities\JobLead $jobLead
     * @return HumanJobLead
     */
    public function setJobLead(\CW\Entities\JobLead $jobLead = null)
    {
        $this->jobLead = $jobLead;
    
        return $this;
    }

    /**
     * Get jobLead
     *
     * @return \CW\Entities\JobLead 
     */
    public function getJobLead()
    {
        return $this->jobLead;
    }
}
