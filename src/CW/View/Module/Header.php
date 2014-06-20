<?php

namespace CW\View\Module;

class Header extends \CW\View\Base {
	
	function init() {
		$this->registerJsFile('views/module/header.js');
		$this->registerCssFile('module/header.css');
	}
	
	function getTemplateData() {
		return $this->app['util']->browserSupport();
	}
	
}