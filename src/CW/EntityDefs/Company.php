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
		
}
