<?php

namespace CW\Entities;

/**
 * @Entity (repositoryClass="CW\Repositories\PhoneType")
 */
class PhoneType {
	
	/**
	 * @Id
	 * @Column(type="integer") @GeneratedValue
	 */
	private $id;
	
	/** @Column(type="string", length=20) */
	private $label;
	
}
