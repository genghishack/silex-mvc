<?php

namespace CW\Service\Debug;

class DebugService
{
	protected $app;

	protected $arrDebugVars = array();
	protected $arrPerformance = array();

	protected $blnDebug = false;

	/**
	 * Constructor
	 */
	public function __construct($app) {
		$this->app = $app;

		if (($app['debug'] == true
		|| (isset($_GET['debug']) && $_GET['debug'] == 'on'))
		&& $app['env'] != 'prod')
		// if ((isset($_GET['debug']) && $_GET['debug'] == 'on')
		// && $app['env'] != 'prod')
		{
			$this->blnDebug = true;
		}
	}

	public function registerPerformance($label, $start) {
		// TODO: proper error handling if params are incorrectly passed

		if ($this->getDebug()) {
			$startStop = ($start) ? 'start' : 'stop';
			
			if (!isset($this->arrPerformance[$label])) {
				$this->arrPerformance[$label] = array(
					'label' => $label
				);
			}
			$this->arrPerformance[$label][$startStop] = microtime();
		}
	}

	public function calculatePerformance() {
		foreach ($this->arrPerformance as &$arrItem)
		{
			$arrItem['total'] = '--';

			if (!empty($arrItem['start']) && !empty($arrItem['stop']))
			{
				list($uStart, $sStart) = explode(' ', $arrItem['start']);
				$arrItem['start'] = bcadd($uStart, $sStart, 7);

				list($uStop, $sStop) = explode(' ', $arrItem['stop']);
				$arrItem['stop'] = bcadd($uStop, $sStop, 7);

				$arrItem['total'] = bcsub($arrItem['stop'], $arrItem['start'], 7);
			}

			if (empty($arrItem['start'])) {
				$arrItem['start'] = '--';
			} else {
				$arrItem['start'] = date('H:i:s', $arrItem['start']) . " (+$uStart)";
			}

			if (empty($arrItem['stop'])) {
				$arrItem['stop'] = '--';
			} else {
				$arrItem['stop'] = date('H:i:s', $arrItem['stop']) . " (+$uStop)";
			}
		}
		
		return array_values($this->arrPerformance);
	}

	public function registerDebugVar($var, $title='var', $expand=false) {
		// TODO: proper error handling if someone passes params in the wrong order
		
		if ($this->getDebug()) {
			if (isset($this->arrDebugVars[$title])) {
				// TODO: something to keep var titles from overwriting others with the same name 
				// - add sequentual numbers in parens or something
			}
			$this->arrDebugVars[$title] = array(
				 'title' => $title
				,'data' => @d($var, true) // print_r is the only one of the three that will handle recursion
				,'expand' => $expand
			);
		}
	}

	/******************************
	 * Simple getters and setters
	 ******************************/

	public function getDebug() {
		return $this->blnDebug;
	}

	public function getDebugVars() {
		return array_values($this->arrDebugVars);
	}

}
?>
