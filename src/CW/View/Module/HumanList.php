<?php

namespace CW\View\Module;

class HumanList extends \CW\View\Base {
	
	protected function init() {
		$this->registerJsFile('views/module/HumanList.js');
		$this->registerCssFile('module/HumanList.css');
	}

	protected function getTemplateData() {
		$result = array(
			'humans' => $this->app['api']['misc']->getHumans()
		);
		$this->app['debugger']->registerDebugVar($result, 'getTemplateData');
		return $result;
	}

}
