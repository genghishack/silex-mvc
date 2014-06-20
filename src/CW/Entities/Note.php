<?php

namespace CW\Entities;

/**
 * @Entity (repositoryClass="CW\Repositories\Note")
 */
class Note {
	
	/**
	 * @Id
	 * @Column(type="integer") @GeneratedValue
	 */
	private $id;
	
	/** @Column(type="text") */
	private $text;
	
	/** @Column(type="datetime") */
	private $created;
	
	/** @Column(type="datetime") */
	private $lastModified;
	
	/**
	 * @ManyToOne(targetEntity="NoteType")
	 * @JoinColumn(name="type_id", referencedColumnName="id")
	 */
	private $type;
	
	/**
	 * @ManyToOne(targetEntity="Human", inversedBy="notes")
	 * @JoinColumn(name="human_id", referencedColumnName="id")
	 */
	private $human;
	
	/**
	 * @ManyToOne(targetEntity="Company", inversedBy="notes")
	 * @JoinColumn(name="company_id", referencedColumnName="id")
	 */
	private $company;
	
	/**
	 * @ManyToOne(targetEntity="JobLead", inversedBy="notes")
	 * @JoinColumn(name="jobLead_id", referencedColumnName="id")
	 */
	private $jobLead;
	
    /**
     * @return array
     */
	public function toArray()
	{
		return array(
			'id' => $this->id,
			'text' => $this->text,
			'created' => $this->created,
			'lastModified' => $this->lastModified
		);
	}
	
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
     * Set text
     *
     * @param string $text
     * @return Note
     */
    public function setText($text)
    {
        $this->text = $text;
    
        return $this;
    }

    /**
     * Get text
     *
     * @return string 
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Note
     */
    public function setCreated($created)
    {
        $this->created = $created;
    
        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set lastModified
     *
     * @param \DateTime $lastModified
     * @return Note
     */
    public function setLastModified($lastModified)
    {
        $this->lastModified = $lastModified;
    
        return $this;
    }

    /**
     * Get lastModified
     *
     * @return \DateTime 
     */
    public function getLastModified()
    {
        return $this->lastModified;
    }

    /**
     * Set type
     *
     * @param \CW\Entities\NoteType $type
     * @return Note
     */
    public function setType(\CW\Entities\NoteType $type = null)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return \CW\Entities\NoteType 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set human
     *
     * @param \CW\Entities\Human $human
     * @return Note
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
     * Set company
     *
     * @param \CW\Entities\Company $company
     * @return Note
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
     * Set jobLead
     *
     * @param \CW\Entities\JobLead $jobLead
     * @return Note
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