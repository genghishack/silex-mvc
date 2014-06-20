<?php

namespace CW\View\Module;

class Footer extends \CW\View\Base {
	
	protected function init() {
		$this->registerJsFile('views/module/footer.js');
		$this->registerCssFile('module/footer.css');
	}
	
	protected function getTemplateData() {
		return array();
	}
	
}