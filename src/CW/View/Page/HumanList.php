<?php

namespace CW\View\Page;

class HumanList extends \CW\View\Base
{
	protected function init() {
		
		$args = array(
			'pageName' => 'HumanList'
		);
		
		$this->registerModule('HumanList');
		
	}
	
	protected function getTemplateData() {
		return array(
			'HumanList' => $this->HumanList
		);
	}

}
