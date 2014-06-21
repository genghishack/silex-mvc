<?php

namespace CW\View\Page;

class CompanyList extends \CW\View\Base
{
	protected function init() {
		
		$args = array(
			'pageName' => 'CompanyList'
		);
		
		$this->registerModule('CompanyList');
		
	}
	
	protected function getTemplateData() {
		return array(
			'CompanyList' => $this->CompanyList
		);
	}

}
