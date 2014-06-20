<?php

namespace CW\Service\Page;

class PageService
{
	protected $app;

	protected $strTitle = '';

	protected $arrMetaTags = array();
	protected $arrJsFiles = array();
	protected $arrCssFiles = array();

	/**
	 * Constructor
	 */
	public function __construct(&$app) {
		$this->app = &$app;
		$this->strTitle = $app['page.title'];
	}

	public function registerCssFile($arrFileNames, $strModuleName='') {
		if (!is_Array($arrFileNames)) {
			$arrFileNames = array($arrFileNames);
		}
		forEach($arrFileNames as $strFileName) {
			if (!in_array($strFileName, $this->arrCssFiles)) {
				$this->arrCssFiles[$strFileName] = array(
					'file'    => $strFileName,
					'module'  => $strModuleName
				);
			}
		}
	}

	public function registerJsFile($arrFileNames, $strModuleName='') {
		if (!is_Array($arrFileNames)) {
			$arrFileNames = array($arrFileNames);
		}
		forEach ($arrFileNames as $strFileName) {
			if (!in_array($strFileName, $this->arrJsFiles)) {
				$this->arrJsFiles[$strFileName] = array(
					'file' => $strFileName,
					'module' => $strModuleName
				);
			}
		}
	}

	public function registerMetaTag($args) {
		if (!is_array($args)) {
			$args = array($args);
		}
		$this->arrMetaTags[] = $args;
	}


	/******************************
	 * Simple getters and setters
	 ******************************/

	public function setTitle($string) {
		$this->strTitle = $string;
	}

	public function getTitle() {
		return $this->strTitle;
	}

	public function getCssFiles() {
		return $this->arrCssFiles;
	}
	
	public function getJsFiles() {
		return $this->arrJsFiles;
	}
	
	public function getMetaTags() {
		return $this->arrMetaTags;
	}
}
?>
