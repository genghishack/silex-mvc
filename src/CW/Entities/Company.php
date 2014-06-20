<?php

namespace CW\Entities;

/**
 * @Entity (repositoryClass="CW\Repositories\Company")
 */
class Company {
	
	/**
	 * @Id
	 * @Column(type="integer") @GeneratedValue
	 */
	private $id;
	
	/** @Column(type="string", length=100) */
	private $name;
	
	/**
	 * @OneToOne(targetEntity="Recruiter", mappedBy="company")
	 */
	private $recruiter;
	
	/**
	 * @OneToMany(targetEntity="JobLead", mappedBy="company")
	 */
	private $jobLeads;
	
	/** 
	 * @OneToMany(targetEntity="HumanXCompany", mappedBy="company") 
	 */
	private $humans;
	
	/**
	 * @OneToMany(targetEntity="Phone", mappedBy="company")
	 */
	private $phones;
	
	/**
	 * @OneToMany(targetEntity="Email", mappedBy="company")
	 */
	private $emails;
	
	/**
	 * @OneToMany(targetEntity="Url", mappedBy="company")
	 */
	private $urls;
	
	/**
	 * @OneToMany(targetEntity="Note", mappedBy="company")
	 */	
	private $notes;
	
	/**
	 * @return array
	 */	
	public function toArray()
	{
		return array(
			'id' => $this->id,
			'name' => $this->name
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
        $this->jobLeads = new \Doctrine\Common\Collections\ArrayCollection();
        $this->humans = new \Doctrine\Common\Collections\ArrayCollection();
        $this->phones = new \Doctrine\Common\Collections\ArrayCollection();
        $this->emails = new \Doctrine\Common\Collections\ArrayCollection();
        $this->urls = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return Company
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
     * Set recruiter
     *
     * @param \CW\Entities\Recruiter $recruiter
     * @return Company
     */
    public function setRecruiter(\CW\Entities\Recruiter $recruiter = null)
    {
        $this->recruiter = $recruiter;
    
        return $this;
    }

    /**
     * Get recruiter
     *
     * @return \CW\Entities\Recruiter 
     */
    public function getRecruiter()
    {
        return $this->recruiter;
    }

    /**
     * Add jobLeads
     *
     * @param \CW\Entities\JobLead $jobLeads
     * @return Company
     */
    public function addJobLead(\CW\Entities\JobLead $jobLeads)
    {
        $this->jobLeads[] = $jobLeads;
    
        return $this;
    }

    /**
     * Remove jobLeads
     *
     * @param \CW\Entities\JobLead $jobLeads
     */
    public function removeJobLead(\CW\Entities\JobLead $jobLeads)
    {
        $this->jobLeads->removeElement($jobLeads);
    }

    /**
     * Get jobLeads
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getJobLeads()
    {
        return $this->jobLeads;
    }

    /**
     * Add humans
     *
     * @param \CW\Entities\HumanXCompany $humans
     * @return Company
     */
    public function addHuman(\CW\Entities\HumanXCompany $humans)
    {
        $this->humans[] = $humans;
    
        return $this;
    }

    /**
     * Remove humans
     *
     * @param \CW\Entities\HumanXCompany $humans
     */
    public function removeHuman(\CW\Entities\HumanXCompany $humans)
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
     * Add phones
     *
     * @param \CW\Entities\Phone $phones
     * @return Company
     */
    public function addPhone(\CW\Entities\Phone $phones)
    {
        $this->phones[] = $phones;
    
        return $this;
    }

    /**
     * Remove phones
     *
     * @param \CW\Entities\Phone $phones
     */
    public function removePhone(\CW\Entities\Phone $phones)
    {
        $this->phones->removeElement($phones);
    }

    /**
     * Get phones
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPhones()
    {
        return $this->phones;
    }

    /**
     * Add emails
     *
     * @param \CW\Entities\Email $emails
     * @return Company
     */
    public function addEmail(\CW\Entities\Email $emails)
    {
        $this->emails[] = $emails;
    
        return $this;
    }

    /**
     * Remove emails
     *
     * @param \CW\Entities\Email $emails
     */
    public function removeEmail(\CW\Entities\Email $emails)
    {
        $this->emails->removeElement($emails);
    }

    /**
     * Get emails
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEmails()
    {
        return $this->emails;
    }

    /**
     * Add urls
     *
     * @param \CW\Entities\Url $urls
     * @return Company
     */
    public function addUrl(\CW\Entities\Url $urls)
    {
        $this->urls[] = $urls;
    
        return $this;
    }

    /**
     * Remove urls
     *
     * @param \CW\Entities\Url $urls
     */
    public function removeUrl(\CW\Entities\Url $urls)
    {
        $this->urls->removeElement($urls);
    }

    /**
     * Get urls
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUrls()
    {
        return $this->urls;
    }

    /**
     * Add notes
     *
     * @param \CW\Entities\Note $notes
     * @return Company
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