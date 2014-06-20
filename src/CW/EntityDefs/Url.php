<?php

namespace CW\Entities;

/**
 * @Entity (repositoryClass="CW\Repositories\Url")
 */
class Url {
	
	/**
	 * @Id
	 * @Column(type="integer") @GeneratedValue
	 */
	private $id;
	
	/** @Column(type="string") */
	private $url;
	
	/**
	 * @ManyToOne(targetEntity="UrlType")
	 * @JoinColumn(name="type_id", referencedColumnName="id")
	 */
	private $type;
	
	/**
	 * @ManyToOne(targetEntity="Human", inversedBy="urls")
	 * @JoinColumn(name="human_id", referencedColumnName="id")
	 */
	private $human;
	
	/**
	 * @ManyToOne(targetEntity="Company", inversedBy="urls")
	 * @JoinColumn(name="company_id", referencedColumnName="id")
	 */
	private $company;
	
}
