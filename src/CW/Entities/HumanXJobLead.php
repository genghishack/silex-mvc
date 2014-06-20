<?php

namespace CW\Entities;

/**
 * @Entity (repositoryClass="CW\Repositories\Human_JobLead")
 */
class HumanXJobLead {
	
	/**
	 * @Id
	 * @Column(type="integer") @GeneratedValue
	 */
	private $id;
	
	/** @Column(type="datetime", name="date_presented", nullable=true) */
	private $date_presented;
	
	/**
	 * @ManyToOne(targetEntity="Human", inversedBy="jobLeads")
	 * @JoinColumn(name="human_id", referencedColumnName="id")
	 */
	private $human;
	
	/**
	 * @ManyToOne(targetEntity="JobLead", inversedBy="humans")
	 * @JoinColumn(name="jobLead_id", referencedColumnName="id")
	 */
	private $jobLead;
	
	/******************
	 * Auto-generated *
	 ******************/
	 
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
     * @return HumanXJobLead
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
     * @return HumanXJobLead
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
     * @return HumanXJobLead
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