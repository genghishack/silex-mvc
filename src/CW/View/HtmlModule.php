<?php

namespace CW\View;

class HtmlModule extends \CW\View\Base
{
	protected function init() {
		// print_r($this->args);
		$this->registerModule($this->label, $this->args);

		if ($this->app['debugger']->getDebug())
		{
			$this->registerView('Debug');
		}
	}
	
	protected function getTemplateData() {

		$strLabel = $this->label;
		$data = array(
			 'content'            => $this->$strLabel
			,'versionQueryString' => $this->getRevisionString()
			,'module'             => $strLabel
			,'cssFiles'           => array_values( $this->app['page']->getCssFiles() )
			,'jsFiles'            => array_values( $this->app['page']->getJsFiles() )
			,'debug'              => false
		);
		
		if ( !$this->app['use_min'] ) {
		}

		if ($this->app['debugger']->getDebug()) {
			$data['debug'] = true;
			$data['debugger'] = $this->Debug;
		}
		
		return $data;
	}

	public function render() {
		// $module = $this->app['twig']->render("Module.twig", $this->getTemplateData());
		$module = $this->app['mustache']->render("Module", $this->getTemplateData());
		return $module;
	}
}
