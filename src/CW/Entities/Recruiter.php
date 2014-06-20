<?php

namespace CW\Entities;

/**
 * @Entity (repositoryClass="CW\Repositories\Recruiter")
 */
class Recruiter {
	
	/**
	 * @Id
	 * @Column(type="integer") @GeneratedValue
	 */
	private $id;
	
	/** 
	 * @OneToOne(targetEntity="Company", inversedBy="recruiter")
	 */	
	private $company;
	
	/**
	 * @OneToMany(targetEntity="Note", mappedBy="recruiter")
	 */	
	private $notes;
	
	/******************
	 * Auto-generated *
	 ******************/
	 
    /**
     * Constructor
     */
    public function __construct()
    {
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
     * Set company
     *
     * @param \CW\Entities\Company $company
     * @return Recruiter
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
     * @return Recruiter
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