<?php

namespace CW\View;

use Silex\Application;

abstract class Base
{
	protected $app;
	protected $args;
	protected $label;
	protected $templateLabel;
	protected $arrViews = array();

	function __construct(Application &$app, $args=array(), $strLabel='') {
		$this->app = $app;
		$this->args = (is_array($args)) ? $args : array();
		$this->label = $this->templateLabel = $strLabel;
		
		// $this->app['debugger']->registerPerformance("{$this->label} module", PERFORMANCE_START);

		foreach ($this->args as $key => $value) {
			$this->$key = $value;
		}

		$this->init();
		forEach($this->arrViews as $strLabel => $objView) {
			$this->$strLabel = $objView->render();
		}
		// return $this->render(); // Questionable.  Do I want to call this from outside?
	}

	protected function init() {
		/*
		 * use init to:
		 * 
		 * - register child views with $this->registerView() or $this->registerModule()
		 * - register associated css file(s) with $this->registerCssFile()
		 * - register leading or trailing css (to be inserted before/after the css files) 
		 *   with $this->registerCssLeading() or $this->registerCssTrailing()
		 * - register associated js file(s) with $this->registerJsFile()
		 * - register leading or trailing js (to be inserted before/after the js files)
		 *   with $this->registerJsLeading() or $this->registerJsTrailing()
		 * 
		 * init need not be implemented if there are no child modules or associated css/js.
		 */
		
		// TODO: Implement getting associated js and css files by naming convention
	}

	protected function getTemplateData() {
		/**
		 * use getTemplateData to call whatever functions you need to create the data array
		 * to be passed into the template for this module.  Return the resulting array
		 */
		 return array();
	}
	
	protected function registerPage($strLabel, $args=array()) {
		$strViewLabel = "\\CW\\View\\Page\\{$strLabel}";
		$args['type'] = 'Page';
		$this->arrViews[$strLabel] = new $strViewLabel($this->app, array_merge($this->args, $args), $strLabel);
	}
	
	protected function registerModule($strLabel, $args=array()) {
		$strViewLabel = "\\CW\\View\\Module\\{$strLabel}";
		$args['type'] = 'Module';
		$this->arrViews[$strLabel] = new $strViewLabel($this->app, array_merge($this->args, $args), $strLabel);
	}
	
	protected function registerView($strLabel, $args=array()) {
		$strViewLabel = "\\CW\\View\\{$strLabel}";
		$args['type'] = '';
		$this->arrViews[$strLabel] = new $strViewLabel($this->app, array_merge($this->args, $args), $strLabel);
	}

	protected function registerCssFile($arrFileNames) {
		$this->app['page']->registerCssFile($arrFileNames, $this->label);
	}
	
	protected function registerJsFile($arrFileNames) {
		$this->app['page']->registerJsFile($arrFileNames, $this->label);
	}
	
	public function render() {
		$templateLocation = '';
		if (isset($this->args['type']) && '' != $this->args['type']) {
			$templateLocation = strtolower($this->args['type']) . '/';
		}
		// $data = $this->app['twig']->render("{$templateLocation}{$this->templateLabel}.twig", $this->getTemplateData());
		$data = $this->app['mustache']->render("{$templateLocation}{$this->templateLabel}", $this->getTemplateData());

		// print_r($this->getTemplateData());		
		// $this->app['debugger']->registerPerformance("{$this->label} module", PERFORMANCE_STOP);
		return $data;
	}

	protected function getRevisionString() {
		$revisionFile = __DIR__.'/../../../REVISION';
		$revision = null;
		if (is_readable($revisionFile)) {
			$revision = trim(file_get_contents($revisionFile));
		}

		$versionQueryString = $revision ? '?v='. $revision : '?v=0';

		return $versionQueryString;
	}
}
