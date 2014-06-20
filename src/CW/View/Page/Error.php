<?php

namespace CW\View\Page;

class Error extends \CW\View\Base
{
	protected function init() {
	}

	function getTemplateData() {
		return array(
			'message' => $this->errorType()
		);

		return $data;
	}

	private function errorType() {
		switch ($this->args['code']) {
			case '404':
				return $this->error404();
			default:
				return $this->errorGeneric();
		}
	}

	private function error404() {
		return array(
			'type' => $this->args['code'],
			'message' => 'The page you requested could not be found.'
		);
	}

	private function errorGeneric() {
		return array(
			'type' => $this->args['code'],
			'message' => 'There was an error loading the page you requested.'
		);
	}
}
