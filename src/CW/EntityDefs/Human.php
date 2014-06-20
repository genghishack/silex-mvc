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
	
}
