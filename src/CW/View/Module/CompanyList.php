<?php

namespace CW\View\Module;

class CompanyList extends \CW\View\Base {
	
	protected function init() {
		$this->registerJsFile('views/module/CompanyList.js');
		$this->registerCssFile('module/CompanyList.css');
	}

	protected function getTemplateData() {
		$result = array(
			'companies' => $this->app['api']['misc']->getCompanies()
		);
		$this->app['debugger']->registerDebugVar($result, 'getTemplateData');
		return $result;
	}

}
