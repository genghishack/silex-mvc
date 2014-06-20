<?php

namespace CW\Entities;

/**
 * @Entity (repositoryClass="CW\Repositories\JobLeadType")
 */
class JobLeadType {
	
	/**
	 * @Id
	 * @Column(type="integer") @GeneratedValue
	 */
	private $id;
	
	/** @Column(type="string", length=20) */
	private $label;
	
}
