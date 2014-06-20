<?php

namespace CW\Entities;

/**
 * @Entity (repositoryClass="CW\Repositories\JobLead")
 */
class JobLead {
	
	/**
	 * @Id
	 * @Column(type="integer") @GeneratedValue
	 */
	private $id;
	
	/** @Column(type="string", length=50, nullable=true) */
	private $position;
	
	/** @Column(type="string", length=255, nullable=true) */
	private $salary;
	
	/** @Column(type="string", length=255, nullable=true) */
	private $status;
	
	/** @Column(type="string", length=255, nullable=true) */
	private $result;
	
	/**
	 * @ManyToOne(targetEntity="JobLeadType")
	 * @JoinColumn(name="type_id", referencedColumnName="id")
	 */
	private $type;
	
	/**
	 * @OneToMany(targetEntity="HumanXJobLead", mappedBy="jobLead")
	 */	
	private $humans;

	/**
	 * @ManyToOne(targetEntity="Company", inversedBy="jobLeads")
	 * @JoinColumn(name="company_id", referencedColumnName="id")
	 */	
	private $company;

	/**
	 * @OneToMany(targetEntity="Note", mappedBy="jobLead")
	 */	
	private $notes;
	
	/**
	 * @return array
	 */
	public function toArray()
	{
		return array(
			'id' => $this->id,
			'position' => $this->position,
			'salary' => $this->salary,
			'status' => $this->status,
			'result' => $this->result
		);
	}
	
	/******************
	 * Auto-generated *
	 ******************/
	 
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->humans = new \Doctrine\Common\Collections\ArrayCollection();
        $this->notes = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
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
     * Set position
     *
     * @param string $position
     * @return JobLead
     */
    public function setPosition($position)
    {
        $this->position = $position;
    
        return $this;
    }

    /**
     * Get position
     *
     * @return string 
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set salary
     *
     * @param string $salary
     * @return JobLead
     */
    public function setSalary($salary)
    {
        $this->salary = $salary;
    
        return $this;
    }

    /**
     * Get salary
     *
     * @return string 
     */
    public function getSalary()
    {
        return $this->salary;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return JobLead
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set result
     *
     * @param string $result
     * @return JobLead
     */
    public function setResult($result)
    {
        $this->result = $result;
    
        return $this;
    }

    /**
     * Get result
     *
     * @return string 
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * Set type
     *
     * @param \CW\Entities\JobLeadType $type
     * @return JobLead
     */
    public function setType(\CW\Entities\JobLeadType $type = null)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return \CW\Entities\JobLeadType 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Add humans
     *
     * @param \CW\Entities\HumanXJobLead $humans
     * @return JobLead
     */
    public function addHuman(\CW\Entities\HumanXJobLead $humans)
    {
        $this->humans[] = $humans;
    
        return $this;
    }

    /**
     * Remove humans
     *
     * @param \CW\Entities\HumanXJobLead $humans
     */
    public function removeHuman(\CW\Entities\HumanXJobLead $humans)
    {
        $this->humans->removeElement($humans);
    }

    /**
     * Get humans
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getHumans()
    {
        return $this->humans;
    }

    /**
     * Set company
     *
     * @param \CW\Entities\Company $company
     * @return JobLead
     */
    public function setCompany(\CW\Entities\Company $company = null)
    {
        $this->company = $company;
    
        return $this;
    }

    /**
     * Get company
     *
     * @return \CW\Entities\Company 
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Add notes
     *
     * @param \CW\Entities\Note $notes
     * @return JobLead
     */
    public function addNote(\CW\Entities\Note $notes)
    {
        $this->notes[] = $notes;
    
        return $this;
    }

    /**
     * Remove notes
     *
     * @param \CW\Entities\Note $notes
     */
    public function removeNote(\CW\Entities\Note $notes)
    {
        $this->notes->removeElement($notes);
    }

    /**
     * Get notes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getNotes()
    {
        return $this->notes;
    }
}