<?php

namespace CW\Entities;

/**
 * @Entity (repositoryClass="CW\Repositories\Human_Company")
 */
class HumanXCompany {
	
	/**
	 * @Id
	 * @Column(type="integer") @GeneratedValue
	 */
	private $id;
	
	/** @Column(type="string", nullable=true) */
	private $position;
	
	/** @Column(type="datetime", name="association_start", nullable=true) */
	private $association_start;
	
	/** @Column(type="datetime", name="association_end", nullable=true) */
	private $association_end;
	
	/**
	 * @ManyToOne(targetEntity="Human", inversedBy="companys")
	 * @JoinColumn(name="human_id", referencedColumnName="id")
	 */
	private $human;
	
	/**
	 * @ManyToOne(targetEntity="Company", inversedBy="humans")
	 * @JoinColumn(name="company_id", referencedColumnName="id")
	 */
	private $company;
	
}
