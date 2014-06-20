<?php

namespace CW\Controller\Page;

class Base
{
	protected $args = array();
	
	public function renderPage($strLabel, $args=array()) {
		// $this->app['debugger']->registerPerformance("$strLabel Page Render", PERFORMANCE_START);
		$page = new \CW\View\Page($this->app, $args, $strLabel);
		$renderedPage = $page->render();
		// $this->app['debugger']->registerPerformance("$strLabel Page Render", PERFORMANCE_STOP);
		return $renderedPage;
	}
	
	public function renderModule($strLabel, $args=array()) {
		$module = new \CW\View\Module($this->app, $args, $strLabel);
		return $module->render();
	}
	
}
