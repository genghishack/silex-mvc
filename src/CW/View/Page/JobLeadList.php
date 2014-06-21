<?php

namespace CW\View\Page;

class JobLeadList extends \CW\View\Base
{
	protected function init() {
		
		$args = array(
			'pageName' => 'JobLeadList'
		);
		
		$this->registerModule('JobLeadList');
		
	}
	
	protected function getTemplateData() {
		return array(
			'JobLeadList' => $this->JobLeadList
		);
	}

}
