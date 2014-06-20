<?php

namespace CW\View;

class Page extends \CW\View\Base
{
	protected function init() {
		
		$this->registerView('meta');
		$this->registerModule('Header', array('contentLabel' => $this->label));
		$this->registerModule('Footer', array('contentLabel' => $this->label));
		$this->registerPage($this->label);
		if ($this->app['debugger']->getDebug())
		{
			$this->registerView('Debug');
		}
		
	}
	
	protected function getTemplateData() {

		$strLabel = $this->label;
		$data = array(
			 'title'              => $this->app['page']->getTitle()
			,'metaTags'           => $this->meta
			,'header'             => $this->Header
			,'content'            => $this->$strLabel
			,'footer'             => $this->Footer
			,'versionQueryString' => $this->getRevisionString()
			,'use_min'            => ($this->app['use_min'])
			,'page'               => $strLabel
			,'debug'              => false
		);
		
		if ( !$this->app['use_min'] ) {
			$data['cssFiles'] = array_values( $this->app['page']->getCssFiles() );
			$data['jsFiles']  = array_values( $this->app['page']->getJsFiles() );
		}

		if ($this->app['debugger']->getDebug()) {
			$data['debug'] = true;
			$data['debugger'] = $this->Debug;
		}
		return $data;
	}

	public function render() {
		// $page = $this->app['twig']->render("Page.twig", $this->getTemplateData());
		$page = $this->app['mustache']->render("Page", $this->getTemplateData());
		return $page;
	}
}
