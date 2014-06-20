<?php

namespace CW\Entities;

/**
 * @Entity (repositoryClass="CW\Repositories\Recruiter")
 */
class Recruiter {
	
	/**
	 * @Id
	 * @Column(type="integer") @GeneratedValue
	 */
	private $id;
	
	/** 
	 * @OneToOne(targetEntity="Company", inversedBy="recruiter")
	 */	
	private $company;
	
	/**
	 * @OneToMany(targetEntity="Note", mappedBy="recruiter")
	 */	
	private $notes;
	
}
