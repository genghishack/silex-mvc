<?php

namespace CW\View;

class meta extends \CW\View\Base {
	
	function getTemplateData() {
		$arrMeta = array_merge($this->app['page.meta'], array(
			'og_type' => 'website'
			,'og_url' => "http://{$_SERVER['SERVER_NAME']}/"
		));
		return $arrMeta;
	}

}
