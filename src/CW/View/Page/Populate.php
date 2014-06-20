<?php

namespace CW\View\Page;

class Populate extends \CW\View\Base
{
	protected function init() {
		
		$args = array(
			'pageName' => 'Populate'
		);
		
		$this->app['api']['misc']->populate();
		$this->app['api']['misc']->getHumans();
		
	}

	protected function getTemplateData() {
		return array(
		);
	}

}
