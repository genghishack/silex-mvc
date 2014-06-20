<?php

namespace CW\Entities;

/**
 * @Entity (repositoryClass="CW\Repositories\Url")
 */
class Url {
	
	/**
	 * @Id
	 * @Column(type="integer") @GeneratedValue
	 */
	private $id;
	
	/** @Column(type="string") */
	private $url;
	
	/**
	 * @ManyToOne(targetEntity="UrlType")
	 * @JoinColumn(name="type_id", referencedColumnName="id")
	 */
	private $type;
	
	/**
	 * @ManyToOne(targetEntity="Human", inversedBy="urls")
	 * @JoinColumn(name="human_id", referencedColumnName="id")
	 */
	private $human;
	
	/**
	 * @ManyToOne(targetEntity="Company", inversedBy="urls")
	 * @JoinColumn(name="company_id", referencedColumnName="id")
	 */
	private $company;
	
    /**
     * @return array
     */
	public function toArray()
	{
		return array(
			'id' => $this->id,
			'url' => $this->url
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
     * Set url
     *
     * @param string $url
     * @return Url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    
        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set type
     *
     * @param \CW\Entities\UrlType $type
     * @return Url
     */
    public function setType(\CW\Entities\UrlType $type = null)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return \CW\Entities\UrlType 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set human
     *
     * @param \CW\Entities\Human $human
     * @return Url
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
     * @return Url
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