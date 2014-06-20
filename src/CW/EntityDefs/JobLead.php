<?php

namespace CW\Entities;

/**
 * @Entity (repositoryClass="CW\Repositories\JobLead")
 */
class JobLead {
	
	/**
	 * @Id
	 * @Column(type="integer") @GeneratedValue
	 */
	private $id;
	
	/** @Column(type="string", length=50, nullable=true) */
	private $position;
	
	/** @Column(type="string", length=255, nullable=true) */
	private $salary;
	
	/** @Column(type="string", length=255, nullable=true) */
	private $status;
	
	/** @Column(type="string", length=255, nullable=true) */
	private $result;
	
	/**
	 * @ManyToOne(targetEntity="JobLeadType")
	 * @JoinColumn(name="type_id", referencedColumnName="id")
	 */
	private $type;
	
	/**
	 * @OneToMany(targetEntity="HumanXJobLead", mappedBy="jobLead")
	 */	
	private $humans;

	/**
	 * @ManyToOne(targetEntity="Company", inversedBy="jobLeads")
	 * @JoinColumn(name="company_id", referencedColumnName="id")
	 */	
	private $company;

	/**
	 * @OneToMany(targetEntity="Note", mappedBy="jobLead")
	 */	
	private $notes;
	
}
