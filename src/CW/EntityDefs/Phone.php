<?php

namespace CW\Entities;

/**
 * @Entity (repositoryClass="CW\Repositories\Phone")
 */
class Phone {
	
	/**
	 * @Id
	 * @Column(type="integer") @GeneratedValue
	 */
	private $id;
	
	/** @Column(type="integer") */
	private $isd;
	
	/** @Column(type="integer") */
	private $area;
	
	/** @Column(type="integer") */
	private $prefix;
	
	/** @Column(type="integer") */
	private $suffix;
	
	/** @Column(type="integer", nullable=true) */
	private $extension;
	
	/**
	 * @ManyToOne(targetEntity="PhoneType")
	 * @JoinColumn(name="type_id", referencedColumnName="id")
	 */
	private $type;
	
	/**
	 * @ManyToOne(targetEntity="Human", inversedBy="phones")
	 * @JoinColumn(name="human_id", referencedColumnName="id")
	 */
	private $human;
	
	/**
	 * @ManyToOne(targetEntity="Company", inversedBy="phones")
	 * @JoinColumn(name="company_id", referencedColumnName="id")
	 */
	private $company;
	
}
