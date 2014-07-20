<?php

namespace CW\View\Page;

class Home extends \CW\View\Base
{
	protected function init() {
		
		$args = array(
			'pageName' => 'Home'
		);
		
		$this->registerJsFile(
			'views/page/home.js'
		);
		
		$this->registerCssFile(array(
			'page/home.css',
			'modal.css'
		));
		
	}
	
	protected function getTemplateData() {
		return array(
		);
	}

}
