<?php

namespace CW\View\Page;

class Home extends \CW\View\Base
{
	protected function init() {
		
		$args = array(
			'pageName' => 'Home'
		);
		
		$this->registerModule('HumanList');
		
		$this->registerJsFile(
			'views/page/home.js'
		);
		
		$this->registerCssFile(array(
			'page/home.css',
			'modal.css'
		));
		
		// $this->app['api']['misc']->populate();
		// $this->app['api']['misc']->depopulate();
		
		// $this->app['api']['misc']->getCompanies();
		// $this->app['api']['misc']->getEmails();
		// $this->app['api']['misc']->getFirstEmail();
		
	}
	
	protected function getTemplateData() {
		return array(
			'HumanList' => $this->HumanList
		);
	}

}
