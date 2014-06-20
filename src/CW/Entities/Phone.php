<?php

namespace CW\Entities;

/**
 * @Entity (repositoryClass="CW\Repositories\Phone")
 */
class Phone {
	
	/**
	 * @Id
	 * @Column(type="integer") @GeneratedValue
	 */
	private $id;
	
	/** @Column(type="integer") */
	private $isd;
	
	/** @Column(type="integer") */
	private $area;
	
	/** @Column(type="integer") */
	private $prefix;
	
	/** @Column(type="integer") */
	private $suffix;
	
	/** @Column(type="integer", nullable=true) */
	private $extension;
	
	/**
	 * @ManyToOne(targetEntity="PhoneType")
	 * @JoinColumn(name="type_id", referencedColumnName="id")
	 */
	private $type;
	
	/**
	 * @ManyToOne(targetEntity="Human", inversedBy="phones")
	 * @JoinColumn(name="human_id", referencedColumnName="id")
	 */
	private $human;
	
	/**
	 * @ManyToOne(targetEntity="Company", inversedBy="phones")
	 * @JoinColumn(name="company_id", referencedColumnName="id")
	 */
	private $company;
	
    /**
     * @return array
     */
	public function toArray() {
		return array(
			'id' => $this->id,
			'isd' => $this->isd,
			'area' => $this->area,
			'prefix' => $this->prefix,
			'suffix' => $this->suffix,
			'extension' => $this->extension
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
     * Set isd
     *
     * @param integer $isd
     * @return Phone
     */
    public function setIsd($isd)
    {
        $this->isd = $isd;
    
        return $this;
    }

    /**
     * Get isd
     *
     * @return integer 
     */
    public function getIsd()
    {
        return $this->isd;
    }

    /**
     * Set area
     *
     * @param integer $area
     * @return Phone
     */
    public function setArea($area)
    {
        $this->area = $area;
    
        return $this;
    }

    /**
     * Get area
     *
     * @return integer 
     */
    public function getArea()
    {
        return $this->area;
    }

    /**
     * Set prefix
     *
     * @param integer $prefix
     * @return Phone
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;
    
        return $this;
    }

    /**
     * Get prefix
     *
     * @return integer 
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * Set suffix
     *
     * @param integer $suffix
     * @return Phone
     */
    public function setSuffix($suffix)
    {
        $this->suffix = $suffix;
    
        return $this;
    }

    /**
     * Get suffix
     *
     * @return integer 
     */
    public function getSuffix()
    {
        return $this->suffix;
    }

    /**
     * Set extension
     *
     * @param integer $extension
     * @return Phone
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;
    
        return $this;
    }

    /**
     * Get extension
     *
     * @return integer 
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * Set type
     *
     * @param \CW\Entities\PhoneType $type
     * @return Phone
     */
    public function setType(\CW\Entities\PhoneType $type = null)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return \CW\Entities\PhoneType 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set human
     *
     * @param \CW\Entities\Human $human
     * @return Phone
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
     * @return Phone
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