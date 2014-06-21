<?php

namespace CW\Api;
use Doctrine\ORM\Query;
use Symfony\Component\HttpFoundation\Response;

class Misc extends Base
{
	protected function createHuman($args) {
		
		$human = new \CW\Entities\Human();
	
		// TODO: there should be some integrity check here to ensure 
		// the args have all the required data.
		$human->setNameFirst($args['nameFirst']);
		$human->setNameMiddle($args['nameMiddle']);
		$human->setNameLast($args['nameLast']);
		
		return $human;
	}
	
	protected function createCompany($args) {
		
		$company = new \CW\Entities\Company();
	
		// TODO: there should be some integrity check here to ensure 
		// the args have all the required data.
		$company->setName($args['name']);
		
		return $company;
	}

	protected function createJobLead($args) {
		
		$jobLead = new \CW\Entities\JobLead();
	
		// TODO: there should be some integrity check here to ensure 
		// the args have all the required data.
		$jobLead->setPosition($args['position']);
		$jobLead->setSalary($args['salary']);
		$jobLead->setStatus($args['status']);
		$jobLead->setResult($args['result']);
		$jobLead->setCompany($args['company']);
		
		return $jobLead;
	}
	
	protected function associateHumanToCompany($args) {
		
		$association = new \CW\Entities\HumanXCompany();
	
		// TODO: there should be some integrity check here to ensure 
		// the args have all the required data.
		$association->setHuman($args['human']);
		$association->setCompany($args['company']);
		$args['human']->addCompany($association);
		$args['company']->addHuman($association);
		
		return $association;
	}

	protected function associateHumanToJobLead($args) {
		
		$association = new \CW\Entities\HumanXJobLead();
	
		// TODO: there should be some integrity check here to ensure 
		// the args have all the required data.
		$association->setHuman($args['human']);
		$association->setJobLead($args['jobLead']);
		$args['human']->addJobLead($association);
		$args['jobLead']->addHuman($association);
		
		return $association;
	}
	
	protected function createEmail($args) {
		
		$email = new \CW\Entities\Email();
	
		// TODO: there should be some integrity check here to ensure 
		// the args have all the required data.
		$email->setEmail($args['email']);
		if (isset($args['human'])) {
			$email->setHuman($args['human']);
			$args['human']->addEmail($email);
		} else if (isset($args['company'])) {
			$email->setCompany($args['company']);
			$args['company']->addEmail($email);
		}
		
		return $email;
	}

	protected function createPhone($args) {
		
		$phone = new \CW\Entities\Phone();
	
		// TODO: there should be some integrity check here to ensure 
		// the args have all the required data.
		$phone->setIsd($args['isd']);
		$phone->setArea($args['area']);
		$phone->setPrefix($args['prefix']);
		$phone->setSuffix($args['suffix']);
		if (isset($args['human'])) {
			$phone->setHuman($args['human']);
			$args['human']->addPhone($phone);
		} else if (isset($args['company'])) {
			$phone->setCompany($args['company']);
			$args['company']->addPhone($phone);
		}
		
		return $phone;
	}
	
	public function populate() {

		// Create some Humans
		$human1 = $this->createHuman(array(
			'nameFirst' => 'Christopher',
			'nameMiddle' => 'M',
			'nameLast' => 'Wade'
		));
		
		$human2 = $this->createHuman(array(
			'nameFirst' => 'Feezlewacker',
			'nameMiddle' => 'J',
			'nameLast' => 'Snorfbutt'
		));
		
		// Create some companies 
		$company1 = $this->createCompany(array(
			'name' => 'Foobar, Inc.'
		));
		
		$company2 = $this->createCompany(array(
			'name' => 'Gizmo, LLC'
		));

		// Create an association between the second human and the first company
		$h2c1 = $this->associateHumanToCompany(array(
			'human' => $human2,
			'company' => $company1
		));

		// Create a job lead on the second company
		$jobLead1 = $this->createJobLead(array(
			'position' => 'CEO',
			'salary' => '$100,000',
			'status' => 'completed',
			'result' => 'hired',
			'company' => $company2
		));

		// map the lead to the second human
		$h2jl1 = $this->associateHumanToJobLead(array(
			'human' => $human2,
			'jobLead' => $jobLead1
		));
				
		// Create some email addresses and map them to humans and companies
		$email1 = $this->createEmail(array(
			'email' => 'genghishack@gmail.com',
			'human' => $human1
		));

		$email2 = $this->createEmail(array(
			'email' => 'test@example.com',
			'human' => $human2
		));

		$email3 = $this->createEmail(array(
			'email' => 'foo@bar.com',
			'company' => $company1
		));
		
		$email4 = $this->createEmail(array(
			'email' => 'bar@baz.com',
			'company' => $company2
		));
					
		// Create some phone numbers and map them to humans and companies
		$phone1 = $this->createPhone(array(
			'isd' => '1',
			'area' => '720',
			'prefix' => '329',
			'suffix' => '3675',
			'human' => $human1
		));

		$phone2 = $this->createPhone(array(
			'isd' => '1',
			'area' => '303',
			'prefix' => '555',
			'suffix' => '1212',
			'human' => $human2
		));

		$phone3 = $this->createPhone(array(
			'isd' => '1',
			'area' => '800',
			'prefix' => '111',
			'suffix' => '2222',
			'company' => $company1
		));

		$phone4 = $this->createPhone(array(
			'isd' => '1',
			'area' => '888',
			'prefix' => '123',
			'suffix' => '4567',
			'company' => $company2
		));

		// Persist everything and flush
		$this->em->persist($human1);
		$this->em->persist($human2);
		$this->em->persist($company1);
		$this->em->persist($company2);
		$this->em->persist($jobLead1);
		$this->em->persist($h2c1);
		$this->em->persist($h2jl1);
		$this->em->persist($email1);
		$this->em->persist($email2);
		$this->em->persist($email3);
		$this->em->persist($email4);
		$this->em->persist($phone1);
		$this->em->persist($phone2);
		$this->em->persist($phone3);
		$this->em->persist($phone4);
		$this->em->flush();
	}
	
	public function depopulate() {
		$humanQuery = $this->em->createQuery(
			"SELECT h 
			   FROM CW\Entities\Human h"
		);
		foreach ($humanQuery->getResult() as $human) {
			foreach($human->getEmails() as $email) {
				$human->removeEmail($email);
				$this->em->remove($email);
			}
			foreach($human->getPhones() as $phone) {
				$human->removePhone($phone);
				$this->em->remove($phone);
			}
			$this->em->remove($human);
		}
		
		$companyResult = $this->em->createQuery(
			"SELECT c
			   FROM CW\Entities\Company c"
		);
		foreach ($$companyQuery->getResult() as $company) {
			foreach($company->getEmails() as $email) {
				$company->removeEmail($email);
				$this->em->remove($email);
			}
			foreach($company->getPhones() as $phone) {
				$company->removePhone($phone);
				$this->em->remove($phone);
			}
			$this->em->remove($company);
		}
		
		$this->em->flush();
	}
	
	public function getJobLeads() {
		$query = $this->em->createQuery(
			"SELECT j
			   FROM CW\Entities\JobLead j"
		);
		
		$result = $query->getArrayResult();
		
		return $this->response($result);
	}
	
	public function getCompanies() {
		$query = $this->em->createQuery(
			"SELECT c
			   FROM CW\Entities\Company c"
		);

		// To get an array:
		// $result = $query->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
		// or
		// $result = $query->getArrayResult();
		$result = $query->getResult();
		
		$this->app['debugger']->registerDebugVar($result, "getCompanies");

		return $this->response($result);
	}
	
	public function getEmails() {
		$query = $this->em->createQuery(
			"SELECT e, t
			   FROM CW\Entities\Email e
			   JOIN e.type t"
		);
		
		$result = $query->getResult();

		$this->app['debugger']->registerDebugVar($result, "getEmails");

		return $this->response($result);
	}

	public function getFirstEmail() {
		$email = $this->em->find('CW\Entities\Email', 1);
		
		$this->app['debugger']->registerDebugVar($email, 'First Email');
		$this->app['debugger']->registerDebugVar($email->getType(), 'First Email Type');
		
	}	
	
	public function getHumans() {
		$query = $this->em->createQuery(
			"SELECT h, p, e, u, n, c, j
			   FROM CW\Entities\Human h
			   LEFT OUTER JOIN h.phones p
			   LEFT OUTER JOIN h.emails e
			   LEFT OUTER JOIN h.urls u
			   LEFT OUTER JOIN h.notes n
			   LEFT OUTER JOIN h.companys c
			   LEFT OUTER JOIN h.jobLeads j"
		);
		
		$objResult = $query->getResult();
		$arrResult = $query->getArrayResult();
		$response = array();

		foreach ($objResult as $human) {
			$responseElement = array(
				'id' => $human->getId(),
				'name_first' => $human->getNameFirst(),
				'name_middle' => $human->getNameMiddle(),
				'name_last' => $human->getNameLast(),
				'phones' => array(),
				'emails' => array(),
				'urls' => array(),
				'notes' => array(),
				'companys' => array(),
				'jobLeads' => array()
			);
			foreach($human->getPhones()->toArray() as $phone) {
				$responseElement['phones'][] = $phone->toArray();
			}
			foreach($human->getEmails()->toArray() as $email) {
				$responseElement['emails'][] = $email->toArray();
			}
			foreach($human->getUrls()->toArray() as $url) {
				$responseElement['urls'][] = $url->toArray();
			}
			foreach($human->getNotes()->toArray() as $note) {
				$responseElement['notes'][] = $note->toArray();
			}
			foreach($human->getCompanys()->toArray() as $humanXCompany) {
				$responseElement['companys'][] = $humanXCompany->getCompany()->toArray();
			}
			foreach($human->getJobLeads()->toArray() as $humanXJobLead) {
				$responseElement['jobLeads'][] = $humanXJobLead->getJobLead()->toArray();
			}
			$response[] = $responseElement;
		}
		// $this->app['debugger']->registerDebugVar($objResult, "getHumans Object");
		// $this->app['debugger']->registerDebugVar($arrResult, "getHumans Array");

		return $this->response($response);
	}

}
