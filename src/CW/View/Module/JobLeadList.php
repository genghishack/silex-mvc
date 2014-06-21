<?php

namespace CW\View\Module;

class JobLeadList extends \CW\View\Base {
	
	protected function init() {
		$this->registerJsFile('views/module/JobLeadList.js');
		$this->registerCssFile('module/JobLeadList.css');
	}

	protected function getTemplateData() {
		$result = array(
			'jobLeads' => $this->app['api']['misc']->getJobLeads()
		);
		$this->app['debugger']->registerDebugVar($result, 'getTemplateData');
		return $result;
	}

}
