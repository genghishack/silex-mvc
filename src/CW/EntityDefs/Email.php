<?php

namespace CW\Entities;

/**
 * @Entity (repositoryClass="CW\Repositories\Email")
 */
class Email {
	
	/**
	 * @Id
	 * @Column(type="integer") @GeneratedValue
	 */
	private $id;
	
	/** @Column(type="string") */
	private $email;
	
	/**
	 * @ManyToOne(targetEntity="EmailType")
	 * @JoinColumn(name="type_id", referencedColumnName="id")
	 */
	private $type;
	
	/**
	 * @ManyToOne(targetEntity="Human", inversedBy="emails")
	 * @JoinColumn(name="human_id", referencedColumnName="id")
	 */
	private $human;
	
	/**
	 * @ManyToOne(targetEntity="Company", inversedBy="emails")
	 * @JoinColumn(name="company_id", referencedColumnName="id")
	 */
	private $company;
	
}
