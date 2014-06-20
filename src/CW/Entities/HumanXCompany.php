<?php

namespace CW\Entities;

/**
 * @Entity (repositoryClass="CW\Repositories\Human_Company")
 */
class HumanXCompany {
	
	/**
	 * @Id
	 * @Column(type="integer") @GeneratedValue
	 */
	private $id;
	
	/** @Column(type="string", nullable=true) */
	private $position;
	
	/** @Column(type="datetime", name="association_start", nullable=true) */
	private $association_start;
	
	/** @Column(type="datetime", name="association_end", nullable=true) */
	private $association_end;
	
	/**
	 * @ManyToOne(targetEntity="Human", inversedBy="companys")
	 * @JoinColumn(name="human_id", referencedColumnName="id")
	 */
	private $human;
	
	/**
	 * @ManyToOne(targetEntity="Company", inversedBy="humans")
	 * @JoinColumn(name="company_id", referencedColumnName="id")
	 */
	private $company;
	
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
     * Set position
     *
     * @param string $position
     * @return HumanXCompany
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
     * Set association_start
     *
     * @param \DateTime $associationStart
     * @return HumanXCompany
     */
    public function setAssociationStart($associationStart)
    {
        $this->association_start = $associationStart;
    
        return $this;
    }

    /**
     * Get association_start
     *
     * @return \DateTime 
     */
    public function getAssociationStart()
    {
        return $this->association_start;
    }

    /**
     * Set association_end
     *
     * @param \DateTime $associationEnd
     * @return HumanXCompany
     */
    public function setAssociationEnd($associationEnd)
    {
        $this->association_end = $associationEnd;
    
        return $this;
    }

    /**
     * Get association_end
     *
     * @return \DateTime 
     */
    public function getAssociationEnd()
    {
        return $this->association_end;
    }

    /**
     * Set human
     *
     * @param \CW\Entities\Human $human
     * @return HumanXCompany
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
     * @return HumanXCompany
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
}