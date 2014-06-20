<?php

namespace CW\View\Page;

class Depopulate extends \CW\View\Base
{
	protected function init() {
		
		$args = array(
			'pageName' => 'Depopulate'
		);
		
		$this->app['api']['misc']->depopulate();
		$this->app['api']['misc']->getHumans();
		
	}

	protected function getTemplateData() {
		return array(
		);
	}

}
