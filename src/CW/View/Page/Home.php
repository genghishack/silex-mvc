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
		
		// $this->app['api']['misc']->populate();
		// $this->app['api']['misc']->depopulate();
		
		// $this->app['api']['misc']->getCompanies();
		// $this->app['api']['misc']->getEmails();
		// $this->app['api']['misc']->getFirstEmail();
		
	}
	
	protected function getTemplateData() {
		$result = array(
			'humans' => $this->app['api']['misc']->getHumans()
		);
		$this->app['debugger']->registerDebugVar($result, 'getTemplateData');
		return $result;
	}

}
