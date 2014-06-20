<?php

namespace CW\Entities;

/**
 * @Entity (repositoryClass="CW\Repositories\EmailType")
 */
class EmailType {
	
	/**
	 * @Id
	 * @Column(type="integer") @GeneratedValue
	 */
	private $id;
	
	/** @Column(type="string", length=20) */
	private $label;
	
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
     * Set label
     *
     * @param string $label
     * @return EmailType
     */
    public function setLabel($label)
    {
        $this->label = $label;
    
        return $this;
    }

    /**
     * Get label
     *
     * @return string 
     */
    public function getLabel()
    {
        return $this->label;
    }
}