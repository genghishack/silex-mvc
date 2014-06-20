<?php

namespace CW\Entities;

/**
 * @Entity (repositoryClass="CW\Repositories\Note")
 */
class Note {
	
	/**
	 * @Id
	 * @Column(type="integer") @GeneratedValue
	 */
	private $id;
	
	/** @Column(type="text") */
	private $text;
	
	/** @Column(type="datetime") */
	private $created;
	
	/** @Column(type="datetime") */
	private $lastModified;
	
	/**
	 * @ManyToOne(targetEntity="NoteType")
	 * @JoinColumn(name="type_id", referencedColumnName="id")
	 */
	private $type;
	
	/**
	 * @ManyToOne(targetEntity="Human", inversedBy="notes")
	 * @JoinColumn(name="human_id", referencedColumnName="id")
	 */
	private $human;
	
	/**
	 * @ManyToOne(targetEntity="Company", inversedBy="notes")
	 * @JoinColumn(name="company_id", referencedColumnName="id")
	 */
	private $company;
	
	/**
	 * @ManyToOne(targetEntity="JobLead", inversedBy="notes")
	 * @JoinColumn(name="jobLead_id", referencedColumnName="id")
	 */
	private $jobLead;
	
}
