<?php

namespace CW\View;

include_once(__DIR__.'/../../php_browser_detection.php');

class Debug extends \CW\View\Base {
	
	function getTemplateData() {
		$foo =  array(
			 'DebugVars'   => $this->app['debugger']->getDebugVars()
			,'CompInfo'    => get_include_contents(__DIR__.'/../../your_computer_info.php')
			,'Performance' => $this->app['debugger']->calculatePerformance()
		);
		// print_r ($foo);
		return $foo;
	}
	
}