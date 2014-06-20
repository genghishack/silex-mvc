<?php

namespace CW\Entities;

/**
 * @Entity (repositoryClass="CW\Repositories\Email")
 */
class Email {
	
	/**
	 * @Id
	 * @Column(type="integer") @GeneratedValue
	 */
	private $id;
	
	/** @Column(type="string") */
	private $email;
	
	/**
	 * @ManyToOne(targetEntity="EmailType")
	 * @JoinColumn(name="type_id", referencedColumnName="id")
	 */
	private $type;
	
	/**
	 * @ManyToOne(targetEntity="Human", inversedBy="emails")
	 * @JoinColumn(name="human_id", referencedColumnName="id")
	 */
	private $human;
	
	/**
	 * @ManyToOne(targetEntity="Company", inversedBy="emails")
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
			'email' => $this->email
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
     * Set email
     *
     * @param string $email
     * @return Email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set type
     *
     * @param \CW\Entities\EmailType $type
     * @return Email
     */
    public function setType(\CW\Entities\EmailType $type = null)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return \CW\Entities\EmailType 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set human
     *
     * @param \CW\Entities\Human $human
     * @return Email
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
     * @return Email
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