<?php

namespace CW\Entities;

/**
 * @Entity (repositoryClass="CW\Repositories\Human_JobLead")
 */
class HumanXJobLead {
	
	/**
	 * @Id
	 * @Column(type="integer") @GeneratedValue
	 */
	private $id;
	
	/** @Column(type="datetime", name="date_presented", nullable=true) */
	private $date_presented;
	
	/**
	 * @ManyToOne(targetEntity="Human", inversedBy="jobLeads")
	 * @JoinColumn(name="human_id", referencedColumnName="id")
	 */
	private $human;
	
	/**
	 * @ManyToOne(targetEntity="JobLead", inversedBy="humans")
	 * @JoinColumn(name="jobLead_id", referencedColumnName="id")
	 */
	private $jobLead;
	
}
