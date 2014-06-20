<?php

namespace CW\Entities;

/**
 * @Entity (repositoryClass="CW\Repositories\Human")
 */
class Human {
	
	/**
	 * @Id
	 * @Column(type="integer") @GeneratedValue
	 */
	private $id;
	
	/** @Column(type="string", length=50) */
	private $name_first;
	
	/** @Column(type="string", length=50) */
	private $name_middle;
	
	/** @Column(type="string", length=50) */
	private $name_last;
	
	/**
	 * @OneToMany(targetEntity="HumanXCompany", mappedBy="human")
	 */	
	private $companys;

	/**
	 * @OneToMany(targetEntity="HumanXJobLead", mappedBy="human")
	 */	
	private $jobLeads;

	/**
	 * @OneToMany(targetEntity="Phone", mappedBy="human")
	 */
	private $phones;
	
	/**
	 * @OneToMany(targetEntity="Email", mappedBy="human")
	 */
	private $emails;
	
	/**
	 * @OneToMany(targetEntity="Url", mappedBy="human")
	 */
	private $urls;
	
	/**
	 * @OneToMany(targetEntity="Note", mappedBy="human")
	 */	
	private $notes;
	
	/**
	 * @return array
	 */
	public function toArray()
	{
		return array(
			'id' => $this->id,
			'name_first' => $this->name_first,
			'name_middle' => $this->name_middle,
			'name_last' => $this->name_last
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
        $this->companys = new \Doctrine\Common\Collections\ArrayCollection();
        $this->jobLeads = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name_first
     *
     * @param string $nameFirst
     * @return Human
     */
    public function setNameFirst($nameFirst)
    {
        $this->name_first = $nameFirst;
    
        return $this;
    }

    /**
     * Get name_first
     *
     * @return string 
     */
    public function getNameFirst()
    {
        return $this->name_first;
    }

    /**
     * Set name_middle
     *
     * @param string $nameMiddle
     * @return Human
     */
    public function setNameMiddle($nameMiddle)
    {
        $this->name_middle = $nameMiddle;
    
        return $this;
    }

    /**
     * Get name_middle
     *
     * @return string 
     */
    public function getNameMiddle()
    {
        return $this->name_middle;
    }

    /**
     * Set name_last
     *
     * @param string $nameLast
     * @return Human
     */
    public function setNameLast($nameLast)
    {
        $this->name_last = $nameLast;
    
        return $this;
    }

    /**
     * Get name_last
     *
     * @return string 
     */
    public function getNameLast()
    {
        return $this->name_last;
    }

    /**
     * Add companys
     *
     * @param \CW\Entities\HumanXCompany $companys
     * @return Human
     */
    public function addCompany(\CW\Entities\HumanXCompany $companys)
    {
        $this->companys[] = $companys;
    
        return $this;
    }

    /**
     * Remove companys
     *
     * @param \CW\Entities\HumanXCompany $companys
     */
    public function removeCompany(\CW\Entities\HumanXCompany $companys)
    {
        $this->companys->removeElement($companys);
    }

    /**
     * Get companys
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCompanys()
    {
        return $this->companys;
    }

    /**
     * Add jobLeads
     *
     * @param \CW\Entities\HumanXJobLead $jobLeads
     * @return Human
     */
    public function addJobLead(\CW\Entities\HumanXJobLead $jobLeads)
    {
        $this->jobLeads[] = $jobLeads;
    
        return $this;
    }

    /**
     * Remove jobLeads
     *
     * @param \CW\Entities\HumanXJobLead $jobLeads
     */
    public function removeJobLead(\CW\Entities\HumanXJobLead $jobLeads)
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
     * Add phones
     *
     * @param \CW\Entities\Phone $phones
     * @return Human
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
     * @return Human
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
     * @return Human
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
     * @return Human
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